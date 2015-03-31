<?php

if($update)
	ShowUploadHeader();

$this->widget('UniForm');

//echo CUFHtml::beginForm();
echo CUFHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data'));
echo CUFHtml::errorSummary($domain);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#tabs');

echo "<div id='tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1'>General</a></li>";

if($domain->id != 1)
{
	echo "<li><a href='#tabs-2'>LDAP</a></li>";
	echo "<li><a href='#tabs-3'>CAS</a></li>";
}

//echo "<li><a href='#tabs-4'>Roster</a></li>";
//echo "<li><a href='#tabs-4'>Windows</a></li>";
echo "</ul><br>";

//////////////////////////////////////////////////////////////////////

echo "<div id='tabs-1'>";

//echo "<p>If you enable none of the LDAP or Windows section, the user account 
//information will be managed by SANSSpace, for this domain.</p>";

echo CUFHtml::openActiveCtrlHolder($domain, 'name');
echo CUFHtml::activeLabelEx($domain,'name');
echo CUFHtml::activeTextField($domain,'name',array('maxlength'=>200));
echo "<p class='formHint2'>Name of the domain. In the case of an LDAP domain, this name MUST be the same as the local network domain name.</p>";
echo CUFHtml::closeCtrlHolder();

if($domain->id != 1)
{
echo CUFHtml::openActiveCtrlHolder($domain, 'enable');
echo CUFHtml::activeLabelEx($domain, 'enable');
echo CUFHtml::activeCheckBox($domain, 'enable', array('class'=>'miscInput'));
echo "<p class='formHint2'>Enable authentication from the domain.</p>";
echo CUFHtml::closeCtrlHolder();
}

echo "</div>";

//////////////////////////////////////////////////////////////////////

echo "<div id='tabs-2'>";
if($domain->id != 1)
{
echo CUFHtml::openActiveCtrlHolder($domain, 'ldapenable');
echo CUFHtml::activeLabelEx($domain, 'ldapenable');
echo CUFHtml::activeCheckBox($domain, 'ldapenable', array('class'=>'miscInput'));
echo "<p class='formHint2'>Enable LDAP authentication for the domain.</p>";
echo CUFHtml::closeCtrlHolder();

//echo CUFHtml::openActiveCtrlHolder($domain, 'ldaptype');
//echo CUFHtml::activeLabelEx($domain, 'ldaptype');
//echo CUFHtml::activeDropDownList($domain, 'ldaptype', Domain::model()->ldaptypeOptions);
//echo "<p class='formHint2'>The protocol supported by your LDAP server. 
//Recent Windows server can use Negotiate and older Windows can use NTLM.</p>";
//echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($domain, 'ldapssl');
echo CUFHtml::activeLabelEx($domain,'ldapssl');
echo CUFHtml::activeCheckBox($domain,'ldapssl', array('class'=>'miscInput'));
echo "<p class='formHint2'>Use encrypted connections to connect to the LDAP server on the TCP/IP port number <b>636</b> 
		instead of the regular <b>389</b>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($domain, 'ldapserver');
echo CUFHtml::activeLabelEx($domain,'ldapserver');
echo CUFHtml::activeTextField($domain,'ldapserver', array('maxlength'=>200));
echo "<p class='formHint2'>Name or IP address of your LDAP server. Separated by a space if you have more than one.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($domain, 'ldapdn');
echo CUFHtml::activeLabelEx($domain, 'ldapdn');
echo CUFHtml::activeTextField($domain, 'ldapdn', array('maxlength'=>200));
echo "<p class='formHint2'>The base distinguised name format used by your LDAP server.
		Click the Test Connection button below to fetch the default Base DN from the server. 
		Example: dc=domain,dc=com</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($domain, 'ldapuid');
echo CUFHtml::activeLabelEx($domain, 'ldapuid');
echo CUFHtml::activeTextField($domain, 'ldapuid', array('maxlength'=>200));
echo "<p class='formHint2'>The key for account name. Examples: uid, sn, cn, sAMAccountName,  ...</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($domain, 'ldapdisplayname');
echo CUFHtml::activeLabelEx($domain, 'ldapdisplayname');
echo CUFHtml::activeTextField($domain, 'ldapdisplayname', array('maxlength'=>200));
echo "<p class='formHint2'>The key to get users' display name.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($domain, 'ldapemail');
echo CUFHtml::activeLabelEx($domain, 'ldapemail');
echo CUFHtml::activeTextField($domain, 'ldapemail', array('maxlength'=>200));
echo "<p class='formHint2'>The key to get users' email.</p>";
echo CUFHtml::closeCtrlHolder();

//echo CUFHtml::openActiveCtrlHolder($domain, 'ldapfilter');
//echo CUFHtml::activeLabelEx($domain, 'ldapfilter');
//echo CUFHtml::activeTextField($domain, 'ldapfilter', array('maxlength'=>200));
//echo "<p class='formHint2'>This filter restricts the namespace. For example,  objectClass=posixGroup would result in the use of (&(uid=\$username)(objectClass=posixGroup))</p>";
//echo CUFHtml::closeCtrlHolder();

echo "<input type='submit' id='testconnection' name='testconnection' value='Test Connection'>";
echo "<script>$(function(){ $('#testconnection').button();});</script>";
echo "</div>";
}

echo "<div id='tabs-3'>";
if($domain->id != 1)
{
echo CUFHtml::openActiveCtrlHolder($domain, 'casenable');
echo CUFHtml::activeLabelEx($domain, 'casenable');
echo CUFHtml::activeCheckBox($domain, 'casenable', array('class'=>'miscInput'));
echo "<p class='formHint2'>Enable CAS (Central Authentication Service) support for the domain.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($domain, 'casautologin');
echo CUFHtml::activeLabelEx($domain, 'casautologin');
echo CUFHtml::activeCheckBox($domain, 'casautologin', array('class'=>'miscInput'));
echo "<p class='formHint2'>Enable CAS auto login.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($domain, 'casexclusive');
echo CUFHtml::activeLabelEx($domain, 'casexclusive');
echo CUFHtml::activeCheckBox($domain, 'casexclusive', array('class'=>'miscInput'));
echo "<p class='formHint2'>Enable CAS exclusive login.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($domain, 'casserver');
echo CUFHtml::activeLabelEx($domain,'casserver');
echo CUFHtml::activeTextField($domain,'casserver', array('maxlength'=>200));
echo "<p class='formHint2'>Name or IP address of your CAS server.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($domain, 'casport');
echo CUFHtml::activeLabelEx($domain, 'casport');
echo CUFHtml::activeTextField($domain, 'casport', array('maxlength'=>200));
echo "<p class='formHint2'>The port number of your CAS server. Usually <b>443</b>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($domain, 'cascontext');
echo CUFHtml::activeLabelEx($domain, 'cascontext');
echo CUFHtml::activeTextField($domain, 'cascontext', array('maxlength'=>200));
echo "<p class='formHint2'>The url context of your CAS service. Example: <b>/cas-server-webapp-3.5.1</b></p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";
}

echo "</div>";

echo CUFHtml::closeTag('fieldset');
showSubmitButton($update? 'Save': 'Create');
echo CUFHtml::endForm();

