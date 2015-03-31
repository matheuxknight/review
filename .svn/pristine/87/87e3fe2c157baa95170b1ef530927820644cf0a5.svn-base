<?php

class RegisterController extends CommonController
{
	public $defaultAction = 'admin';

	public function actionAdmin()
	{
		if(isset($_POST['site']))
		{
			foreach($_POST['site'] as $key=>$value)
				Yii::app()->params[$key] = $value;
				
			$fp = fopen(SANSSPACE_SITEPATH.'/siteconfig.php', 'w');
			if($fp)
			{
				fwrite($fp, "<?php\nreturn array(\n");
			
				foreach(Yii::app()->params as $key=>$value)
					fwrite($fp, "'$key'=>'$value',\n");
			
				fwrite($fp, ");\n\n");
				fclose($fp);
				
				user()->setFlash('message', 'Saved');
				$this->refresh();
			}
		}
		
		$this->render('admin');
	}
	
}


