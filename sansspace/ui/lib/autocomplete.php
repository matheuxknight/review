<?php

function showAutocompleteUserModel($model, $attribute, $value='')
{
	$id = get_class($model).'_'.$attribute;
	$idi = "{$id}_input";

	echo <<<END
<input id='$idi' class='textInput sans-input' value='$value' />
<script>$(function(){ $('#$idi').autocomplete({source: 
	'/autocomplete/user',minLength: 2, select: function(event, ui) {
	if(ui.item) $('#$id').val(ui.item.id);}});});</script>
END;
}

function showAutocompleteUser($attribute, $value='')
{
	$id = $attribute;
	$idi = "{$id}_input";

	echo <<<END
<input id='$idi' class='textInput sans-input' value='$value' />
<script>$(function(){ $('#$idi').autocomplete({source: 
	'/autocomplete/user',minLength: 2, select: function(event, ui) {
	if(ui.item) $('#$id').val(ui.item.id);}});});</script>
END;
}

function showAutocompletePage($attribute, $value='')
{
	$id = $attribute;
	$idi = "{$id}_input";

	echo <<<END
<input id='$idi' class='textInput sans-input' value='$value' size='60' style='display: none;' />
<script>$(function(){ $('#$idi').autocomplete({source: 
	'/autocomplete/page',minLength: 2, select: function(event, ui) {
	if(ui.item) $('#$id').val(ui.item.id);}});});</script>
END;
}


