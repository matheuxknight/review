<?php

class WebDAVServer1 extends HTTP_WebDAV_Server 
{
	protected $rbac;
	
	protected $user;
	protected $server;
	protected $depth;
	
	protected $serverfiles = array(
		'home.html',
		'header.html',
		'footer.html',
		'login.html',
		'mysansspace.html',
		'contact.html',
	);
	
	protected $serverfields = array(
		'description',
		'header',
		'footer',
		'accessdenied',
		'mymessage',
		'contactus',
	);
	
	protected $cssfiles = array(
		'main.css',
		'table.css',
		'uni-form.css',
		'uni-form-generic.css',
		'jquery-ui.css',
	);
	
	protected $csslocation1;
	protected $csslocation2;

	protected $indexfilename = '.index.html';
	protected $serverdirname = '.server';
	
	//////////////////////////////////////////////////////////////
	
	function serveRequest()
	{
		header("X-Dav-Powered-By: SANSSPACE WEBDAV");
		$this->server = getdbo('Server', 1);
		
		if(!$this->server->updated)
		{
			$this->server->updated = now();
			$this->server->save();
		}
		
		$this->user = getUser();
		$this->rbac = new RBAC($this->user);

		$base = $_SERVER['DOCUMENT_ROOT'];
		$theme = param('theme');
		
		$this->csslocation1 = "$base/sansspace/ui/css/";
		$this->csslocation2 = "$base/extensions/jquery/themes/$theme/";
		
		if(isset($this->_SERVER['HTTP_DEPTH']))
			$this->depth = (int)$this->_SERVER["HTTP_DEPTH"];
		else
			$this->depth = 1;
		
		parent::serveRequest(getFullServerName(), 
			rtrim($this->_SERVER['REQUEST_URI'], '/'));
	}

	/////////////////////////////////////////////////////////////

	protected function rootPath()
	{
		return '/'.SANSSPACE_WEBDAV_NAME.'/';
	}
	
	protected function findServerFile($name)
	{
		foreach($this->serverfiles as $n=>$file)
			if($file == $name) return $n;
		
		return -1;
	}

	protected function findCssFile($name)
	{
		foreach($this->cssfiles as $n=>$file)
			if($file == $name) return $n;
		
		return -1;
	}
	
	///////////////////////////////////////////////////////////////

	protected function object2Path($object)
	{
		if($object->id == 1)
			return $this->rootPath();
	
		if($object->type == CMDB_OBJECTTYPE_FILE)
			$path = "$object->name";
		else
			$path = "$object->name/";
	
		$object = $object->parent;
		while($object && $object->id != 1)
		{
			$path = "$object->name/$path";
			$object = $object->parent;
		}
	
		return $this->rootPath().$path;
	}
	
	protected function path2Object($path)
	{
		$a = explode('/', $path);
		$object = null;
		
		foreach($a as $b)
		{
			if(empty($b)) continue;
			if($b == $this->indexfilename) return $object;

			if($b == $this->serverdirname && $object && $object->id == 1)
				return $object;

			if($b == SANSSPACE_WEBDAV_NAME || $b == '.')
			{
				$object = getdbo('Object', 1);
				if(!$object) return null;
			}
			
			else
			{
				$object = getdbosql('Object', "parentid=$object->id and name='$b'");
				if(!$object) return null;
			}
		}
		
		return $object;
	}
	
	protected function path2Parent($path)
	{
		$path = rtrim($path, '/');
		$path = substr($path, 0, strrpos($path, '/'));
		return $this->path2Object($path);
	}
	
	protected function path2Name($path)
	{
		$path = rtrim($path, '/');
		$a = explode('/', $path);
		return $a[count($a)-1];
	}
	
	protected function path2ParentName($path)
	{
		$path = rtrim($path, '/');
		$path = substr($path, 0, strrpos($path, '/'));
		return $this->path2Name($path);
	}
	
	//////////////////////////////////////////////////////////////////
	
	protected function dirInfo(&$files, $object, $depth=0) 
	{
		if(!$depth)
		{
			$info = array();
			$info["path"]  = $this->object2Path($object);
			
			$info["props"] = array();
			$info["props"][] = $this->mkprop("displayname",     $object->name);
			$info["props"][] = $this->mkprop("creationdate",    strtotime($object->created));
			$info["props"][] = $this->mkprop("getlastmodified", strtotime($object->updated));
			$info["props"][] = $this->mkprop("resourcetype",    "collection");
			$info["props"][] = $this->mkprop("getcontenttype",  "httpd/unix-directory");
	
			# Microsoft:
			$info["props"][] = $this->mkprop("lastaccessed",	strtotime($object->accessed));
			$info["props"][] = $this->mkprop("ishidden",		false);
	
			$files["files"][] = $info;
		}
		
		else
		{
			$objects = getdbolist('Object', "parentid=$object->id and not deleted");
			foreach($objects as $o)
			{
				if(!$this->rbac->objectAction($o))
					continue;
				
				switch($o->type)
				{
					case CMDB_OBJECTTYPE_FILE:
						$this->fileInfo($files, $o->file);
						break;
	
					case CMDB_OBJECTTYPE_OBJECT:
					case CMDB_OBJECTTYPE_COURSE:
						$this->dirInfo($files, $o, $depth-1);
						break;
				}
			}
	
			$this->fileIndexInfo($files, $object);
			
			if($object->id == 1)
				$this->dirServerInfo($files, 0);
		}
	}
	
	////////////////////////////////////////////////////////////////////
	
