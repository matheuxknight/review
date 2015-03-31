<?php

class CategoryController extends CommonController
{
	public $defaultAction='admin';

	private $_category;
	private $_categoryitem;
	
	public function actionCreate()
	{
		$category = new Category;
		if(isset($_POST['Category']))
		{
			$category->attributes=$_POST['Category'];
			if($category->save())
				$this->redirect(array('admin'));
		}
		
		$this->render('create',array('category'=>$category));
	}

	public function actionUpdate()
	{
		$this->processAdminCommand();
		
		$category = $this->loadcategory();
		if(isset($_POST['Category']))
		{
			$category->attributes=$_POST['Category'];
			if($category->save())
				$this->redirect(array('admin'));
		}
		
		$categoryitemList = getdbolist('CategoryItem', "categoryid={$category->id}");
		//CategoryItem::model()->findAll(
		//	"categoryid={$category->id}");
		
		$this->render('update', array(
			'category'=>$category,
			'categoryitemList'=>$categoryitemList,
		));
	}

	public function actionCreateItem()
	{
		$category = $this->loadcategory();
		$categoryitem = new CategoryItem;
		
		if(isset($_POST['CategoryItem']))
		{
			$categoryitem->attributes = $_POST['CategoryItem'];
			$categoryitem->categoryid = $category->id;
			
			if($categoryitem->save())
				$this->redirect(array('update', 'id'=>$category->id));
		}
		
		$this->render('createitem', array(
			'category'=>$category,
			'categoryitem'=>$categoryitem,
		));
	}

	public function actionUpdateItem()
	{
		$categoryitem = $this->loadcategoryitem();
		$category = getdbo('Category', $categoryitem->categoryid);
		//Category::model()->findByPk($categoryitem->categoryid);
		
		if(isset($_POST['CategoryItem']))
		{
			$categoryitem->attributes = $_POST['CategoryItem'];
			
			if($categoryitem->save())
				$this->redirect(array('update', 'id'=>$category->id));
		}
		
		$categoryitemList = getdbolist('CategoryItem', "categoryid={$category->id}");
		//CategoryItem::model()->findAll("categoryid={$category->id}");
		
		$this->render('updateitem', array(
			'category'=>$category,
			'categoryitem'=>$categoryitem,
			'categoryitemList'=>$categoryitemList,
		));
	}

	public function actionAdmin()
	{
		$this->processAdminCommand();

		$categoryList=getdbolist('Category', "");
		//Category::model()->findAll();
		$this->render('admin', array('categoryList'=>$categoryList));
	}
	
	////////////////////////////////////////////////////////////

	public function loadcategory($id=null)
	{
		if($this->_category===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_category=getdbo('Category', $id!==null ? $id : $_GET['id']);
			//Category::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_category===null)
				throw new CHttpException(500, 'The requested Category does not exist.');
		}
		return $this->_category;
	}

	public function loadcategoryitem($id=null)
	{
		if($this->_categoryitem===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_categoryitem=getdbo('CategoryItem', $id!==null ? $id : $_GET['id']);
			//CategoryItem::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_categoryitem===null)
				throw new CHttpException(500, 'The requested CategoryItem does not exist.');
		}
		return $this->_categoryitem;
	}

	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$category = $this->loadcategory($_POST['id']);

			app()->db->createCommand(
				"delete from CategoryItem where categoryid={$category->id}")->execute();
			
			$category->delete();
			$this->refresh();
		}

		else if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='deleteitem')
		{
			$categoryitem = $this->loadcategoryitem($_POST['id']);

			$categoryitem->delete();
			$this->refresh();
		}
	}
}

