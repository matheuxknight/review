<?php

class WebDAVServer extends WebDAVServer1 
{
	///////////////////////////////////////////////////////////////
	
	function PROPFIND(&$options, &$files) 
	{
		$object = $this->path2Object($this->path);
		if(!$object) return false;

		if(!$this->rbac->objectAction($object))
			return false;
		
		$name = $this->path2Name($this->path);
		$parentname = $this->path2ParentName($this->path);
		
		$files["files"] = array();
		
		if($name == $this->indexfilename)
			$this->fileIndexInfo($files, $object);
			
		else if($name == $this->serverdirname)
			$this->dirServerInfo($files, $this->depth);

		else if($parentname == $this->serverdirname)
			$this->fileServerInfo($files, $name);

		else if($object->type == CMDB_OBJECTTYPE_FILE)
			$this->fileInfo($files, $object->file);

		else
			$this->dirInfo($files, $object, $this->depth);
			
		return true;
	}

	////////////////////////////////////////////////////////////////////

	function GET(&$options) 
	{
		$object = $this->path2Object($this->path);
		if(!$object) return false;
		
		if(!$this->rbac->objectAction($object))
			return false;
			
		$name = $this->path2Name($this->path);
		$parentname = $this->path2ParentName($this->path);
		
		if($name == $this->indexfilename)
		{
			$data = $this->wrapHTML($object->ext->doctext);
			
			$options['mimetype'] = 'text/html';
			$options['mtime'] = strtotime($object->updated);
			$options['size'] = strlen($data);
			$options['data'] = $data;
              
			return true;
		}	

		else if($parentname == $this->serverdirname)
		{
			$n = $this->findServerFile($name);
			if($n == -1)
			{
				$n = $this->findCssFile($name);
				if($n == -1) return false;
				
				$filename = $this->cssfiles[$n];
				if($filename == 'jquery-ui.css')
					$filepath = $this->csslocation2.$filename;
				else
					$filepath = $this->csslocation1.$filename;

				$file = new CFile($filepath);
				
				$options['mimetype'] = $file->mimetype;
				$options['mtime'] = $file->date;
				$options['size'] = $file->size;
				$options['stream'] = fopen($filepath, 'r');
			}
			
			else
			{
				$fieldname = $this->serverfields[$n];
				$data = $this->wrapHTML($this->server->$fieldname);
				
				$options['mimetype'] = 'text/html';
				$options['mtime'] = strtotime(now());
				$options['size'] = strlen($data);
				$options['data'] = $data;
			}
			return true;
		}	

		else if($object->type == CMDB_OBJECTTYPE_FILE)
		{
			$file = $object->file;
			
			$options['mimetype'] = $file->mimetype;
			$options['mtime'] = strtotime($file->updated);
			$options['size'] = $file->size;
			$options['stream'] = fopen(objectPathname($file), 'r');
              
			return true;
		}

		return false;
	}

	////////////////////////////////////////////////////////////////////

	function PUT(&$options) 
	{
		if(!empty($options["ranges"])) 
			return false;
			
		$parent = $this->path2Parent($this->path);
		if(!$parent) return false;
		
		if(!$this->rbac->objectAction($parent, 'create'))
			return false;

		///////////////////////////////////////////////////////
			
		$tmpname = gettempfile('.ext');
		@unlink($tmpname);

		$fp = fopen($tmpname, "w");
		while(!feof($options["stream"])) 
			fwrite($fp, fread($options["stream"], 4096));
				
		fclose($fp);

		$size = dos_filesize($tmpname);
		$name = $this->path2Name($this->path);
		$parentname = $this->path2ParentName($this->path);
		
		if($size) usleep(500000);
		
		///////////////////////////////////////////////////////

		$object = $this->path2Object($this->path);
		if(!$object)
		{
			$object = new Object;
			$object->type = CMDB_OBJECTTYPE_FILE;
			$object->name = $name;

			$object = objectInit($object, $parent->id);
			if(!$object) return false;
				
			$object->pathname = $object->id.getExtension($name);
			$object->save();
			
			$rfile = new File;
			$rfile->objectid = $object->id;
			$rfile->save();
		}
		
		////////////////////////////////////////////////////////
		
		if($name == $this->indexfilename)
		{
			$data = @file_get_contents($tmpname);
			$object->ext->doctext = $this->unwrapHTML($data);
			$object->ext->save();
			$object->save();

			@unlink($tmpname);
		}
		
		else if($parentname == $this->serverdirname)
		{
			$n = $this->findServerFile($name);
			if($n == -1)
			{
				$n = $this->findCssFile($name);
				if($n == -1) return false;
				
				$filename = $this->cssfiles[$n];
				if($filename == 'jquery-ui.css')
					$filepath = $this->csslocation2.$filename;
				else
					$filepath = $this->csslocation1.$filename;

				@unlink($filepath);
				@rename($tmpname, $filepath);
			}
			
			else
			{
				$fieldname = $this->serverfields[$n];
				$data = @file_get_contents($tmpname);

				$this->server->$fieldname = $this->unwrapHTML($data);
				$this->server->updated = now();
				$this->server->save();
				
				@unlink($tmpname);
			}
			return true;
		}	

		else
		{
			$file = getdbo('VFile', $object->id);
			$filename = objectPathname($file);
	
			@unlink($filename);
			@rename($tmpname, $filename);
			
			if($size) $object = scanObjectBackground($object);
		}
		
		if($size) objectUpdateParent($object, now());
		return true;
	}
	
