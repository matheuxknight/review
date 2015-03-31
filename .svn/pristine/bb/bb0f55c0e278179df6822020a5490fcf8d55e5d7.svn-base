<?php

showAdminHeader(0);

echo "<h2>Site Config</h2>";
$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#tabs');

echo "<div id='tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1'>Layout</a></li>";
echo "<li><a href='#tabs-2'>Parameters</a></li>";
echo "<li><a href='#tabs-3'>Appearance</a></li>";
//echo "<li><a href='#tabs-4'>Buttons</a></li>";
echo "<li><a href='#tabs-5'>Recorder</a></li>";
echo "<li><a href='#tabs-6'>Extra Links</a></li>";
echo "<li><a href='#tabs-7'>Miscellaneous</a></li>";
echo "</ul><br>";

//////////////////////////////////////////////////////////

echo "<div id='tabs-1'>";

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Title', 'site[title]');
echo CUFHtml::textField('site[title]', param('title'), array('class'=>'textInput'));
echo "<p class='formHint2'>The short title of your site. Shown in the internet browser title bar.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, 'header');
echo CUFHtml::activeLabelEx($server, 'header');
echo CUFHtml::activeHiddenField($server, 'header');
if(!empty($server->header))
echo "<div class='textInput sans-text'>".getTextTeaser($server->header)."</div>";
showObjectEditorButton('Server_header');
echo "<p class='formHint2'>Click to edit the page header.
The page header appears on all pages on this site.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, 'description');
echo CUFHtml::activeLabelEx($server, 'description');
echo CUFHtml::activeHiddenField($server, 'description');
if(!empty($server->description))
echo "<div class='textInput sans-text'>".getTextTeaser($server->description)."</div>";
showObjectEditorButton('Server_description');
echo "<p class='formHint2'>Click to edit the text that appears on the home page.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, 'mymessage');
echo CUFHtml::activeLabelEx($server, 'mymessage');
echo CUFHtml::activeHiddenField($server, 'mymessage');
if(!empty($server->mymessage))
echo "<div class='textInput sans-text'>".getTextTeaser($server->mymessage)."</div>";
showObjectEditorButton('Server_mymessage');
echo "<p class='formHint2'>Click to edit the text that appears on the My SANSSpace page.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, 'footer');
echo CUFHtml::activeLabelEx($server, 'footer');
echo CUFHtml::activeHiddenField($server, 'footer');
if(!empty($server->footer))
echo "<div class='textInput sans-text'>".getTextTeaser($server->footer)."</div>";
showObjectEditorButton('Server_footer');
echo "<p class='formHint2'>Click to edit the page footer.
The footer appears on all pages on this site.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, 'accessdenied');
echo CUFHtml::activeLabelEx($server, 'accessdenied');
echo CUFHtml::activeHiddenField($server, 'accessdenied');
if(!empty($server->accessdenied))
echo "<div class='textInput sans-text'>".getTextTeaser($server->accessdenied)."</div>";
showObjectEditorButton('Server_accessdenied');
echo "<p class='formHint2'>Click to edit the login page message.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, 'registerpage');
echo CUFHtml::activeLabelEx($server, 'registerpage');
echo CUFHtml::activeHiddenField($server, 'registerpage');
if(!empty($server->registerpage))
echo "<div class='textInput sans-text'>".getTextTeaser($server->registerpage)."</div>";
showObjectEditorButton('Server_registerpage');
echo "<p class='formHint2'>Click to edit the login page message.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, 'netmessage');
echo CUFHtml::activeLabelEx($server, 'netmessage');
echo CUFHtml::activeHiddenField($server, 'netmessage');
if(!empty($server->netmessage))
echo "<div class='textInput sans-text'>".getTextTeaser($server->netmessage)."</div>";
showObjectEditorButton('Server_netmessage');
echo "<p class='formHint2'>Click to edit the network message.
This message will appear instantly on all browsers connected to this server.</p>";
echo CUFHtml::closeCtrlHolder();


echo "</div>";

