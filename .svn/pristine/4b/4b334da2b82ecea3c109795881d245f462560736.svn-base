//
// BrowserSession
//

$(function()
{
	BrowserSession.init();
});

var BrowserSession =
{
	intervals: [1000, 10000, 10000, 30000, 30000, 30000],
	intervalindex: 0,

	defaultlink: "/connection/ping",

	init: function()
	{
		this.wait();
	},

	wait: function()
	{
		setTimeout($.proxy(this.update, this), this.intervals[this.intervalindex]);

		if(this.intervalindex < this.intervals.length-1)
			this.intervalindex++;
	},

	update: function()
	{
		$.get(this.defaultlink+"?i="+this.intervalindex, "", $.proxy(this.receive, this))
			.error($.proxy(this.wait, this));
	},

	receive: function(data)
	{
		var logoff = $("logoff", data).text();
		if(logoff == 1)
		{
			window.location.href = '/site/logout';
			return;
		}

		var s = "Who\'s Online (" + $("online", data).text() + ")";
		$("#whos_online").html(s);

		var needrefresh = $("refresh", data).text();
		if(needrefresh == 1) refreshContentPage();

	//	var totalchatcount = $("chatcount", data).text();
	//	if(totalchatcount != 0)
	//		$("#totalchatcount").html(" ("+totalchatcount+")");
	//	else
	//		$("#totalchatcount").html("");

		// var chatmenu = $("chatmenu", data).text();
	//	$("#chatoptions").html(chatmenu);

		var netmessage = $("netmessage", data).text();
		$("#netmessage").html(netmessage);

		this.wait();
	},


	dum: 0
};




///
//var s = "<a href=\'index.php?r=user/online\'>Who\'s Online (" + $("online", data).text() + ")</a>";
//$("#whos_online").html(s);
//
//if($("inbox", data).text() != '0')
//{
//	var s = "<a href=\'index.php?r=pm/inbox\'>My Inbox (" + $("inbox", data).text() + ")</a>";
//	$("#inbox").html(s);
//}
//
//if($("call", data).text() != '0')
//{
//	var s = "<a href=\'index.php?r=call/list\'><font color=red>New Call (" + $("call", data).text() + ")</font></a>";
//	$("#incoming_cell").html(s);
//
//	count = 2;
//	setTimeout("gotcall1()", 500);
//
//	//PlaySound("sound1");
//}
//function PlaySound(soundObj)
//{
//	var sound = document.getElementById(soundObj);
//	sound.Play();
//}

//function gotcall1()
//{
//	if(!count) return;
//	count--;
//
//	$("#incoming_cell").hide();
//	setTimeout("gotcall2()", 200);
//}
//
//function gotcall2()
//{
//	$("#incoming_cell").show();
//	setTimeout("gotcall1()", 500);
//}
