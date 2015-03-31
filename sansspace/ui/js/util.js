
function isInternetExplorer()
{
	if(parseInt(navigator.appVersion)>3 && navigator.appName.indexOf("Microsoft")!=-1)
		return true;
	return false;
}

function isFirefox()
{
	if(parseInt(navigator.appVersion)>3 && navigator.appName=="Netscape")
		return true;
	return false;
}

function getMyWindowWidth()
{
	if(parseInt(navigator.appVersion) > 3)
	{
		if(navigator.appName == "Netscape")
			return window.innerWidth - 16;
		
		if(navigator.appName.indexOf("Microsoft") != -1)
			return document.body.offsetWidth - 20;
	}
}

function getMyWindowHeight()
{
	if(parseInt(navigator.appVersion) > 3)
	{
		if(navigator.appName == "Netscape")
			return window.innerHeight - 16;
		
		if(navigator.appName.indexOf("Microsoft") != -1)
			return document.documentElement.clientHeight;
	}
}

function rgb2hex(rgb)
{
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    
    function hex(x) {
        return ("0" + parseInt(x).toString(16)).slice(-2);
    }
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

function post_to_url(path, params, method)
{
    method = method || "post"; // Set method to post by default, if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}
	
function insertTextInTextarea(areaId,text)
{
    var txtarea = document.getElementById(areaId);
    var scrollPos = txtarea.scrollTop;
    var strPos = 0;
    var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ? 
        "ff" : (document.selection ? "ie" : false ) );
    if (br == "ie") { 
        txtarea.focus();
        var range = document.selection.createRange();
        range.moveStart ('character', -txtarea.value.length);
        strPos = range.text.length;
    }
    else if (br == "ff") strPos = txtarea.selectionStart;

    var front = (txtarea.value).substring(0,strPos);  
    var back = (txtarea.value).substring(strPos,txtarea.value.length); 
    txtarea.value=front+text+back;
    strPos = strPos + text.length;
    if (br == "ie") { 
        txtarea.focus();
        var range = document.selection.createRange();
        range.moveStart ('character', -txtarea.value.length);
        range.moveStart ('character', strPos);
        range.moveEnd ('character', 0);
        range.select();
    }
    else if (br == "ff") {
        txtarea.selectionStart = strPos;
        txtarea.selectionEnd = strPos;
        txtarea.focus();
    }
    txtarea.scrollTop = scrollPos;
}