	protected function fileInfo(&$files, $file) 
	{
		if($file->size == null) $file->size = 0;
		$file->mimetype = str_replace('; charset=binary', '', $file->mimetype);
		
		$info["path"]  = $this->object2Path($file);
		$info["props"] = array();
		
		$info["props"][] = $this->mkprop("displayname",     $file->name);
		$info["props"][] = $this->mkprop("creationdate",    strtotime($file->created));
		$info["props"][] = $this->mkprop("getlastmodified", strtotime($file->updated));
		$info["props"][] = $this->mkprop("resourcetype",    "");
		$info["props"][] = $this->mkprop("getcontenttype",  $file->mimetype);
		$info["props"][] = $this->mkprop("getcontentlength",$file->size);
		
		# Microsoft:
		$info["props"][] = $this->mkprop("lastaccessed",    strtotime($file->accessed));
		$info["props"][] = $this->mkprop("ishidden",        false);
		
		$files["files"][] = $info;
	}
	
	////////////////////////////////////////////////////////////////////
	
	protected function fileIndexInfo(&$files, $object) 
	{
		$data = $this->wrapHTML($object->ext->doctext);
		
		$info["path"]  = $this->object2Path($object).$this->indexfilename;
		$info["props"] = array();
		
		$info["props"][] = $this->mkprop("displayname",     $this->indexfilename);
		$info["props"][] = $this->mkprop("creationdate",    strtotime($object->created));
		$info["props"][] = $this->mkprop("getlastmodified", strtotime($object->updated));
		$info["props"][] = $this->mkprop("resourcetype",    "");
		$info["props"][] = $this->mkprop("getcontenttype",  "text/html");
		$info["props"][] = $this->mkprop("getcontentlength",strlen($data));
		
		# Microsoft:
		$info["props"][] = $this->mkprop("lastaccessed",    strtotime($object->accessed));
		$info["props"][] = $this->mkprop("ishidden",        false);
		
		$files["files"][] = $info;
	}
	
	////////////////////////////////////////////////////////////////////

	protected function dirServerInfo(&$files, $depth=0)
	{
		if(!$depth)
		{
			$info = array();
			$info["path"]  = $this->rootPath().$this->serverdirname.'/';
			
			$info["props"] = array();
			$info["props"][] = $this->mkprop("displayname",     $this->serverdirname);
			$info["props"][] = $this->mkprop("creationdate",    strtotime($this->server->updated));
			$info["props"][] = $this->mkprop("getlastmodified", strtotime($this->server->updated));
			$info["props"][] = $this->mkprop("resourcetype",    "collection");
			$info["props"][] = $this->mkprop("getcontenttype",  "httpd/unix-directory");
	
			# Microsoft:
			$info["props"][] = $this->mkprop("lastaccessed",	strtotime($this->server->updated));
			$info["props"][] = $this->mkprop("ishidden",		false);
	
			$files["files"][] = $info;
		}
		
		else
		{
			foreach($this->serverfiles as $n=>$file)
				$this->fileServerInfo($files, $file);

			foreach($this->cssfiles as $n=>$file)
				$this->fileServerInfo($files, $file);
		}
	}
	
	/////////////////////////////////////////////////////////////////////
	
	protected function fileServerInfo(&$files, $name)
	{
		$n = $this->findServerFile($name);
		if($n == -1)
		{
			$n = $this->findCssFile($name);
			if($n == -1) return;
			
			$filename = $this->cssfiles[$n];
			if($filename == 'jquery-ui.css')
				$filepath = $this->csslocation2.$filename;
			else
				$filepath = $this->csslocation1.$filename;

			$file = new CFile($filepath);
			
			$info["path"]  = $this->rootPath().$this->serverdirname.'/'.$filename;
			$info["props"] = array();
			
			$info["props"][] = $this->mkprop("displayname",     $filename);
			$info["props"][] = $this->mkprop("creationdate",    $file->date);
			$info["props"][] = $this->mkprop("getlastmodified", $file->date);
			$info["props"][] = $this->mkprop("resourcetype",    "");
			$info["props"][] = $this->mkprop("getcontenttype",  $file->mimetype);
			$info["props"][] = $this->mkprop("getcontentlength",$file->size);
			
			# Microsoft:
			$info["props"][] = $this->mkprop("lastaccessed",    $file->date);
			$info["props"][] = $this->mkprop("ishidden",        false);
			
			$files["files"][] = $info;
		}
		
		else
		{
			$filename = $this->serverfiles[$n];
			$fieldname = $this->serverfields[$n];
			$data = $this->wrapHTML($this->server->$fieldname);
			
			$info["path"]  = $this->rootPath().$this->serverdirname.'/'.$filename;
			$info["props"] = array();
			
			$info["props"][] = $this->mkprop("displayname",     $filename);
			$info["props"][] = $this->mkprop("creationdate",    strtotime($this->server->updated));
			$info["props"][] = $this->mkprop("getlastmodified", strtotime($this->server->updated));
			$info["props"][] = $this->mkprop("resourcetype",    "");
			$info["props"][] = $this->mkprop("getcontenttype",  "text/html");
			$info["props"][] = $this->mkprop("getcontentlength",strlen($data));
			
			# Microsoft:
			$info["props"][] = $this->mkprop("lastaccessed",    strtotime($this->server->updated));
			$info["props"][] = $this->mkprop("ishidden",        false);
			
			$files["files"][] = $info;
		}
	}
	
	////////////////////////////////////////////////////////////////////
	
	protected function wrapHTML($text)
	{
		$servername = getFullServerName();
		return <<<END
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<link rel="stylesheet" type="text/css" href="$servername/sansspace/ui/css/main.css" />
</head><body>$text</body></html>
END;
	}
	
	protected function unwrapHTML($text)
	{
		$b = preg_match('/(.*?)<body>(.*?)<\/body>/s', $text, $match);
		if(!$b) return $text;
		
		return $match[2];
	}
	
}




