(function($){
	
	$(document).ready( function(){
		function how_many_tweets(url) {
			var api_url = "http://cdn.api.twitter.com/1/urls/count.json";
			var just_url = url || document.location.href;
			$.ajax({
				url: api_url + "?callback=?&url=" + just_url,
				dataType: 'json',
				success: function(data) {
					var tweets_count = data.count;
					$("#tweets").html(tweets_count);
				}
			});
		}

		function how_many_fb_shares(url) {
		    var api_url = "http://api.facebook.com/restserver.php";
		    var just_url = url || document.location.href;
		    $.ajax({
		        url: api_url + "?method=links.getStats&format=json&urls=" + just_url,
		        dataType: 'json',
		        success: function(data) {
		        	if( data[0])
		            var shares_count = data[0].total_count;
		        	else shares_count=0;
		            $("#faces").html(shares_count);
		        }
		    });
		};

		function how_many_google_pluses(url) {
			api_key='AIzaSyB6BH1aavT9_dX8wZ4SkZD93HwDd0S2R4s';
		    var api_url = "https://clients6.google.com/rpc?key=AIzaSyB6BH1aavT9_dX8wZ4SkZD93HwDd0S2R4s";
		    var just_url = url || document.location.href;
	        var Alldata = '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":'+just_url+',"source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]'
	        console.log(Alldata);
		    var jjurl =  JSON.stringify(Alldata);
		    $.ajax({
		        cache: false,
		        type: "POST",
		        url: api_url,
		        data: jjurl,//[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":jjurl,"source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}],
		        dataType: "jsonp",
		        success: function (data) {
		        	console.log('ola ok');
		            console.log(data);
		        },
		        error: function(data){
		        	console.log('exw error');
		            console.log(data);
		        }
		    });
		    	
		
		}
		$(document ).ready(function() {
			url=$(location).attr('href');
			//url="http://www.google.com";
			how_many_tweets(url);
			how_many_fb_shares(url);
			how_many_google_pluses(url);
		});
	});
})(jQuery)
