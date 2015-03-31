

var dhxob_allowfolder;
var dhxob_allowfile;
var dhxob_saveas;

var dhxob_selectedid;
var dhxob_selectedname;

var dhxob_returnid;
var dhxob_returnname;

var dhxob_selectcallback; 

function onShowObjectBrowser(saveas, allowfolder, allowfile, returnid, returnname,
	selectedid, selectedname, selectcallback)
{
	dhxob_allowfolder = allowfolder;
	dhxob_allowfile = allowfile;
	dhxob_saveas = saveas;
	
	dhxob_returnid = returnid;
	dhxob_returnname = returnname;
	
	dhxob_selectcallback = selectcallback;

//	selectedname = encodeURIComponent(selectedname);

	$('#'+returnid+'_dialog_div').remove();
	$('body').append('<div id="'+returnid+'_dialog_div" style="padding: 0px;" />');
	
	$('#'+returnid+'_dialog_div').dialog(
	{
		title: 'Object Browser',
		autoOpen: true, 
		width: 640, 
		height: 480, 
		minWidth: 300,
		minHeight: 200,
		modal: true,
		
		resize: function(event, ui){UpdateObjectBrowserSize();},
		beforeClose: function(event, ui){},
		
		buttons:
		{
			Cancel: function(){ $(this).dialog("close");},
			Ok: function(){ SelectObjectBrowser();}
		}

	}).dialogExtend(
	{
		maximize: true,
		dblclick: 'maximize',
		events:
		{
			maximize: function(evt, dlg){UpdateObjectBrowserSize();},
			restore: function(evt, dlg){UpdateObjectBrowserSize();}
		}
	});

	$.get('/html/browseheader&saveas='+dhxob_saveas+'&returnid='+dhxob_returnid, '', function(data)
	{
		$('#'+returnid+'_dialog_div').html(data);
		SelectCurrentObjectBrowser(selectedid, selectedname);
	});
}

function SelectCurrentObjectBrowser(selectedid, selectedname)
{
	dhxob_selectedid = selectedid;
	dhxob_selectedname = selectedname;
//	dhxob_selectedname = encodeURIComponent(selectedname);

	$('#currentlist_'+dhxob_returnid).empty();
	$.get('/html/browseobject&id='+selectedid+"&allowfile="+dhxob_allowfile+'&returnid='+dhxob_returnid, '', function(data)
	{
		if(data == 'select')
		{
			SelectObjectBrowser();
			return;
		}
		
		$('#currentlist_'+dhxob_returnid).append(data);
	});
	
	UpdateObjectBrowserSize();
}

function SelectObjectBrowser()
{
	if(dhxob_returnid != '')
		$('#'+dhxob_returnid).val(dhxob_selectedid);
	
	if(dhxob_returnname != '')
		$('#'+dhxob_returnname).val(dhxob_selectedname);
	
	if(dhxob_selectcallback)
	{
		if(dhxob_saveas)
			dhxob_selectcallback(dhxob_selectedid, $('#saveasinput_'+dhxob_returnid).val());
		else
			dhxob_selectcallback(dhxob_selectedid, dhxob_selectedname);
	}
	
	$('#'+dhxob_returnid+'_dialog_div').dialog('close');
}

function UpdateObjectBrowserSize()
{
	var h = $('#objectbrowsertemplate_'+dhxob_returnid).height();
	
	if(dhxob_saveas)
		$('#contentlist_'+dhxob_returnid).css("height", h-64);
	else
		$('#contentlist_'+dhxob_returnid).css("height", h-38);
}




