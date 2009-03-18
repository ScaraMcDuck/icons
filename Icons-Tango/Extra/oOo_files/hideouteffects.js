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

		//blog stuff
		$(".commentlist a[@href='http://jimmac.musichall.cz']").parents("li").addClass("jimmacComment");
});
