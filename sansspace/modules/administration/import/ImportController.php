<?php

class ImportController extends CommonController
{
	const PAGE_SIZE = 20;
	public $defaultAction = 'admin';
	private $_folderImport;

	public function actionCreate()
	{
		$parentid = getparam('id');
		if(!$parentid) $parentid = 1;
			
		$folderImport = new FolderImport;
		$folderImport->autoscan = true;
		
		$parent = getdbo('Object', $parentid);
		if(isset($_POST['FolderImport']))
		{
			$folderImport->attributes = $_POST['FolderImport'];
			if($folderImport->validate())
			{
				// create mapped object under parent
				$object = new Object;
				$object->type = CMDB_OBJECTTYPE_OBJECT;
				$object->name = $folderImport->name;
				$object->pathname = '.';
				$object = objectInit($object, $parent->id);
				
				$folderImport->objectid = $object->id;
				$folderImport->save();
				
				$object->folderimportid = $folderImport->id;
				$object->save();
				
				sendMessageSansspace('RESET Folder');
				$this->redirect(array('admin'));
			}
		}
		
		$this->render('create', array('parent'=>$parent, 'folderImport'=>$folderImport));
	}

	public function actionUpdate()
	{
		$folderImport = $this->loadFolderImport();
		$parent = $folderImport->object->parent;
		
		if(isset($_POST['FolderImport']))
		{
			$folderImport->attributes = $_POST['FolderImport'];
			if($folderImport->save())
			{
				$this->redirect(array('admin'));
				sendMessageSansspace('RESET Folder');
			}
		}
		
		$this->render('update', array('parent'=>$parent, 'folderImport'=>$folderImport));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$folderImport = $this->loadFolderImport();
			objectDelete($folderImport->object);
			
			$folderImport->delete();
			sendMessageSansspace('RESET Folder');
			
			$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	public function actionAdmin()
	{
		$this->processAdminCommand();
		$criteria = new CDbCriteria;

		$pages = new CPagination(getdbocount('FolderImport', $criteria));
		$pages->pageSize = self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort = new CSort('FolderImport');
		$sort->applyOrder($criteria);

		$folderImportList = getdbolist('FolderImport', $criteria);
		//FolderImport::model()->findAll($criteria);

		$this->render('admin', array('folderImportList'=>$folderImportList,
			'pages'=>$pages, 'sort'=>$sort));
	}

	public function loadFolderImport($id=null)
	{
		if($this->_folderImport===null)
		{
			if($id !== null || isset($_GET['id']))
				$this->_folderImport=getdbo('FolderImport', $id!==null ? $id : $_GET['id']);
			//FolderImport::model()->findbyPk($id!==null ? $id : $_GET['id']);
				
			if($this->_folderImport===null)
				throw new CHttpException(500,'The requested FolderImport does not exist.');
		}
		return $this->_folderImport;
	}

	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$folderImport = $this->loadFolderImport($_POST['id']);
			objectDelete($folderImport->object);
			
			$folderImport->delete();
			sendMessageSansspace('RESET Folder');
			
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}


}


