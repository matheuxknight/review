
var currentpagenumber = 1;
var currentobjectid = 0;
var currentsearchtitle = '';
//
function initSearchBar(id, searchtitle, format, defaultsort, defaultsemester, defaultfilter)
{
	currentobjectid = id;
	currentsearchtitle = searchtitle;

	$('#showpanel').button({icons: {secondary: "ui-icon-triangle-1-e"}, text: true});
	$('#showpanel').change(function(event)
	{
		if($('#showpanel').is(':checked'))
			$('#searchpanel').css({display:'inline'});

		else
			$('#searchpanel').css({display:'none'});
	});

	$('#'+format).attr('checked', 'true');
	$('#showall').attr('checked', 'true');

//	$('#showoptions1').buttonset();
	$('#showoptions2').buttonset();

	$('#showsmall').button({icons: {primary: "ui-icon-showsmall"}, text: false});
	$('#showmedium').button({icons: {primary: "ui-icon-showmedium"}, text: false});
	$('#showdetail').button({icons: {primary: "ui-icon-showdetail"}, text: false});

	$('#showall').button();
	$('#showlink').button({icons: {primary: "ui-icon-showlink"}, text: false});
	$('#showfile').button({icons: {primary: "ui-icon-showfile"}, text: false});
	$('#showcourse').button({icons: {primary: "ui-icon-showcourse"}, text: false});
	$('#showactivity').button({icons: {primary: "ui-icon-showactivity"}, text: false});
	$('#showfolder').button({icons: {primary: "ui-icon-showfolder"}, text: false});

	$('.ui-buttonset').change(function(event)
	{
		clearTimeout(this.searching);
		refreshContentPage();
	});

	$('#recursive').button();
	$('#recursive').change(function(event)
	{
		clearTimeout(this.searching);
		refreshContentPage();
	});

	$('#sortdropdown').val(defaultsort);
	$('#sortdropdown').change(function(event)
	{
		clearTimeout(this.searching);
		refreshContentPage();
	});

	$('#filterdropdown').val(defaultfilter);
	$('#filterdropdown').change(function(event)
	{
		clearTimeout(this.searching);
		refreshContentPage();
	});

	$('#semesterid').val(defaultsemester);
	$('#semesterid').change(function(event)
	{
		clearTimeout(this.searching);
		refreshContentPage();
	});

	$('#search').bind('keyup', function(event)
	{
		clearTimeout(this.searching);
		this.searching = setTimeout(function()
		{
			refreshContentPage();
		}, 800);
	});

	$('#search').css('height', '16px');
//	$('#sortdropdown').css('height', '22px');
//	$('#semesterid').css('height', '22px');

	refreshContentPage();
}

function refreshContentPage()
{
//	$('#results').html(
//		"<p style='margin-left: 300px;'><img src='/images/ui/loading_white.gif'></p>");

	var searchstring = $('#search').val();
	if(searchstring == currentsearchtitle)
		searchstring = '';
	
	$.get("/html/objectresults"+
		"&id="+currentobjectid+
		"&s="+searchstring+
		"&sort="+$('#sortdropdown').val()+
		"&filter="+$('#filterdropdown').val()+
		"&semesterid="+$('#semesterid').val()+
		"&recursive="+$('#recursive').is(':checked')+
	//	"&filter="+$('input[name=showoptions1]:checked').attr('id')+
		"&layout="+$('input[name=showoptions2]:checked').attr('id')+
		"&page="+currentpagenumber,
		"", function(data)
	{
		$('#results').html(data);
	});
}



