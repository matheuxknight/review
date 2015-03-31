
function initObjectMenu(objectid)
{
	var anchor = $('#object_anchor_'+objectid);
//	var quickview = $('#object_quickview_'+objectid);
//	var parent = $('#object_parent_'+objectid);
	var box = $('#object_box_'+objectid);
	var item = $('#object_item_'+objectid);
	
	item.init = false;
	item.over = false;
	
	var show = function()
	{
		box.fadeIn(100);
		if(!item.init)
		{
			item.init = true;
			$.get("/html/menuobject&id="+objectid, "", function(data)
			{
				box.empty();
				box.append(data);
			}).error(function(e)
			{
//				alert(e.statusText);
//				$.get("/html/menuobject&id="+objectid, "", function(data)
//				{
//					box.empty();
//					box.append(data);
//				});
			});
		}
	};
	
	var getIn = function(e)
	{
		anchor.click(getOut);
		item.over = true;

		clearTimeout(item.timer);
		item.timer = setTimeout(function()
		{
			show();
		}, 500);
	};
	
	var getOut = function(e)
	{
		anchor.click(getIn);
		item.over = false;

		clearTimeout(item.timer);
		item.timer = setTimeout(function()
		{
			if(item.over) return;
			box.fadeOut(100);
		}, 500);
	};
	
	item.hover(getIn, getOut);
	anchor.click(show);
}

///////////////////////////////////////////////////////////

function onShowQuickView(elementid, elementname, elementheight)
{
	var element = '#'+elementid+'_dialog_div';
	$(element).remove();
	
	$('body').append('<div id="'+elementid+
		'_dialog_div" style="padding: 0; margin: 0;" ></div>');

	var dialog = $(element).dialog(
	{
		width: 700, minWidth: 400, 
		height: elementheight, minHeight: 140, 
		modal: false,
		title: elementname,
		resize: function(event, ui) {},
		beforeClose: function(event, ui)
		{
			if($('#sansmediad_'+elementid).length > 0)
				$('#sansmediad_'+elementid)[0].CloseApplication();
		}
	}).dialogExtend(
	{
		'maximize': true,
		'dblclick': 'maximize'
	});
	
	$.get("/html/quickfile&id="+elementid, function(data)
	{
		$(element).html(data);
	});
}

/////////////////////////////////////////////////////////

function object_buildsubmenu(menuid)
{
	var $self = $("#"+menuid);
	$self.css('display', 'block');

	$self[0].isover = false;

	var $subul = $self.find('ul:eq(0)');

	$self[0]._dimensions = 
	{
		left:$self[0].offsetWidth, 
		top:$self[0].offsetTop
	};

//	$subul.css({top: 0});
	$self.children("a:eq(0)").append('<img src="'+
		sansspace_arrowimages.right[1] + '" class="rightarrowclass2" style="border:0;" />');

	var thisitem = $self[0];

	$self.children("a").click(function(e)
	{
		thisitem.isover = false;
		clearTimeout(thisitem.timer);

		$(thisitem).children("ul:eq(0)").fadeOut(100);
	});

	$self.hover(function(e)
	{
		thisitem.isover = true;
		this.timer = setTimeout(function()
		{
			var $targetul = $(thisitem).children("ul:eq(0)");

			$targetul.css({left:thisitem._dimensions.left+"px", 
				top: thisitem._dimensions.top+"px"}).fadeIn(100);

		}, 350);
	},
	function(e)
	{
		thisitem.isover = false;
		clearTimeout(thisitem.timer);

		setTimeout(function()
		{
			if(!thisitem.isover)
				$(thisitem).children("ul:eq(0)").fadeOut(100);
		}, 500);
	});

	var $mainmenu = $("#"+menuid+">ul");
	$mainmenu.css({display:'none', visibility:'visible'});

}









