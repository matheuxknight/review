
var upload_complete = false;

$(function() {
	$("#upload_field").html5_upload(
	{
		method: 'post',
		sendBoundary: window.FormData || $.browser.mozilla,
		
		url: function(number) {
			return upload_url+"&number="+number;
		},
		
		onStart: function(event, total) {
			$("#progress_report").show();
			return true;
		},
		
		setName: function(text) {
			$("#progress_report_name").html("<b>"+text+"</b>");
		},
	
		setProgress: function(val) {
			$("#progress_report_bar").css('width', Math.ceil(val*100)+"%");
		},
		
		onFinish: function(event, total)
		{
			if(upload_complete) return;
			upload_complete = true;
			
			window.location = window.location+'&complete';
		},
		
		onError: function(event, name, error) {
			alert('Error while uploading file ' + name);
		}
	});
});






