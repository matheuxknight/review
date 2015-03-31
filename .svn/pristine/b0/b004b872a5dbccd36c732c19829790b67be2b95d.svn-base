
function initUserMenu(userid)
{
	var anchor = $('#user_anchor_'+userid);
	var quickview = $('#user_quickview_'+userid);
	var parent = $('#user_parent_'+userid);
	var box = $('#user_box_'+userid);
	var item = $('#user_item_'+userid);
	
	item.init = false;
	item.over = false;
	
	parent.hover(
		function(e)
		{
			anchor.fadeIn(10);
			if(quickview.length) quickview.fadeIn(10);
		},
		function(e)
		{
			anchor.fadeOut(10);
			if(quickview.length) quickview.fadeOut(10);
		});
	
	/////////////////////////////////////////////////////////
	
	item.click(function(e)
	{
		item.over = false;
		clearTimeout(item.timer);
		
		box.fadeOut(100);
	});
	
	item.hover(function(e)
	{
		item.over = true;
		clearTimeout(item.timer);
		
		item.timer = setTimeout(function()
		{
			box.fadeIn(100);
			if(!item.init)
			{
				item.init = true;
				$.get("/user/menuuser&id="+userid, "", function(data)
				{
					box.empty();
					box.append(data);
				});
			}
		}, 500);
	},
	
	function(e)
	{
		item.over = false;
		clearTimeout(item.timer);
		
		item.timer = setTimeout(function()
		{
			if(item.over) return;
			box.fadeOut(100);
		}, 500);
	});
	
}





