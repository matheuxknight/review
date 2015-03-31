<?php

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($category);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($category, 'name');
echo CUFHtml::activeLabelEx($category, 'name');
echo CUFHtml::activeTextField($category, 'name', array('maxlength'=>200));
echo "<p class='formHint2'>Name of this category.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton($update? 'Save': 'Create');
echo CUFHtml::endForm();

if($update)
{
	showButtonHeader();
	showButton('Add Item', array('createitem', 'id'=>$category->id));
	echo "</div>";
	echo "<br>";
	
	showTableSorter('maintable1', '{headers: {1: {sorter: false}}}');
	echo "<thead class='ui-widget-header'><tr>";
	echo "<th>Name</th>";
	echo "<th></th>";
	echo "</tr></thead><tbody>";
		
	if($categoryitemList) foreach($categoryitemList as $model)
	{
		echo "<tr class='ssrow'>";	
		echo "<td style='font-weight: bold;'>".
			l($model->name, array('updateitem', 'id'=>$model->id))."</td>";
	
		echo "<td>";
		echo CHtml::linkButton(mainimg('16x16_delete.png'), array(
			'submit'=>'',
			'params'=>array('command'=>'deleteitem', 'id'=>$model->id),
			'confirm'=>"Are you sure to delete {$model->name}?"));
		echo "</td>";
		echo "</tr>";
	}
	
	echo "</table>";
	echo "<br/>";

}

