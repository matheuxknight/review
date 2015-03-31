//
// SansspaceFileSessionToolbar
//

var SansspaceFileSessionToolbar =
{
	chartlink: "/filesession/chartresults",
	loglink: "/filesession/logresults",

	currentlink: this.chartlink,
	extraparams: "",

	semesters: [],
	others: [],

	pagenumber: 1,

	////////////////////////////////////////////////////////////////////////////

	initchart: function(p)
	{
		this.extraparams = p;
		this.currentlink = this.chartlink;
		this.update();
	},

	initlog: function(p)
	{
		this.extraparams = p;
		this.currentlink = this.loglink;
		this.update();
	},

	update: function()
	{
		$('#loading').show();
		$('#statresults').hide();

		var link = this.currentlink;

		link += "?after=" + $('#after').val();
		link += "&before=" + $('#before').val();
		link += "&semesterid=" + $('#semester').val();
		link += "&year=" + $('#year').val();
		link += "&month=" + $('#month').val();
		link += "&other=" + $('#other').val();
		link += "&scale=" + $('#scale').val();
		link += "&group=" + $('#group').val();
		link += "&type=" + $('#type').val();
		link += "&users=" + $('#searchusers').val();
		link += "&id=" + $('#objectid').val();
		link += this.extraparams;
		link += "&page=" + this.pagenumber;

		$.get(link, "", $.proxy(this.receive, this));
	},

	receive: function(data)
	{
		$('#loading').hide();

		$('#statresults').show();
		$("#statresults").html(data);
	},

	////////////////////////////////////////////////////////////////////////////

	addSemester: function(i, s, e)
	{
		this.semesters.push({id: i, starttime: s, endtime: e});
	},

	semesterChanged: function()
	{
		$('#year').val('0');
		$('#month').val('0');
		$('#other').val('0');
		$('#scale').val('0');

		for(var i = 0; i < this.semesters.length; i++)
		{
			if(this.semesters[i].id == $('#semester').val())
			{
				$('#after').val(this.semesters[i].starttime);
				$('#before').val(this.semesters[i].endtime);

				break;
			}
		}

		this.update();
	},

	////////////////////////////////////////////////////////////////////////////

	yearChanged: function()
	{
		$('#semester').val('0');
		$('#other').val('0');
		$('#scale').val('0');

		var y = $('#year').val();

		$('#after').val(y+'-01-01');
		$('#before').val(y+'-12-31');

		this.update();
	},

	////////////////////////////////////////////////////////////////////////////

	monthChanged: function()
	{
		$('#semester').val('0');
		$('#other').val('0');
		$('#scale').val('0');

		var s = $('#after').val();
		var y = s.substr(0, 4);

		$('#year').val(y);

		var m1 = new Number($('#month').val());
		var m2 = new Number(m1+1);

		var nv1 = y+'-'+FormatInteger(m1, 2)+'-01';
		if(m2 == 13)
		{
			y++;
			m2 = 1;
		}

		var nv2 = y+'-'+FormatInteger(m2, 2)+'-01';

		$('#after').val(nv1);
		$('#before').val(nv2);

		this.update();
	},

	////////////////////////////////////////////////////////////////////////////

	addOther: function(i, s, e)
	{
		this.others.push({id: i, starttime: s, endtime: e});
	},

	otherChanged: function()
	{
		$('#semester').val('0');
		$('#year').val('0');
		$('#month').val('0');
		$('#scale').val('0');

		for(var i = 0; i < this.others.length; i++)
		{
			if(this.others[i].id == $('#other').val())
			{
				$('#after').val(this.others[i].starttime);
				$('#before').val(this.others[i].endtime);

				break;
			}
		}

		this.update();
	},

	dateChanged: function()
	{
		$('#semester').val('0');
		$('#year').val('0');
		$('#month').val('0');
		$('#other').val('0');
		$('#scale').val('0');

		this.update();
	},

	pageChanged: function(a)
	{
		var link = a.attr('href');
		var res = link.match(/page=\d+/);
		if(res)
		{
			res = res[0].match(/\d+/);
			this.pagenumber = res[0];
		}
		else
			this.pagenumber = 1;

		this.update();
	},

	dum: 0
}


function FormatInteger(num, length) {
    return (num / Math.pow(10, length)).toFixed(length).substr(2);
}