//////////////////////////////////////////////////////////////

echo "<div id='tabs-2'>";

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Allow Self Registration', 'site[allowregister]');
echo CUFHtml::hiddenField('site[allowregister]', '0');
echo CUFHtml::checkBox('site[allowregister]', param('allowregister'));
echo "<p class='formHint2'>Let users create their own account to use on this server.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Quick Login', 'site[quicklogin]');
echo CUFHtml::hiddenField('site[quicklogin]', '0');
echo CUFHtml::checkBox('site[quicklogin]', param('quicklogin'));
echo "<p class='formHint2'>Show the username and password login fields in the tab bar.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Single Login', 'site[singlelogin]');
echo CUFHtml::hiddenField('site[singlelogin]', '0');
echo CUFHtml::checkBox('site[singlelogin]', param('singlelogin'));
echo "<p class='formHint2'>Users will not be allowed multiple logins. Admin accounts are exclude from this rule.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Must Login', 'site[mustlogin]');
echo CUFHtml::hiddenField('site[mustlogin]', '0');
echo CUFHtml::checkBox('site[mustlogin]', param('mustlogin'));
echo "<p class='formHint2'>Users must login before accessing any page on the site.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Logoff Timeout', 'site[logofftimeout]');
echo CUFHtml::textField('site[logofftimeout]', param('logofftimeout'), array('class'=>'textInput'));
echo "<p class='formHint2'>Auto logoff timeout, in minutes. 0 for no auto logoff.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Auto Play', 'site[autoplay]');
echo CUFHtml::hiddenField('site[autoplay]', '0');
echo CUFHtml::checkBox('site[autoplay]', param('autoplay'));
echo "<p class='formHint2'>Media files will start playing when opening the page.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Relative Date', 'site[useshortdate]');
echo CUFHtml::hiddenField('site[useshortdate]', '0');
echo CUFHtml::checkBox('site[useshortdate]', param('useshortdate'));
echo "<p class='formHint2'>Show relative dates instead of absolute dates.
	'2 days ago' instead of '2010-10-10 10:10:10'</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Quick Comment', 'site[quickcomment]');
echo CUFHtml::hiddenField('site[quickcomment]', '0');
echo CUFHtml::checkBox('site[quickcomment]', param('quickcomment'));
echo "<p class='formHint2'>Show the quick comment entry field on each object's page.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Items per Page', 'site[pagecount]');
echo CUFHtml::textField('site[pagecount]', param('pagecount'), array('class'=>'textInput'));
echo "<p class='formHint2'>Number of items shown per page.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Sub Items', 'site[subitemcount]');
echo CUFHtml::textField('site[subitemcount]', param('subitemcount'), array('class'=>'textInput'));
echo "<p class='formHint2'>The number of subitems displayed for an item overview.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Column Count', 'site[columncount]');

$options = array(
	'2'=>'2 Columns',
	'3'=>'3 Columns',
);

echo CUFHtml::dropDownList('site[columncount]', param('columncount'), $options);
echo "<p class='formHint2'>The number of column to layout content lists.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Default Order', 'site[defaultorder]');

$options = array(
	'displayorder'=>'Default',
	'name'=>'Name',
	'duration desc'=>'Duration',
	'updated desc'=>'Date',
	'size desc'=>'Size',
	'views desc'=>'Views',
);

echo CUFHtml::dropDownList('site[defaultorder]', param('defaultorder'), $options);
echo "<p class='formHint2'>The default order to sort objects in listing.</p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";

//////////////////////////////////////////////////////////////

