/* hideout effects */
$(document).ready(function() {
		$.ImageBox.init(
			{
				loaderSRC: '/images/loading.gif',
				closeHTML: '<img src="/images/close.png" />'
			}
		);
		//console.log("registered lightbox");
		//menus
		$("ul.pulldownmenu div[@id*=Container]").each(function () {
			$(this).hide();
		});
		$("li[@id*=menu]").hoverIntent(function () {
			 var x=$(this).attr("id") + "Container";
			 $("div#" + x).slideDown(100);
			 //console.log("div#" + x);
		}, function () {
			 var x=$(this).attr("id") + "Container";
			 $("div#" + x).fadeOut();
		});
		$("#sidebar-architems").hide();
		$("#logarchive").toggle(function() {
			$("#sidebar-architems").slideDown(1000);
			$(this).addClass("rollup");
		}, function () {
			$("#sidebar-architems").slideUp(100);
			$(this).removeClass("rollup");
		});

		//utterly ridiculous way to get my del.icio.us links as pinknet doesn't do PHP5
		$("#menu1 a").attr("href", "http://del.icio.us/jimmac").text("Delicious");
		$("#menu1Content ul.forie-pulldownmenu").empty();
		$.ajax({
			type:	"GET",
			url:	"/inc/delicious.php",
			dataType:	"xml",
			success: function(rss) {
				$("item:lt(6)",rss).each(function(i) {
					var title = $(this).children("title").text();
					var link = $(this).children("link").text();
					var desc = $(this).children("description").text();
					var entry = "<li>";
					entry += "<a href=\"" + link + "\" title=\"";
					entry += desc + "\">" + title + "</a>";
					entry += "</li>\n";
					$("#menu1Content ul.forie-pulldownmenu").append(entry);
				});
			}
		});

    //get the latest tweets from http://twitter.com/statuses/user_timeline/14097648.rss
    $('#tweet').append("<h2><a href=\"http://www.twitter.com/jimmac\">Tweetroll</a></h2><ul></ul>\n");
    $.ajax({
			type:	"GET",
			url:	"/inc/twitter.php",
			dataType:	"xml",
			success: function(rss) {
				$("item:lt(3)",rss).each(function(i) {
					var title = $(this).children("title").text().substring(8);
          if (title.length>70) {
            title = title.substring(0,67) + '&hellip;';
          }
					var link = $(this).children("link").text();
					var desc = $(this).children("description").text();
					entry = "<li><a href=\"" + link + "\" title=\"";
					entry += desc + "\">" + title + "</a></li>\n";
          $('#tweet>ul').append(entry);
				});
			}
		});


		//blog stuff
		$(".commentlist a[@href='http://jimmac.musichall.cz']").parents("li").addClass("jimmacComment");

    $('a').colorHover(500,'#204a87','#fcaf3e');  //bind hover to all links
    $('.pulldownmenu a, #quickmenu a, #buttonavi a').unbind(); //except these

});

$.fn.colorHover = function (animtime,fromColor,toColor) { //link hovers color

  $(this).hover(function () {
    return $(this).css('color',fromColor).stop().animate({'color': toColor},animtime);
  }, function () {
    return $(this).stop().animate({'color': fromColor},animtime);
  });
}
