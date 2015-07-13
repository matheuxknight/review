<?php

class FlashcardController extends CommonController
{
	private $_object;
	
	public function loadobject($id=null)
	{
		if($this->_object===null)
		{
			if($id === null)
				$id = getparam('id');
	
			$this->_object = getdbo('Object', $id);
	
			if($this->_object===null)
				throw new CHttpException(500, "The requested Object $id does not exist.");
		}
		
		return $this->_object;
	}
	
	///////////////////////////////////////////////////////////////////////////
	
	public function actionView()
	{
		$object = $this->loadobject();

        include "view.php";
	}
	
	public function actionAdmin()
	{
		$object = $this->loadobject();
	
		if(isset($_POST['Flashcard']) &&
			(!empty($_POST['Flashcard']['value1']) || !empty($_POST['Flashcard']['fileid1']) ||
			 !empty($_POST['Flashcard']['value2']) || !empty($_POST['Flashcard']['fileid2'])))
		{
		//	debuglog($_POST);
			$flashcard = getdbo('Flashcard', $_POST['Flashcard']['id']);
			if(!$flashcard) $flashcard = new Flashcard;
			
 			$flashcard->attributes = $_POST['Flashcard'];
 			$flashcard->objectid = $object->id;

 			if($flashcard->save())
 			{
 				user()->setFlash('message', 'Flashcard saved.');
 				$this->goback();
 			}
		}
		
		$this->render('admin', array('object'=>$object));
	}

	///////////////////////////////////////////////////////////////////////////////////////////
	
	public function actionDelete()
	{
 		$flashcard = getdbo('Flashcard', getparam('id'));
 		$flashcard->delete();
 		
		$this->goback();
 	}
	
	public function actionSave()
	{
		$flashcard = getdbo('Flashcard', getparam('id'));
		if($flashcard)
		{
			if(getparam('index') == 1)
			{
				$flashcard->startpos1 = getparam('startpos');
				$flashcard->duration1 = getparam('duration');
			}
			
			else if(getparam('index') == 2)
			{
				$flashcard->startpos2 = getparam('startpos');
				$flashcard->duration2 = getparam('duration');
			}
			
			$flashcard->save();
		}
	
		$this->goback();
	}
 	
	public function actionXmlFlashcard()
	{
		$object = $this->loadobject();
		$flashcards = getdbolist('Flashcard', "objectid=$object->id order by displayorder");
		
		header("Content-Type: text/xml");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');
		
		echo "<?xml version='1.0' encoding='utf-8' ?>";
		echo "<data>";
		
		echo Object2Xml($object);
		
		echo "<flashcards>";
		
		foreach($flashcards as $f)
		{
			echo "<flashcard>";
			
			echo "<id>$f->id</id>";
			echo "<objectid>$f->objectid</objectid>";
			echo "<displayorder>$f->displayorder</displayorder>";

			/////////////////////////////////////////////////////////////////////////////
			
			echo "<item1>";
			echo "<value><![CDATA[$f->value1]]></value>";
			echo "<fileid>$f->fileid1</fileid>";
			
			if($f->file1)
			{
				$imagename = fileUrl($f->file1);
				
				echo "<filetype>{$f->file1->filetype}</filetype>";
				echo "<hasvideo>{$f->file1->hasvideo}</hasvideo>";
				echo "<imagename>$imagename</imagename>";
				echo "<startpos>$f->startpos1</startpos>";
				echo "<duration>$f->duration1</duration>";
			}

			echo "</item1>";
			
			/////////////////////////////////////////////////////////////////////////////
				
			echo "<item2>";
			echo "<value><![CDATA[$f->value2]]></value>";
			echo "<fileid>$f->fileid2</fileid>";
			
			if($f->file2)
			{
				$imagename = fileUrl($f->file2);
				
				echo "<filetype>{$f->file2->filetype}</filetype>";
				echo "<hasvideo>{$f->file2->hasvideo}</hasvideo>";
				echo "<imagename>$imagename</imagename>";
				echo "<startpos>$f->startpos2</startpos>";
				echo "<duration>$f->duration2</duration>";
			}				
			
			echo "</item2>";
			echo "</flashcard>";
		}
		
		echo "</flashcards>";
		echo "</data>";
		
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////
	
 	public function actionSetorder()
 	{
		$flashcard = getdbo('Flashcard', getparam('id'));
		if(!$flashcard) return;
	
		$order = getparam('order');
		$oldorder = $flashcard->displayorder;
	
		$bros = getdbolist('Flashcard', "objectid=$flashcard->objectid order by displayorder");
		foreach($bros as $n=>$o)
		{
			if($o->id == $flashcard->id)
				$o->displayorder = $order;
	
			else if($o->displayorder < $order && $o->displayorder < $oldorder)
				$o->displayorder = $n;
	
			else if($o->displayorder > $order && $o->displayorder > $oldorder)
				$o->displayorder = $n;
	
			else if($order < $oldorder)
				$o->displayorder = $n + 1;
			else
				$o->displayorder = $n - 1;
	
			$o->save();
		}

 		$this->goback();
 	}
	
	
}





