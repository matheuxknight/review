//
// CourseAddUsers
//

var CourseAddUsers =
{
	count: 0,
	courseid: 0,
	options: '',
	
	init: function(courseid, options)
	{
		this.courseid = courseid;
		this.options = options;
		
		this.count = $('#enrollcount').val();

		$('#logon_new').autocomplete(
		{
			source: '/autocomplete/userlogon&id='+this.courseid,
			select: $.proxy(this.select, this),
			change: $.proxy(this.change, this)
		});

		$('#name_new').autocomplete(
		{
			source: '/autocomplete/username&id='+this.courseid,
			select: $.proxy(this.select, this),
			change: $.proxy(this.change, this)
		});
	},
	
	select: function(event, ui)
	{
		if(!ui.item) return;

		this.addreg(ui.item.id, ui.item.logon, ui.item.name, ui.item.email, 
			$('#roleid_new').val());
		
		this.reset();
		return false;
	},
	
	change: function(event, ui)
	{
		if($('#logon_new').val() == '' || $('#name_new').val() == '') return;
		
		this.addnew($('#logon_new').val(), $('#name_new').val(), 
			$('#email_new').val(), $('#roleid_new').val());
		
		this.reset();
	},
	
	addreg: function(userid, logon, name, email, roleid)
	{
		var buffer;
		buffer += "<tr>";
		buffer += "<input name='userid_"+this.count+"' type=hidden value='"+userid+"' />";
		buffer += "<td><input name='enroll_"+this.count+"' type=checkbox checked /></td>";
		buffer += "<td>"+logon+"</td>";
		buffer += "<td>"+name+"</td>";
		buffer += "<td>"+email+"</td>";
		buffer += "<td><select class='sans-combobox' name='roleid_"+this.count+"' id='roleid_"+this.count+"'>"+this.options+"</select></td>";
		buffer += "</tr>";

		this.addshow(buffer, roleid);
	},
	
	addnew: function(logon, name, email, roleid)
	{
		var buffer;
		buffer += "<tr>";
		buffer += "<input name='userid_"+this.count+"' type=hidden value='0' />";
		buffer += "<td><input name='enroll_"+this.count+"' type=checkbox checked /></td>";
		buffer += "<td><input class='sans-input' name='logon_"+this.count+"' type=text value='"+logon+"' /></td>";
		buffer += "<td><input class='sans-input' name='name_"+this.count+"' type=text value='"+name+"' size='30' /></td>";
		buffer += "<td><input class='sans-input' name='email_"+this.count+"' type=text value='"+email+"' size='30' /></td>";
		buffer += "<td><select class='sans-combobox' name='roleid_"+this.count+"' id='roleid_"+this.count+"'>"+this.options+"</select></td>";
		buffer += "</tr>";

		this.addshow(buffer, roleid);
	},
	
	addshow: function(buffer, roleid)
	{
		$('#entry_new').before(buffer);
		$('#roleid_'+this.count).val(roleid);

		this.count++;
		$('#enrollcount').val(this.count);
	},
	
	reset: function()
	{
		$('#logon_new').val('');
		$('#name_new').val('');
		$('#email_new').val('');
	},
	
	
	dummy: 0
};


