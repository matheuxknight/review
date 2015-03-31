
var ckeditor_config = 
{
	skin: 'v2',
	height: 375,
	contentsCss: '/sansspace/ui/css/main.css',

	filebrowserImageBrowseUrl: 
		'/extensions/ckfinder/ckfinder.html?type=Images',
		
	toolbar:
	[
	{ name: 'basicstyles', items : 
	[ 'Bold', 'Italic', 'Underline', 'Strike', '-', 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
	{ name: 'styles', items : [ 'Format','Font','FontSize' ] },
	
	'/',
	{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-', 'Undo','Redo' ] },
	{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent', '-','Blockquote','CreateDiv' ] },
	{ name: 'insert', items : [ 'Image','Table','HorizontalRule','Link','Unlink','Anchor', 'PageBreak', 'Maximize' ] },
	
	'/',
	{ name: 'colors', items : [ 'TextColor','BGColor' ] },
	{ name: 'document', items : [ 'Preview','Print','-', 'Templates' ] },
	{ name: 'editing', items : [ 'Find','Replace','-','SpellChecker' ] },
	{ name: 'last', items : [ 'Smiley', 'SpecialChar', 'RemoveFormat', 'ShowBlocks', 'Source', 'Save' ] }
	]
};

function onShowObjectEditor(elementid)
{
	var editor;
	
	$('#'+elementid+'_dialog_div').remove();
	$('body').append(
		'<div id="'+elementid+'_dialog_div" style="padding: 0" />');

	$('#'+elementid+'_dialog_div').dialog(
	{
		title: 'HTML Editor',
		autoOpen: false, 
		width: 700, 
		height: 520, 
		minWidth: 560,
		minHeight: 300,
		modal: true,
		
		resize: function(event, ui){
			objectEditorResize(editor, elementid);
		},
		
		beforeClose: function(event, ui)
		{
			if(param_editor == 'elrte')
			{
				var content = $("#"+elementid+"_dialog_text").elrte('val');
				$('#'+elementid).val(content);

				$("#"+elementid+"_dialog_text").elrte('destroy');
			}
			
			else if(param_editor == 'ck-editor')
			{
				var content = editor.getData();
				$('#'+elementid).val(content);
	
				editor.destroy();
			}
			
			else
			{
				var content = tinyMCE.get(elementid+'_dialog_text').getContent();
				$('#'+elementid).val(content);
				
				tinyMCE.get(elementid+'_dialog_text').remove();
				$('#'+elementid+'_dialog_text').remove();
			}
		}
	}).dialogExtend(
	{
		maximize: true,
		dblclick: 'maximize',
		events:
		{
			maximize: function(evt, dlg){
				objectEditorResize(editor, elementid);
			},
			restore: function(evt, dlg){
				objectEditorResize(editor, elementid);
			}
		}
	});
	
	$('#'+elementid+'_dialog_div').html(
		'<textarea id="'+elementid+'_dialog_text" name="'+elementid+'_dialog_text"></textarea>');

	$('#'+elementid+'_dialog_div').dialog('open');
	$('#'+elementid+'_dialog_text').val($('#'+elementid).val());
	
	if(param_editor == 'elrte')
	{
		var opts = {
			lang: 'en',
			styleWithCSS: false,
			toolbar: 'custom3',
			resizable: false,
			allowSource: true,
			cssfiles: ['/sansspace/ui/css/main.css', '/extensions/elrte/css/elrte-inner.css'],
			
			save_onsavecallback: function()
			{
				$('#'+elementid+'_dialog_div').dialog("close");
				$('form:first').submit();
			},
			
			fmAllow: true,
			fmOpen: function(type, fc)
			{
				onShowObjectBrowser(0, false, true, 
					'variableid', 'updateid', 'myfolders', 'myfolders', 
					function(selectedid, selectedname)
					{
						if(type == 'url')
							fc("/contents/object-"+selectedid+".png");
						
						else if(type == 'object')
							fc(selectedid);
					});
			}
		};
	
		editor = $("#"+elementid+"_dialog_text").elrte(opts);
		objectEditorResize(editor, elementid);
	}
	
	else if(param_editor == 'ck-editor')
	{
		editor = CKEDITOR.replace(elementid+"_dialog_text", ckeditor_config);
	}
	
	else
	{
	tinyMCE.init(
	{
		mode: "exact",
		elements: elementid+"_dialog_text",
		content_css: "/sansspace/ui/css/main.css",
		convert_urls: false,
		relative_urls: false,

		theme: "advanced",
		skin: "default",
		width: "100%",
		height: "478",
		
		plugins: "pagebreak,table,advimage,advlink,emotions,inlinepopups,searchreplace,contextmenu,paste,fullscreen,noneditable,visualchars,nonbreaking,save",
		extended_valid_elements: "embed[src|quality|width|height|name|type|pluginspage],script,video[controls|autoplay],audio[controls|autoplay],device,source[src]",

		theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect,|,forecolor,backcolor",
		theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,link,unlink,image,anchor,hr,pagebreak,|,fullscreen",
		theme_advanced_buttons3: "tablecontrols,|,charmap,emotions,iespell,|,visualchars,visualaid,|,code,removeformat,|,save",

		theme_advanced_toolbar_location: "top",
		theme_advanced_toolbar_align: "left",
		theme_advanced_statusbar_location: "bottom",
		
		save_onsavecallback: function()
		{
			var content = tinyMCE.get(elementid+'_dialog_text').getContent();
			$('#'+elementid).val(content);
		
			$('form:last').submit();
		}
	});
	}
}

function objectEditorResize(editor, elementid)
{
	if(param_editor == 'elrte')
	{
		var h = $('#'+elementid+'_dialog_div').parent().height();
		
		$('#'+elementid+'_dialog_div .workzone').height(h-166);
		$('#'+elementid+'_dialog_div iframe').height(h-166);
		$('#'+elementid+'_dialog_text').height(h-166);
	}
	
	else if(param_editor == 'ck-editor')
	{
		var h = $('#'+elementid+'_dialog_div').parent().height();
		editor.resize('100%', h-33, false);
	}
	
	else
	{
		var h = $('#'+elementid+'_dialog_text_parent').parent().height();
		$('#'+elementid+'_dialog_text_tbl').css("height", "");
		$('#'+elementid+'_dialog_text_ifr').css("height", h-103);
	}
}

