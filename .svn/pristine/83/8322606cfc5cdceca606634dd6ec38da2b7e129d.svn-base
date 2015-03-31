//
// CourseTeacher
//

var SansspaceCourseTeacher =
{
	summarylink:	"/teacherreport/summaryresults",
	loglink:		"/teacherreport/logresults",
	chartlink:		"/teacherreport/chartresults",

	currentlink: "",
	extraparams: "",

	id: 0,
	pagenumber: 1,

	semesterafter: "",
	semesterbefore: "",

	initsummary: function()
	{
		this.currentlink = this.summarylink;
		this.update();
	},

	initlog: function()
	{
		this.currentlink = this.loglink;
		this.update();
	},

	initchart: function()
	{
		this.currentlink = this.chartlink;
		this.update();
	},

	init: function(id, semesterafter, semesterbefore)
	{
		this.id = id;

		this.semesterafter = semesterafter;
		this.semesterbefore = semesterbefore;

		$('#buttonsemester').button().click($.proxy(this.semesterChanged, this));
		$('#buttonaddstudent').button();

		$('#month').change($.proxy(this.monthChanged, this));
		$('#other').change($.proxy(this.otherChanged, this));

		$('#after').change($.proxy(this.dateChanged, this));
		$('#before').change($.proxy(this.dateChanged, this));

	//	this.update();
	},

	update: function()
	{
		$('#loading').show();
		$('#statresults').hide();

		var link = this.currentlink;

		link += "?id=" + this.id;
		link += "&after=" + $('#after').val();
		link += "&before=" + $('#before').val();
		link += "&scale=" + $('#scale').val();
		link += "&group=" + $('#group').val();
		link += "&type=" + $('#type').val();
		link += "&files=" + $('#searchfiles').val();
		link += "&page=" + this.pagenumber;

		$.get(link, "", $.proxy(this.receive, this));
	},

	receive: function(data)
	{
		$('#loading').hide();

		$('#statresults').show();
		$("#statresults").html(data);
	},

	/////////////////////////////////////////////////////////////////////

	semesterChanged: function()
	{
		$('#after').val(this.semesterafter);
		$('#before').val(this.semesterbefore);

		$('#month').val('0');
		$('#other').val('0');
		$('#searchfiles').val('');

		this.update();
	},

	monthChanged: function()
	{
		var after = new Date();
		var before = new Date();

		after.setMonth($('#month').val()-1, 1);
		before.setMonth($('#month').val(), 1);

		$('#after').val(after.format("yyyy-mm-dd"));
		$('#before').val(before.format("yyyy-mm-dd"));

		$('#other').val('0');
		this.update();
	},

	otherChanged: function()
	{
		var after = new Date();
		var before = new Date();

		before.setDate(before.getDate() + 1);
		switch($('#other').val())
		{
		case '1':
			after.setDate(after.getDate() - 0);
			break;
		case '2':
			after.setDate(after.getDate() - 1);
			break;
		case '3':
			after.setDate(after.getDate() - 6);
			break;
		case '4':
			after.setDate(after.getDate() - 13);
			break;
		case '5':
			after.setDate(after.getDate() - 29);
			break;
		}

		$('#after').val(after.format("yyyy-mm-dd"));
		$('#before').val(before.format("yyyy-mm-dd"));

		$('#month').val('0');
		this.update();
	},

	dateChanged: function()
	{
		$('#month').val('0');
		$('#other').val('0');

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
};

