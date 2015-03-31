//
// TranscodeObject
//

var TranscodeObject =
{
	link: "/html/loadtranscodeinfo",
	id: 0,

	init: function(id)
	{
		this.id = id;

		$('#loading').hide();
		$('#buttonload').button().click($.proxy(this.update, this));
	},

	update: function()
	{
		$('#loading').show();
		$('#transcodeinforesults').hide();

		var link = this.link;
		link += "?id=" + this.id;

		$.get(link, "", $.proxy(this.receive, this));
	},

	receive: function(data)
	{
		$('#loading').hide();

		$('#transcodeinforesults').show();
		$("#transcodeinforesults").html(data);
	},

	dum: 0
};

