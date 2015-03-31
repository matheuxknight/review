<?php

class CommentController extends CommonController
{
	private $_comment;

	public function actionCreate()
	{
		$comment = new Comment;
		$object = getdbo('Object', $_GET['id']);
		//Object::model()->findByPk($_GET['id']);
		$comment->name = $object->name;

		if(isset($_POST['Comment']))
		{
			$comment->attributes = $_POST['Comment'];
			$comment->authorid = getUser()->id;
			$comment->parentid = $_GET['id'];
			$comment->courseid = getContextCourseId();

			$comment->updated = now();
			$comment->created = now();
			$comment->accessed = now();
			
			if($comment->save())
			{
				objectUpdateParent($comment->object, now());
				$this->redirect(array('object/show', 'id'=>$object->id));
			}
		}

		$this->render('create', array('comment'=>$comment, 'object'=>$object));
	}

	public function actionUpdate()
	{
		$comment = $this->loadcomment();
		$object = $comment->object;

		if(isset($_POST['Comment']))
		{
			$comment->attributes = $_POST['Comment'];
			$comment->updated = now();

			if($comment->save())
			{
				objectUpdateParent($comment->object, now());
				$this->redirect(array('object/show','id'=>$object->id));
			}
		}

		$this->render('update', array('comment'=>$comment, 'object'=>$object));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$comment = $this->loadcomment();
			$object = $comment->object;

			$comment->delete();
			$this->redirect(array('object/show','id'=>$object->id));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	public function loadcomment($id=null)
	{
		if($this->_comment===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_comment=getdbo('Comment', $id!==null ? $id : $_GET['id']);
			//Comment::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_comment===null)
				throw new CHttpException(500,'The requested comment does not exist.');
		}
		return $this->_comment;
	}

	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadcomment($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}

	public function actionResetContextcourse()
	{
		$comment = $this->loadcomment();
		$comment->courseid = 0;
		
		$comment->save();
		$this->goback();
	}
	
}



