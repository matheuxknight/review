<?php

showNavigationBar($course->parent);
showObjectHeader($course);
showObjectMenu($course->object);

$roleoptions = Role::model()->courseOptions;
$roledata = Role::model()->courseData;

JavascriptFile('/sansspace/modules/objects/course/addusers.js');
JavascriptReady("CourseAddUsers.init($course->id, '$roleoptions')");

echo "<h3>Add/Enroll Students</h3>";
echo "<p>Enroll existing registered users and/or create and enroll new ones.</p>";

// showButtonHeader();
// showButton('Import Roster File', array('addroster', 'id'=>$course->id));
// echo "</div>";
echo "<br>";

echo CUFHtml::beginForm();

echo "<table class='dataGrid' id='datatable'>";
echo "<thead><tr>";
echo "<th>Enroll</th>";
echo "<th>Login</th>";
echo "<th>Name</th>";
echo "<th>Email (Optional)</th>";
echo "<th>Role</th>";
echo "</tr></thead>";

$enrollcount = parseRosterFile();

echo "<tr id='entry_new'>";
echo "<td></td>";
echo "<td><input name='logon_new' id='logon_new' class='sans-input' type=text value='' /></td>";
echo "<td><input name='name_new' id='name_new' class='sans-input' type=text value='' size='30' /></td>";
echo "<td><input name='email_new' id='email_new' class='sans-input' type=text value='' size='30' /></td>";
echo "<td><select name='roleid_new' id='roleid_new' class='sans-combobox'>$roleoptions</select></td>";
echo "</tr>";

echo "</table>";
echo "<br>";

echo CUFHtml::hiddenField('enrollcount', $enrollcount);

showSubmitButton('Create');
echo CUFHtml::endForm();

///////////////////////////////////////////////////////////////////

function parseRosterFile()
{
	$filename = GetUploadedFilename();
	if(!$filename || !file_exists($filename)) return 0;

	$data = file_get_contents($filename);
	@unlink($filename);

	$ld = stringify($_POST['linedelim']);
	if(!$ld || empty($ld)) $ld = "\n";

	$fd = stringify($_POST['fielddelim']);
	if(!$fd || empty($fd)) $fd = ",";

	$roledata = Role::model()->courseData;
	$rows = explode($ld, $data);

	$count = 0;
	foreach($rows as $row)
	{
		$row = trim($row);
		if(empty($row)) continue;

		$fields = explode($fd, $row);
		echo "<tr class='ssrow'>";

		$user = null;
		foreach($fields as $field)
		{
			$field = trim($field);
			if(empty($field)) continue;

			$user = getdbosql('User', "name='".addslashes($field)."'");
			if($user) break;

			$user = getdbosql('User', "logon='".addslashes($field)."'");
			if($user) break;
		}

		$userlogon = '';
		$username = '';
		$userrole = '';
		$useremail = '';

		if($user)
		{
			$userlogon = $user->logon;
			$username = $user->name;
			$useremail = $user->email;
		}

		foreach($fields as $field)
		{
			$field = trim($field);
			if($field == 'S') $field = 'student';
			if($field == 'F') $field = 'teacher';

			if(strpos($field, ' ') && empty($username))
				$username = $field;
			else if(strpos($field, '@') && empty($useremail))
				$useremail = $field;
			else
			{
				$role = getdbosql('Role', "name='$field'");
				if($role && empty($userrole))
					$userrole = $field;

				else if(empty($userlogon))
					$userlogon = $field;
			}
		}

		$role = getdbosql('Role', "name='$userrole'");
		if(!$role) $role = getdbo('Role', SSPACE_ROLE_STUDENT);

		$checked = '';
		if($user)
			$checked = 'checked';
		else if(!empty($userlogon) && !empty($username))
			$checked = 'checked';

		echo "<td><input name='enroll_$count' type=checkbox $checked /></td>";

		if($user)
		{
			echo "<input name='userid_$count' type=hidden value='$user->id' />";
			echo "<td>$user->logon</td>";
			echo "<td>$user->name</td>";
			echo "<td>$user->email</td>";
		}
		else
		{
			echo "<input name='userid_$count' type=hidden value='0' />";
			echo "<td><input name='logon_$count' type=text class='sans-input' value='$userlogon' /></td>";
			echo "<td><input name='name_$count' type=text class='sans-input' value='$username' /></td>";
			echo "<td><input name='email_$count' type=text class='sans-input' value='$useremail' /></td>";
		}

		echo "<td>".CUFHtml::dropDownList("roleid_$count", $role->id, $roledata)."</td>";
		echo "</tr>";

		$count++;
	}

	return $count;
}

//////////////////////////////////////////////////////////////////////

function stringify($text)
{
	if($text[0] != '\\')
		return $text;

	switch($ld[1])
	{
		case 't':
			$text = "\t";
			break;

		case 'v':
			$text = "\v";
			break;

		case 'e':
			$text = "\e";
			break;

		case 'f':
			$text = "\f";
			break;

		case 'r':
			$text = "\r";
			break;

		case 'n':
		default:
			$text = "\n";
	}

	return $text;
}