echo "<div id='tabs-3'>";

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Theme', 'site[theme]');
$options = array();
$folders = glob(SANSSPACE_HTDOCS.'/extensions/jquery/themes/*');
foreach($folders as $f)
{
	$name = strrchr($f, '/');
	$name = substr($name, 1);

	$options[$name] = $name;
}
echo CUFHtml::dropDownList('site[theme]', param('theme'), $options);
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Icon Set', 'site[iconset]');
$options = array();
$folders = glob(SANSSPACE_HTDOCS.'/images/iconset/*');
foreach($folders as $f)
{
	$name = strrchr($f, '/');
	$name = substr($name, 1);

	$options[$name] = $name;
}
echo CUFHtml::dropDownList('site[iconset]', param('iconset'), $options);
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Header Color', 'site[linkcolor]');
echo CUFHtml::textField('site[linkcolor]', param('linkcolor'), array('class'=>'textInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();


echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Header Background', 'site[topback]');
echo CUFHtml::textField('site[topback]', param('topback'), array('class'=>'textInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Menu Color', 'site[headercolor]');
echo CUFHtml::textField('site[headercolor]', param('headercolor'), array('class'=>'textInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Menu Background', 'site[headerback]');
echo CUFHtml::textField('site[headerback]', param('headerback'), array('class'=>'textInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Menu Border', 'site[headerborder]');
echo CUFHtml::textField('site[headerborder]', param('headerborder'), array('class'=>'textInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Menu Border Bottom', 'site[headerborderbot]');
echo CUFHtml::textField('site[headerborderbot]', param('headerborderbot'), array('class'=>'textInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";

//////////////////////////////////////////////////////////////

// echo "<div id='tabs-4'>";

// Javascript("function rgb2hex(string)
// {
// 	var rgb = string.match(/rgb\((\d+),\s*(\d+),\s*(\d+)\)/);
// 	if(!rgb) return string;

// 	function hex(x) { return ('0' + parseInt(x).toString(16)).slice(-2);}

// 	var color = '#' + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
// 	return string.replace(/rgb\((\d+),\s*(\d+),\s*(\d+)\)/, color);
// }");

// function ShowFetchCurrentButton($ui, $attr, $param)
// {
// 	echo <<<END
// <a id='fetchbutton_$param'>Get Current</a>
// <script>$(function(){ $('#fetchbutton_$param').button({
// 	icons:{primary: 'ui-icon-arrowthick-1-w'}, text: false}).click(function(e){
// 	$('#site_$param').val(rgb2hex($('$ui').css('$attr')));
// 	});});</script>
// END;
// }


// echo CUFHtml::openCtrlHolder();
// echo CUFHtml::label('Button Color', 'site[buttoncolor]');
// echo CUFHtml::textField('site[buttoncolor]', param('buttoncolor'), array('class'=>'textInput'));
// ShowFetchCurrentButton('.ui-state-default', 'color', 'buttoncolor');
// echo "<p class='formHint2'>.</p>";
// echo CUFHtml::closeCtrlHolder();

// echo CUFHtml::openCtrlHolder();
// echo CUFHtml::label('Hover Color', 'site[hovercolor]');
// echo CUFHtml::textField('site[hovercolor]', param('hovercolor'), array('class'=>'textInput'));
// ShowFetchCurrentButton('.ui-state-hover', 'color', 'hovercolor');
// echo "<p class='formHint2'>.</p>";
// echo CUFHtml::closeCtrlHolder();

// echo CUFHtml::openCtrlHolder();
// echo CUFHtml::label('Active Color', 'site[activecolor]');
// echo CUFHtml::textField('site[activecolor]', param('activecolor'), array('class'=>'textInput'));
// ShowFetchCurrentButton('.ui-state-active', 'color', 'activecolor');
// echo "<p class='formHint2'>.</p>";
// echo CUFHtml::closeCtrlHolder();

// ///////////////////////////////////////////////////////

// echo CUFHtml::openCtrlHolder();
// echo CUFHtml::label('Button Background', 'site[buttonback]');
// echo CUFHtml::textField('site[buttonback]', param('buttonback'), array('class'=>'textInput'));
// ShowFetchCurrentButton('.ui-state-default', 'background', 'buttonback');
// echo "<p class='formHint2'>.</p>";
// echo CUFHtml::closeCtrlHolder();

// echo CUFHtml::openCtrlHolder();
// echo CUFHtml::label('Hover Background', 'site[hoverback]');
// echo CUFHtml::textField('site[hoverback]', param('hoverback'), array('class'=>'textInput'));
// ShowFetchCurrentButton('.ui-state-hover', 'background', 'hoverback');
// echo "<p class='formHint2'>.</p>";
// echo CUFHtml::closeCtrlHolder();

// echo CUFHtml::openCtrlHolder();
// echo CUFHtml::label('Active Background', 'site[activeback]');
// echo CUFHtml::textField('site[activeback]', param('activeback'), array('class'=>'textInput'));
// ShowFetchCurrentButton('.ui-state-active', 'background', 'activeback');
// echo "<p class='formHint2'>.</p>";
// echo CUFHtml::closeCtrlHolder();

// /////////////////////////////////////////////////////

// echo CUFHtml::openCtrlHolder();
// echo CUFHtml::label('Button Border', 'site[buttonborder]');
// echo CUFHtml::textField('site[buttonborder]', param('buttonborder'), array('class'=>'textInput'));
// ShowFetchCurrentButton('.ui-state-default', 'border', 'buttonborder');
// echo "<p class='formHint2'>.</p>";
// echo CUFHtml::closeCtrlHolder();

// echo CUFHtml::openCtrlHolder();
// echo CUFHtml::label('Hover Border', 'site[hoverborder]');
// echo CUFHtml::textField('site[hoverborder]', param('hoverborder'), array('class'=>'textInput'));
// ShowFetchCurrentButton('.ui-state-hover', 'border', 'hoverborder');
// echo "<p class='formHint2'>.</p>";
// echo CUFHtml::closeCtrlHolder();

// echo CUFHtml::openCtrlHolder();
// echo CUFHtml::label('Active Border', 'site[activeborder]');
// echo CUFHtml::textField('site[activeborder]', param('activeborder'), array('class'=>'textInput'));
// ShowFetchCurrentButton('.ui-state-active', 'border', 'activeborder');
// echo "<p class='formHint2'>.</p>";
// echo CUFHtml::closeCtrlHolder();

// echo "<a id='buttonreset' title='Reset all fields in this page.'>Reset</a>";

// JavascriptReady("$('#buttonreset').button().click(function(e) {
// 	event.preventDefault();
// 	if(!confirm('Are you sure you want to reset all custom data on this page?')) return;
		
// //	$('#site_headercolor').val('');
// //	$('#site_headerback').val('');
// //	$('#site_headerborder').val('');
// //	$('#site_headerborderbot').val('');
		
// 	$('#site_buttoncolor').val('');
// 	$('#site_buttonback').val('');
// 	$('#site_buttonborder').val('');
		
// 	$('#site_hovercolor').val('');
// 	$('#site_hoverback').val('');
// 	$('#site_hoverborder').val('');
		
// 	$('#site_activecolor').val('');
// 	$('#site_activeback').val('');
// 	$('#site_activeborder').val('');
// });");

// echo "</div>";

//////////////////////////////////////////////////////////////

echo "<div id='tabs-5'>";

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Header Color', 'site[appheadercolor]');
echo CUFHtml::textField('site[appheadercolor]', param('appheadercolor'), array('class'=>'textInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Header Background', 'site[appheaderback]');
echo CUFHtml::textField('site[appheaderback]', param('appheaderback'), array('class'=>'textInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Main Color', 'site[appmaincolor]');
echo CUFHtml::textField('site[appmaincolor]', param('appmaincolor'), array('class'=>'textInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Main Background', 'site[appmainback]');
echo CUFHtml::textField('site[appmainback]', param('appmainback'), array('class'=>'textInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

// echo CUFHtml::openCtrlHolder();
// echo CUFHtml::label('Main Alpha', 'site[appmainalpha]');
// echo CUFHtml::textField('site[appmainalpha]', param('appmainalpha'), array('class'=>'textInput'));
// echo "<p class='formHint2'>From 0 to 1</p>";
// echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Slider Color', 'site[appslidercolor]');
echo CUFHtml::textField('site[appslidercolor]', param('appslidercolor'), array('class'=>'textInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Save in Guessed Folder', 'site[appautosave]');
echo CUFHtml::hiddenField('site[appautosave]', '0');
echo CUFHtml::checkBox('site[appautosave]', param('appautosave'));
echo "<p class='formHint2'>Automatically save recordings and bookmarks to the system's guessed folder.</p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";

//////////////////////////////////////////////////////////////

echo "<div id='tabs-6'>";
echo "<p>These extra links appear in the top right corner of every page.</p>";

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Link Name 1', 'site[linkname1]');
echo CUFHtml::textField('site[linkname1]', param('linkname1'), array('class'=>'textInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Link Url 1', 'site[linkurl1]');
echo CUFHtml::textField('site[linkurl1]', param('linkurl1'), array('class'=>'textInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Link Name 2', 'site[linkname2]');
echo CUFHtml::textField('site[linkname2]', param('linkname2'), array('class'=>'textInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Link Url 2', 'site[linkurl2]');
echo CUFHtml::textField('site[linkurl2]', param('linkurl2'), array('class'=>'textInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";

///////////////////////////////////////////////////////////////////////////////

echo "<div id='tabs-7'>";

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Admin Email', 'site[adminemail]');
echo CUFHtml::textField('site[adminemail]', param('adminemail'), array('class'=>'textInput'));
echo "<p class='formHint2'>Site administrator emails separated by commas.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Local Network Masks', 'site[localnetwork]');
echo CUFHtml::textField('site[localnetwork]', param('localnetwork'), array('class'=>'textInput'));
echo "<p class='formHint2'>Local network IP address ranges, separated by commas. Used in reports.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Default Prefix', 'site[defaultprefix]');
echo CUFHtml::textField('site[defaultprefix]', param('defaultprefix'), array('class'=>'textInput'));
echo "<p class='formHint2'>Prefix used to generate filenames for the comparative recorder.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Bookmark Prefix', 'site[bookmarkprefix]');
echo CUFHtml::textField('site[bookmarkprefix]', param('bookmarkprefix'), array('class'=>'textInput'));
echo "<p class='formHint2'>Prefix used to generate filenames for bookmarks.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
$teacher = getdbosql('Role', "name='teacher'");
echo CUFHtml::label("$teacher->description Prefix", 'site[commentprefix]');
echo CUFHtml::textField('site[commentprefix]', param('commentprefix'), array('class'=>'textInput'));
echo "<p class='formHint2'>Prefix used to generate filenames for $teacher->description comments.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Editor', 'site[htmleditor]');
$options = array('tiny-mce'=>'tiny-mce', 'ck-editor'=>'ck-editor', 'elrte'=>'elrte');
echo CUFHtml::dropDownList('site[htmleditor]', param('htmleditor'), $options);
echo "<p class='formHint2'>Choose one from these popular open source html editors. Elrte is recommended.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Default Domain', 'site[defaultdomain]');
echo CUFHtml::dropDownList('site[defaultdomain]', param('defaultdomain'),
		User::model()->domainOptions);
echo "<p class='formHint2'>Used when adding users through the course add roster function.</p>";
echo CUFHtml::closeCtrlHolder();

$options = array(
		CMDB_OBJECTENROLLTYPE_NONE => 'None',
	//	CMDB_OBJECTENROLLTYPE_AUTOUSER => 'Auto User',
	//	CMDB_OBJECTENROLLTYPE_AUTOSTUDENT => 'Auto Student',
	//	CMDB_OBJECTENROLLTYPE_APPROVAL => 'Approval',
		CMDB_OBJECTENROLLTYPE_SELF => 'Self',
);

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Default Enrollment', 'site[defaultenrollment]');
echo CUFHtml::dropDownList('site[defaultenrollment]', param('defaultenrollment'), $options);
echo "<p class='formHint2'>Default value used when creating courses.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Default Inherit', 'site[defaultinherit]');
echo CUFHtml::hiddenField('site[defaultinherit]', '0');
echo CUFHtml::checkBox('site[defaultinherit]', param('defaultinherit'));
echo "<p class='formHint2'>Default value used when creating courses.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Enrolled Only', 'site[enrolledonly]');
echo CUFHtml::hiddenField('site[enrolledonly]', '0');
echo CUFHtml::checkBox('site[enrolledonly]', param('enrolledonly'));
echo "<p class='formHint2'>Only users enrolled in a course in the current semester can connect.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Use Trackdoc', 'site[usetrackdoc]');
echo CUFHtml::hiddenField('site[usetrackdoc]', '0');
echo CUFHtml::checkBox('site[usetrackdoc]', param('usetrackdoc'));
echo "<p class='formHint2'>Track documents and external sites in a separate window.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Keep File Extension', 'site[keepfileextension]');
echo CUFHtml::hiddenField('site[keepfileextension]', '0');
echo CUFHtml::checkBox('site[keepfileextension]', param('keepfileextension'));
echo "<p class='formHint2'>Keep the file extension in the name when uploading files.</p>";
echo CUFHtml::closeCtrlHolder();

// echo CUFHtml::openCtrlHolder();
// echo CUFHtml::label('Launch Same Names', 'site[launchsamename]');
// echo CUFHtml::hiddenField('site[launchsamename]', '0');
// echo CUFHtml::checkBox('site[launchsamename]', param('launchsamename'));
// echo "<p class='formHint2'>Automatically launch files with the same name than the media file viewed.</p>";
// echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Shortcut as Button', 'site[shortcutbutton]');
echo CUFHtml::hiddenField('site[shortcutbutton]', '0');
echo CUFHtml::checkBox('site[shortcutbutton]', param('shortcutbutton'));
echo "<p class='formHint2'>Show shortcut links as buttons.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('MySansspace Drop Down', 'site[mysansspacedropdown]');
echo CUFHtml::hiddenField('site[mysansspacedropdown]', '0');
echo CUFHtml::checkBox('site[mysansspacedropdown]', param('mysansspacedropdown'));
echo "<p class='formHint2'>Show the drop down menu on the MySansspace tab item.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('MySansspace Tiles', 'site[mysansspacetiles]');
echo CUFHtml::hiddenField('site[mysansspacetiles]', '0');
echo CUFHtml::checkBox('site[mysansspacetiles]', param('mysansspacetiles'));
echo "<p class='formHint2'>Show the MySansspace items as tiles.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Use Semester', 'site[usesemester]');
echo CUFHtml::hiddenField('site[usesemester]', '0');
echo CUFHtml::checkBox('site[usesemester]', param('usesemester'));
echo "<p class='formHint2'>Use semesters for courses.</p>";
echo CUFHtml::closeCtrlHolder();

// echo CUFHtml::openCtrlHolder();
// echo CUFHtml::label('Video Thumbnails', 'site[usethumbnail]');
// echo CUFHtml::hiddenField('site[usethumbnail]', '0');
// echo CUFHtml::checkBox('site[usethumbnail]', param('usethumbnail'));
// echo "<p class='formHint2'>Sansspace will extract thumbnails from videos to show on the recorder time line.</p>";
// echo CUFHtml::closeCtrlHolder();

// echo CUFHtml::openCtrlHolder();
// echo CUFHtml::label('Email on Enrollment', 'site[emailenrollment]');
// echo CUFHtml::hiddenField('site[emailenrollment]', '0');
// echo CUFHtml::checkBox('site[emailenrollment]', param('emailenrollment'));
// echo "<p class='formHint2'>Sansspace will send an email to inform users when they
// 	are enrolled by an automated script running on this server.</p>";
// echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Show Role', 'site[showrole]');
echo CUFHtml::hiddenField('site[showrole]', '0');
echo CUFHtml::checkBox('site[showrole]', param('showrole'));
echo "<p class='formHint2'>For debugging purposes.</p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";

//////////////////////////////////////////////////////////////

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();




