<?php

class BookmarkController extends CommonController
{
	public $defaultAction = 'test';
	private $_bookmark;

	public function actionInternalList()
	{
		header("Content-Type: text/xml");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');
		
		echo "<?xml version='1.0' encoding='utf-8' ?>";
		echo "<objects>";
		
		$userid = userid();
		$fileid = getparam('id');

		$bookmarks = getdbolist('Bookmark', "fileid=$fileid");
		foreach($bookmarks as $bookmark) $this->Bookmark2Xml($bookmark);
		
		echo "</objects>";
		die;
	}
	
	public function actionInternalDeleteBookmark()
	{
		$phpsessid = session_id();
		$bookmarkid = getparam('bookmarkid');
		
		$filename = SANSSPACE_TEMP."/phpsessid=$phpsessid&bookmarkid=$bookmarkid.flv";

		@unlink($filename);
		@unlink($filename.FLV_INDEX_EXTENSION2);
	}
	
	public function actionInternalSave()
	{
	//	debuglog("actionInternalSave()");
		$phpsessid = session_id();
		$name = getparam('name');
		$id = getparam('id');
		$parentid = getparam('parentid');
		$masterid = getparam('masterid');
		
		$file = getdbo('VFile', $id);
		if(!$file)
		{
			$file = safeCreateFile($name, $parentid, '.flv', $masterid, CMDB_FILETYPE_BOOKMARKS);
		//	debuglog("actionInternalSave() safecreate1");
		}
		
		else
		{
			function searchbm($bookmark)
			{
				foreach($_POST['bookmarks'] as $b)
				{
					if($b['id'] == $bookmark->id)
						return true;
				}

				return false;
			}
			
			$bookmarks = getdbolist('Bookmark', "fileid=$id");
			foreach($bookmarks as $bookmark)
			{
				$found = searchbm($bookmark);
				if(!$found)
				{
				//	debuglog("deleting bookmark $bookmark->id");
					
					$record = getdbo('VFile', $bookmark->recordid);
					if($record) objectDelete($record->object);
					
					$bookmark->delete();
				}
			}
		}
		
		/////////////////////////////////////////////////////////////
		
		foreach($_POST['bookmarks'] as $b)
		{
		//	debuglog($b);
			$bookmark = null;
			
			if(!$parentid) $bookmark = getdbo('Bookmark', $b['id']);
			if(!$bookmark) $bookmark = new Bookmark;

		//	debuglog("recordid $bookmark->recordid");
			$recordid = $bookmark->recordid;

			$bookmark->attributes = $b;
			$bookmark->fileid = $file->id;
			
			if($bookmark->recordid == -1)
			{
				$record = getdbo('VFile', $recordid);
				
				if(!$record)	// || $parentid)
					$record = safeCreateFile("Bookmark {$b['uniqid']}.flv", $file->id, '.flv');
				
				$filename = objectPathname($record);
				$fileindex = objectPathnameIndex($record);
				
				@unlink($filename);
				@unlink($fileindex);
				
				$inname = SANSSPACE_TEMP."/phpsessid=$phpsessid&bookmarkid={$b['uniqid']}.flv";
				
				debuglog("copy $inname, $filename");
				@copy($inname, $filename);
				
				$record = scanFile($record);
				$bookmark->recordid = $record->id;
			}
			
			else if($parentid && $bookmark->recordid)
			{
				$record1 = getdbo('VFile', $bookmark->recordid);
				if($record1)
				{
					$record2 = objectCopy($record1, $file->id);
					$bookmark->recordid = $record2->id;
				}
			}
			
			$bookmark->save();
		//	debuglog($bookmark->attributes);
		}
		
		header("Content-Type: text/xml");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');
		
		echo "<?xml version='1.0' encoding='utf-8' ?>";
		echo "<objects>";
		
		echo File2Xml($file);
		echo "</objects>";
		
	//	debuglog("actionInternalSave() done");
		die;
	}
	
	//////////////////////////////////////////////////////////////
	
	function Bookmark2Xml($bookmark)
	{
		$authorname = '';
		if($bookmark->author)
			$authorname = $bookmark->author->name;
			
		if(!$bookmark->duration)
			$bookmark->duration = 0;
		
	//	error_log("$bookmark->name");
			
		echo "<object>
				<id>$bookmark->id</id>
				<name>$bookmark->name</name>
				<authorid>$bookmark->authorid</authorid>
				<authorname>$authorname</authorname>
				<type>$bookmark->type</type>
				<doctext>$bookmark->doctext</doctext>
				<fileid>$bookmark->fileid</fileid>
				<courseid>$bookmark->courseid</courseid>
				<marktime>$bookmark->marktime</marktime>
				<duration>$bookmark->duration</duration>
				<recordid>$bookmark->recordid</recordid>
				<autostart>$bookmark->autostart</autostart>
				<sync>$bookmark->sync</sync>
				<volume>$bookmark->volume</volume>
				<opacity>$bookmark->opacity</opacity>
				<x>$bookmark->x</x>
				<y>$bookmark->y</y>
				<width>$bookmark->width</width>
				<height>$bookmark->height</height>
			</object>";
	}
	
	public function loadbookmark($id=null)
	{
		if($this->_bookmark===null)
		{
			if($id!==null || isset($_GET['Bookmark']['id']))
				$this->_bookmark=getdbo('Bookmark', $id!==null ? $id : $_GET['Bookmark']['id']);
			//Bookmark::model()->findbyPk($id!==null ? $id : $_GET['Bookmark']['id']);
		}
		
		return $this->_bookmark;
	}
}



