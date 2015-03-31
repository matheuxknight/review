<?php

function showTextEditorButton($updateid)
{
	echo "<a id='editorbutton_{$updateid}'>Edit</a>";
	echo "<script>$(function(){ $('#editorbutton_{$updateid}').button({
icons:{primary: 'ui-icon-pencil'}, text: false
}).click(function(e){onShowTextEditor('$updateid');});});</script>";
}

function showObjectEditorButton($updateid)
{
	echo "<a id='editorbutton_{$updateid}'>Edit</a>";
	echo "<script>$(function(){ $('#editorbutton_{$updateid}').button({
icons:{primary: 'ui-icon-pencil'}, text: false
}).click(function(e){onShowObjectEditor('$updateid');});});</script>";
}

function showAttributeEditor($model, $attribute, $height=160, $toolbar='custom1')
{
	$id = get_class($model).'_'.$attribute;
	showHtmlEditor($id, $height, $toolbar);
}

////////////////////////////////////////////////////////////////////////////////////////

function showHtmlEditor($id, $height=160, $toolbar='custom1')
{
	if(param('htmleditor') == 'elrte')
	{
		$showsource = 'false';
		$hidestatus = 'false';
		
		if($toolbar=='custom2' || $toolbar=='custom4')
			$showsource = 'true';
		
		if($toolbar=='custom1' || $toolbar=='custom4')
			$hidestatus = 'true';
		
		JavascriptReady("
		$('#$id').width('100%');
		var opts =
		{
			lang: 'en',
			styleWithCSS: false,
			height: $height,
			toolbar: '$toolbar',
			resizable: true,
			allowSource: $showsource,
			hideStatusbar: $hidestatus,
			cssfiles: ['/sansspace/ui/css/main.css', '/extensions/elrte/css/elrte-inner.css'],
	
			fmAllow: true,
			fmOpen: function(type, fc)
			{
				onShowObjectBrowser(0, false, true, 'variableid', 'updateid', 'myfolders', 'myfolders',
				function(selectedid, selectedname)
				{
					if(type == 'url')
						fc('/contents/object-'+selectedid+'.png');
						
					else if(type == 'object')
						fc(selectedid);
				});
			}
		};
	
		$('#$id').elrte(opts);");
	}

	else if(param('htmleditor') == 'ck-editor')
	{
		echo "<script>CKEDITOR.replace('$id', ckeditor_config);</script>";
	}

	else
	{
	$cssfile = '/sansspace/ui/css/main.css';
	echo <<<END
	<script>
	tinyMCE.init(
	{
	mode: "exact",
	elements: "$id",
	content_css: "$cssfile",
	convert_urls: false,
		relative_urls: false,

		theme: "advanced",
		skin: "default",
		width: "100%",
		height: "320",

		plugins: "pagebreak,table,advimage,advlink,emotions,inlinepopups,searchreplace,contextmenu,paste,fullscreen,noneditable,visualchars,nonbreaking,save",
		extended_valid_elements:
			"embed[src|quality|width|height|name|type|pluginspage],script",

		theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect,|,forecolor,backcolor",
		theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,link,unlink,image,anchor,hr,pagebreak,|,fullscreen",
		theme_advanced_buttons3: "tablecontrols,|,charmap,emotions,iespell,|,visualchars,visualaid,|,code,removeformat,|,save",

		theme_advanced_toolbar_location: "top",
		theme_advanced_toolbar_align: "left",
		theme_advanced_statusbar_location: "bottom",
	});

	</script>
END;
	}
}














