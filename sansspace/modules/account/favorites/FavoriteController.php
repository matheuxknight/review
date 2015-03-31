<?php

class FavoriteController extends CommonController
{
	public function actionCreate()
	{
		if(!isset($_GET['id'])) return;

		$objectid = $_GET['id'];
		$userid = getUser()->id;
		
		$fav = getdbosql('Favorite', "userid=$userid and id=$objectid");
		//Favorite::model()->find("userid=$userid and id=$objectid");
		if($fav) return;
		
		$fav = new Favorite;
		$fav->userid = $userid;
		$fav->id = $objectid;
		$fav->save();

		user()->setFlash('message', 'Favorite added.');
		echo "<script>history.go(-1)</script>";
	}

	public function actionDelete()
	{
		if(!isset($_GET['id'])) return;

		$objectid = $_GET['id'];
		$userid = getUser()->id;
		
		$fav = getdbosql('Favorite', "userid=$userid and id=$objectid");
		//Favorite::model()->find("userid=$userid and id=$objectid");
		if(!$fav) return;
			
		$fav->delete();

		user()->setFlash('message', 'Favorite removed.');
		echo "<script>history.go(-1)</script>";
	}
	

}




