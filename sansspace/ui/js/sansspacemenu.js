
var sansspace_arrowimages={
	down:['downarrowclass', '/images/ui/arrow-down.gif'],
	right:['rightarrowclass', '/images/ui/arrow-right.gif']};

function sansspace_buildsubmenu(menuid)
{
	$("#"+menuid).css('display', 'block');
	var $mainmenu = $("#"+menuid+">ul");

	var $headers = $mainmenu.find("ul").parent();
	$headers.each(function(i)		// all li that have children
	{
//		console.log("----------------");
//		console.log(this.innerText);
		var $curobj = $(this);

		this.istopheader = $curobj.parents("ul").length==1? true: false;
		this.isinit = false;
		this.isover = false;

		var $subul = $(this).find('ul:eq(0)');

		this._dimensions = {w:this.offsetWidth, h:this.offsetHeight,
			subulw:$subul.outerWidth(), subulh:$subul.outerHeight()};

		$subul.css({top:this.istopheader? this._dimensions.h+"px": 0});

		if(!this.istopheader)
		{
			$curobj.children("a:eq(0)").append('<img src="'+
				sansspace_arrowimages.right[1] + '" class="' +
				sansspace_arrowimages.right[0] + '" style="border:0;" />');
		}

		var thisitem = this;

		$curobj.children("a").click(function(e)
		{
			thisitem.isover = false;
			clearTimeout(thisitem.timer);

			$(thisitem).children("ul:eq(0)").fadeOut(100);
		});

		$curobj.hover(function(e)
		{
			thisitem.isover = true;
			this.timer = setTimeout(function()
			{
				var $targetul = $(thisitem).children("ul:eq(0)");
				var menuleft = thisitem.istopheader? 0: thisitem._dimensions.w;

				thisitem._offsets = {left:$(thisitem).offset().left,
					top:$(thisitem).offset().top};

				menuleft =
					(thisitem._offsets.left+menuleft +
						thisitem._dimensions.subulw > $(window).width())?
					(thisitem.istopheader?
						-thisitem._dimensions.subulw+thisitem._dimensions.w:
						-thisitem._dimensions.w):
						menuleft;

				$(thisitem).removeClass('current');
				$targetul.css({left:menuleft+"px"}).fadeIn(100);

				if(!thisitem.isinit && thisitem.id != '')	// && thisitem.id != 'admin')
				{
					thisitem.isinit = true;
					$.get("/html/listobject&id="+thisitem.id, "", function(data)
					{
						$targetul.empty();
						$targetul.append(data);
						sansspace_buildsubmenu(thisitem.id);
					});
				}
			}, 350);
		},
		function(e)
		{
			thisitem.isover = false;
			clearTimeout(thisitem.timer);

			setTimeout(function()
			{
				if(!thisitem.isover)
					$(thisitem).children("ul:eq(0)").fadeOut(100);
			}, 500);
		}) //end hover
	}) //end $headers.each()

	$mainmenu.find("ul").css({display:'none', visibility:'visible'})
}