	////////////////////////////////////////////////////////////////////

	function MKCOL($options)
	{
		$object = $this->path2Object($this->path);
		if($object) return false;
		
		$parent = $this->path2Parent($this->path);
		if(!$parent) return false;
		
		if(!$this->rbac->objectAction($parent, 'create'))
			return false;
			
		$name = $this->path2Name($this->path);
		
		$object = new Object;
		$object->type = CMDB_OBJECTTYPE_OBJECT;
		$object->name = $name;
			
		$object = objectInit($object, $parent->id);
		if(!$object) return false;
			
		$object->save();
		
		objectUpdateParent($object, now());
		return true;
	}
	
	function DELETE($options) 
	{
		$object = $this->path2Object($this->path);
		if(!$object) return false;
		if(!$object->id == 1) return false;
		if($this->path2Name($this->path) == $this->indexfilename) return true;
		if($this->path2ParentName($this->path) == $this->serverdirname) return false;
		
		if(!$this->rbac->objectAction($object, 'delete'))
			return false;
			
		objectDelete($object);
		return true;
	}

	function MOVE($options)
	{
		if(!empty($_SERVER["CONTENT_LENGTH"]))
			return "415 Unsupported media type";

		$source = $this->path2Object($this->path);
		if(!$source) return "404 Not Found";
		if(!$source->id == 1) return "404 Not Found";
		if($this->path2Name($this->path) == $this->indexfilename) return false;
		if($this->path2ParentName($this->path) == $this->serverdirname) return false;
		
		if(!$this->rbac->objectAction($source, 'update'))
			return false;
		
		$targetpath = $this->_urldecode(str_replace($this->base_uri, '', $options['dest_url']));
		
		$target = $this->path2Parent($targetpath);
		if(!$target) return "404 Not Found";
		
		if(!$this->rbac->objectAction($target, 'create'))
			return false;
		
		$name = $this->path2Name($targetpath);
		
		$source->name = $name;
		$source->parentid = $target->id;
		$source->save();
		
		$source->parentlist = objectParentList($source);
		$source->save();
		
		objectUpdateParent($source);
		
		$newpath = $this->object2Path($source);
		header("Location: $newpath");
		
		return "201 Created";	// "204 No Content";
	}

//        function COPY($options, $del=false) 
//        {
//            if (!empty($_SERVER["CONTENT_LENGTH"])) { // no body parsing yet
//                return "415 Unsupported media type";
//            }
//
//            // no copying to different WebDAV Servers yet
//            if (isset($options["dest_url"])) {
//                return "502 bad gateway";
//            }
//
//            $sourcepath = new VCSWebDAVPath($options["path"]);
//            $targetpath = new VCSWebDAVPath($options["dest"]);
//            
//            $this->vcs->setTag($targetpath->tag);
//            if ($this->vcs->isReadOnly()) return "403 Forbidden";
//            
//            $this->vcs->setTag($sourcepath->tag);
//            $result = $this->vcs->copy($sourcepath->dir, $sourcepath->name, $targetpath->dir, $targetpath->name, $options['overwrite']);
//
//            switch ($result) {
//              case VCS_ERROR: return "500 Server Error6";
//              case VCS_NOTFOUND: return "404 Not Found";
//              case VCS_FORBIDDEN:
//              case VCS_READONLY: return "403 Forbidden";
//              case VCS_EXISTS: return "412 Precondition Failed";
//              default: return "204 No Content";
//            }
//        }

	function PROPPATCH(&$options) 
	{
		return true;
	}

	public function LOCK(&$options)
	{
		return true;
	}
	
	public function UNLOCK(&$options)
	{
		return true;
	}
	

}




