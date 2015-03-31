<?php

class RolesController extends CommonController
{
	public $defaultAction = 'admin';

	public function actionAdmin()
	{
		if(isset($_POST['Role']))
		{
			foreach ($_POST['Role'] as $des => $description)
			{
				$role = getdbosql('Role', "id=$des");
				$role->description = $_POST['Role'][$des]['description'];
				$role->save();
			}
			
			user()->setFlash('message', 'Saved');
			$this->refresh();
		}
			
		$this->render('admin');
	}
	
}


