//
// SansspacePlayer
//

var SansspacePlayer = 
{
	mouseisdown: false,
	id: 0,
	objectid: 0,
	
	init: function(id)
	{
		this.id = "#"+id;

		var m = window.location.href.match(/id=(\d+)/);
		this.objectid = m[1];

		document.onmouseup = $.proxy(this.mouseup, this);
		document.onmousemove = $.proxy(this.mousemove, this);
		window.onbeforeunload = $.proxy(this.unload, this);

	//	RightClick.init(id);
	},
	
	mouseup: function()
	{
		this.mouseisdown = false;
	},
	
	mousedown: function()
	{
		this.mouseisdown = true;
	},
	
	mousemove: function(event)
	{
		if(!this.mouseisdown) return;
		var e = arguments[0] || event;
		
		var top = $(this.id).offset().top;
		var scroll = $(window).scrollTop();
		
		var height = e.clientY - top + scroll;
		$(this.id).css('height', height);
	},

	unload: function()
	{
		var b = $(this.id)[0].CloseApplication();
		if(!b) return 'Your recording has not been saved to the server. '+
			'If you leave this page now, you will loose your current recording.';
		
		$.ajax({url: '/object/leavepage?id='+this.objectid, async: false});
	}
};

function setFlashMovieHeight(height)
{
	if(flashfullbrowser_height) return;
	$(SansspacePlayer.id).css('height', height);
}

var flashfullbrowser_height=0;

function setFlashFullBrowser(full)
{
	if(full)
	{
		$(window).scrollTop(0);
		$(SansspacePlayer.id).addClass('recorder-fullbrowser');
		
		flashfullbrowser_height = $(SansspacePlayer.id).css('height');
		
		var h = $(window).height();
		$(SansspacePlayer.id).css('height', h);
	}
	else
	{
		$(SansspacePlayer.id).removeClass('recorder-fullbrowser');
		$(SansspacePlayer.id).css('height', flashfullbrowser_height);
		flashfullbrowser_height = 0;
	}
}



