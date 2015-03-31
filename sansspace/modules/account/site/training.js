<script type="text/javascript">
$(document).ready(function(){
$('iframe#innercontent').hide();
$("#contactcontent").load("http://devlearningsite.waysidepublishing.com/site/contact/ #contactbody")
$(".confluence-embedded-image").attr('src','');

});

function setSection(clickedSection){
	var clicked = document.getElementById(clickedSection);
	var sectionName = clicked.getAttribute("section");
	var section = document.getElementById(sectionName);
	if(sectionName != "training"){
	$("#webinariframe").attr('src','')
	}
	$("#trainingdescription").slideUp("slow")
	$(".trainingselector").removeClass().addClass( "trainingselector" )
	$(clicked).addClass("trainingselectoractive")
	$('.trainingholder').hide()
	$(section).css('opacity', 0).animate({ opacity: 1 },{ queue: false, duration: 1000 }).show();
}

function setTrainingTab(tab){
	var list = document.getElementById(tab.title);
	var link = tab.getAttribute("data");
	var first = document.getElementsByName("first");
	var description = tab.getAttribute("description");
	$(".trainingtab").removeClass().addClass( "trainingtab trainingtabblur" )
	$(tab).removeClass().addClass( "trainingtab trainingtabfocus" )
	$(".topiclist").removeClass().addClass( "topiclist hiddenlist" )
	$(list).removeClass().addClass( "topiclist" )
	$(".listItem").removeClass().addClass( "listItem topiclistblur" )
	$(first).removeClass().addClass("listItem topiclistactive")
	$("#trainingcontentinner").hide().css('opacity', 0).animate({ opacity: 1 },{ queue: false, duration: 600 }).show("slide", { direction: "right" }, 300)
	$("#webinariframe").attr('src',link)
	$("#videotext").hide().html(description).delay(500).fadeIn(1000);
}

function setListItem(video){
	var description = video.getAttribute("description");
	var link = video.getAttribute("data");
	$(".listItem").removeClass().addClass( "listItem topiclistblur" )
	$(video).removeClass().addClass("listItem topiclistactive")
	$("#webinariframe").attr('src',link)
	$("#videotext").hide().html(description).delay(500).fadeIn(1000);
}	

function setCategories(){
	var categories = document.getElementsByClassName('faq-category-title');
	var categoryList = "<h2 class='listheader' align='center'>FAQ Topics</h2><hr>";
	for (var i = 0; i < categories.length; i++){
		categoryList += "<span id='" + categories[i].id + "' title='" + categories[i].title + "' class='faq-category faq-list' onclick='setQuestions(this)'>" + categories[i].title + "</span></br>";
	}	
	$('#faq-categories-show').html(categoryList);

	$(".faq-category").click(function(){
		$('#faq-categories-show').hide()
		$('#faqcategories').animate({
			height: "50px", borderWidth: "1px", borderColor: "black"},800).addClass("faqsectionhide")
		$('#faq-categories-hide').fadeIn('slow');
		});
	$("#faq-categories-hide").click(function(){
		$('#faq-categories-hide').hide()
		$("#faqcategories").animate({
			height: "100%"},800).removeClass();
		$("#faq-result").removeClass();
		$("#faq-categories-show").fadeIn('slow')
		$('#faq-choices-hide').hide()
		$("#faq-choices").animate({
			height: "601px", marginTop: "-1px", borderWidth: "1px"},800).removeClass()
		$("#faq-choices-show").fadeIn('slow');
		});
}

function hoverWidth(container){
	var count = container.getAttribute('count');
	if(count != 1){
		var width = $(container).width() + 1;
		$(container).css('width',width).attr('count',1);
	}	
}

function setQuestions(clicked){
	var title = clicked.title;
	var questions = document.getElementsByClassName(clicked.id);
	var questionList = "<hr>";
	
	if(clicked.title == 'Using Your Course'){
		$('#choice-title').html("<h2 class='questionheader' align='center'>" + clicked.title + "</h2><h3 align='center'>How do I use...</h3>");}
	else{
		$('#choice-title').html("<h2 class='questionheader' align='center'>" + clicked.title + "</h2>");}
	
	$('#faq-choices').addClass("topshadow");
	for(var i = 0; i < questions.length; i++){
		questionList += "<span class='questionSelect faq-list' data='" + questions[i].id + "' title='"  + questions[i].title + "' onclick='showResult(this)'>" + questions[i].title + "</span></br>";}
	$('#faq-choices-list').css('width','auto').attr('count',0).html(questionList);
	
	$(".questionSelect").click(function(){
	$('#faq-choices-show').hide()
	$('#faq-result').addClass("topshadow");
	$('#faq-choices').animate({
		height: "50px", marginTop: "-10px", borderWidth: "1px", borderColor: "black"},800).removeClass().addClass("faqsectionhide topshadow")	
	$('#faq-choices-hide').fadeIn('slow');	
	});
	$("#faq-choices-hide").click(function(){
	$('#faq-choices-hide').hide()
	$("#faq-result").removeClass()
	$("#faq-choices").animate({
		height: "601px", marginTop: "-1px", borderWidth: "1px"},800).removeClass().addClass("topshadow");
	$("#faq-choices-show").fadeIn('slow');
	});	
	$('#faq-choices-hide').text(title);
}
	
function showResult(item){
	var x = item.getAttribute('data');
	var answer = document.getElementById(x);
	
	loadImages(answer);
	loadLinks(answer);
	
	var temp = answer.innerHTML;
	$('#faq-result').scrollTop(0);
	$('#faq-result-question').text(answer.title);
	$('#faq-result-answer').html(temp);
}

function faqTransfer(clicker){
	var link = clicker.textContent;
	var answers = document.getElementsByClassName('faq-question');
	var x;
	
	for (var a = 0; a < answers.length; a++){
		var name = answers[a].title;
		if(name.toLowerCase() == link.toLowerCase()){
			var x = answers[a];
		}
	}	
	
	loadImages(x);
	loadLinks(x);
	
	var temp = x.innerHTML;
	$('#faq-result').scrollTop(0);
	$('#faq-result-question').text(x.title);
	$('#faq-result-answer').html(temp);
}	

function loadImages(e){
	var z = 'https://waysidepublishing.atlassian.net';
	var imgsi = e.getElementsByTagName("img");
	for(var i = 0; i < imgsi.length; i++){
		var data = imgsi[i].getAttribute('data');
		if(data != 1){
			var url = imgsi[i].getAttribute('data-image-src');
			url = z.concat(url);
			$(imgsi[i]).replaceWith("<img src='" + url + "'width='450px' data='1' />");
		}
	}
}
function loadLinks(f){
	var links = f.getElementsByTagName("a");
	
	for(var t = 0; t < links.length; t++){
		var data = links[t].getAttribute('data');
		if(data != 1){
			var ref = links[t].getAttribute('href');
			var link = links[t].textContent;
			var n = ref.indexOf('wiki');
			var m = ref.indexOf('mailto:');
			if(n > -1){
				$(links[t]).replaceWith("<a href='javascript:void(0)' onclick='faqTransfer(this)' data='1'>" + link);
			}
			else if(m > -1){
				$(links[t]).replaceWith("<a href='" + ref + "' data='1'>" + link);
			}
			else{
				$(links[t]).replaceWith("<a href='" + ref + "' target='_blank' data='1'>" + link);
			}
		}	
	}
}
</script>