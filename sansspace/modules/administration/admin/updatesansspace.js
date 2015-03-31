//
// UpdateSansspace
//

var UpdateSansspace = 
{
	counter: 1,
	maxcount: 100,
	increment: .2,
	interval: 1000,
	interval2: 30000,
	installing: false,
	tagname: "",
	messagename: "",
	
	updatelink: "/admin/updateinternal",
	defaultlink: "/admin/maintenance",
	
	init: function(tagname, messagename)
	{
		this.tagname = tagname;
		this.messagename = messagename;
		
		document.body.style.cursor = 'wait';
		if(confirm("Are you sure you want to update the SANSSpace software?"))
		{
			$(this.messagename).html("Downloading Software...");
			$.get(this.updatelink, "", $.proxy(this.install, this));
			
			this.update();
		}
		
		else
			window.location = this.defaultlink;
	},
	
	install: function(data)
	{
		$(this.messagename).html("Installing Software...");
		setTimeout($.proxy(this.install2, this), this.interval2);
	},
	
	install2: function()
	{
		this.installing = true;
	},
	
	update: function()
	{
		if(this.counter >= this.maxcount || this.installing)
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


