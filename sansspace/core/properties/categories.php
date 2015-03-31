<?php

function objectShowPropertiesCategories($object, $update)
{
	echo "<div id='properties-categories'>";
	if(!$object->id) $object->id = 0;
	
	$categories = getdbolist('Category', "");
	//Category::model()->findAll();
	foreach($categories as $category)
	{
		echo CUFHtml::openCtrlHolder();
		echo CUFHtml::label($category->name, $category->id);
		
		$categoryobject =getdbosql('CategoryObject', "objectid={$object->id} and categoryid={$category->id}");
		// CategoryObject::model()->find(
		//	"objectid={$object->id} and categoryid={$category->id}");
		
		if($categoryobject) $categoryitemid = $categoryobject->categoryitemid;
		else $categoryitemid = 0;
		
		echo CUFHtml::dropDownList("Category[{$category->id}]", $categoryitemid, 
			Category::model()->getOptions($category), array('class'=>'miscInput'));
		
		echo "<p class='formHint2'>Select the $category->name category.</p>";
		echo CUFHtml::closeCtrlHolder();
	}

	echo "</div>";	
	
}

