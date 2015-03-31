//
// RestartService
//

var RestartService = 
{
	counter: 0,
	maxcount: 100,
	increment: 5,
	interval: 1000,
	interval2: 5000,
	tagname: "",
	messagename: "",
	restarting: false,
	
	restartlink: "/admin/restartinternal",
	defaultlink: "/admin/maintenance",
	
	init: function(tagname, messagename)
	{
		this.tagname = tagname;
		this.messagename = messagename;
		
		document.body.style.cursor = 'wait';
		if(confirm("Are you sure you want to restart the SANSSpace service?"))
		{
			$(this.messagename).html("Connecting to Server...");
			$.get(this.restartlink, "", $.proxy(this.ready1, this));
			
			this.update();
		}
		
		else
			window.location = this.defaultlink;
	},
	
	ready1: function(data)
	{
		$(this.messagename).html("Restarting Server...");
		setTimeout($.proxy(this.ready2, this), this.interval2);
	},
	
	ready2: function(data)
	{
		this.restarting = true;
	},
	
	update: function()
	{
		if(this.counter >= this.maxcount || this.restarting)
		{
			$.get("/index.php", "", $.proxy(this.success, this))
				.error($.proxy(this.settimeout, this));

			return;
		}
		
		this.counter += this.increment;
		$(this.tagname).progressbar({value: this.counter});
		
		this.settimeout();
	},
	
	settimeout: function()
	{
		setTimeout($.proxy(this.update, this), this.interval);
	},
	
	success: function()
	{
		window.location = this.defaultlink;
	}
		
};


