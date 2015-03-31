<?php

function showDropdownCommand()
{
if(controller()->rbac->globalAdmin());
{
	echo "<script type='text/javascript'>
		function selectFunction()
		{
			var dd = document.getElementById('dropdown_command');
			if(dd.selectedIndex == 0) {
				document.getElementById('new_parentid_input').style.display = 'none';
			}
			
			if(dd.selectedIndex == 1 || dd.selectedIndex == 2) {
				document.getElementById('new_parentid_input').style.display = 'inline';
				document.getElementById('new_parentid_input').focus();
			}
			
			else if(dd.selectedIndex == 3) {
				if(confirm('Are you sure you want to delete the selected items?'))
					document.forms[0].submit();
			}
		}
		
		$('#all_objects_selector').change(function(e){
			var selected = this.checked;
			$('.all_objects_select').attr('checked', selected);
		});

		</script>";
	
	echo "<br><div>&nbsp;&nbsp;";
	echo CHtml::checkBox("all_objects_selector", false);
	echo "&nbsp;&nbsp;&nbsp;";
	echo CHtml::dropDownList('dropdown_command', '',
		array(
			'select'=>'Select...',
			'move'=>'Move Selected Objects',
			'copy'=>'Copy Selected Objects',
			'delete'=>'Delete Selected Objects',
		),
		 array(
			'onchange'=>'javascript:selectFunction()',
		 ));
	
	showAutocompletePage('new_parentid');
	echo CHtml::hiddenField('new_parentid');
	echo "'<br>'</div><br><br>";
}
}




