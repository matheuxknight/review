<?php

class Category extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Category';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>200),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
		);
	}

	public function getOptions($category)
	{
		$list = CHtml::listData(CategoryItem::model()->findAll(
			"categoryid={$category->id}"), 'id', 'name');

		$list[0] = '';
		return $list;
	}

	public function getText($category, $object)
	{
		$categoryobject = getdbosql('CategoryObject', "categoryid={$category->id} and objectid={$object->id}");
		//CategoryObject::model()->find(
		//	"categoryid={$category->id} and objectid={$object->id}");
		if(!$categoryobject) return '';
		
		$options = $this->getOptions($category);
		
		return isset($options[$categoryobject->categoryitemid])? 
			$options[$categoryobject->categoryitemid]: 
			"Unknown ({$categoryobject->categoryitemid})";
	}
	
	
}



