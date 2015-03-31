<?php

echo "<h2>Edit Contact</h2>";

showButtonHeader();
showButton('All Contacts', array('admin'));
showButtonPost('Delete Contact', array('submit'=>array('delete','id'=>$contact->id),'confirm'=>'Are you sure?'));
echo "</div>";

echo $this->renderPartial('_form', array('contact'=>$contact, 'update'=>true));

