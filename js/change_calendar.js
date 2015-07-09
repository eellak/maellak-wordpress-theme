(function($){
	$(document).ready( function(){
	
		jQuery.fn.contentChange = function(callback){
			var elms = jQuery(this);
			elms.each(
			  function(i){
				var elm = jQuery(this);
				elm.data("lastContents", elm.html());
				window.watchContentChange = window.watchContentChange ? window.watchContentChange : [];
				window.watchContentChange.push({"element": elm, "callback": callback});
			  }
			)
			return elms;
		  }
		  setInterval(function(){
			if(window.watchContentChange){
			  for( i in window.watchContentChange){
				if(window.watchContentChange[i].element.data("lastContents") != window.watchContentChange[i].element.html()){
				  window.watchContentChange[i].callback.apply(window.watchContentChange[i].element);
				  window.watchContentChange[i].element.data("lastContents", window.watchContentChange[i].element.html())
				};
			  }
			}
		  },500);
		
		change_calendar();
		set_popup_event();
		
		$("#home_calendar").contentChange(function(){   change_calendar();  set_popup_event(); });
		
		function change_calendar(){
			$('a.changecal').click(function() {  
				if ($("#home_calendar").is(':animated')) {
					return false;
				} else {
				
					var nextprevDate = $(this).attr('data');
				
					$("#home_calendar").toggle(900);
					
					jQuery.post(
						ma_ellak_calendar_settings.ajax_url,
						{
							action : 'ma_ellak_change_calendar_action',
							date_data : nextprevDate,
							req_nonce : ma_ellak_calendar_settings.req_nonce,
						},
						function( response ) {
							$("#home_calendar").html( response);
						}
					);
					
					$("#home_calendar").toggle(900);
					return false;
				}
			
			});
		}
		
		function set_popup_event(){
			$("a[id^='popoverData']").click(function(e) {
				e.preventDefault();
			}).popover({
				placement: 'right',
				trigger: 'manual',
				html: true
			}).on("mouseenter", function () {
				var _this = this;
				$(this).popover("show");
				var data_href= $(_this).attr("data-href");
				//alert(data_href)
				var title = $(this).siblings(".popover").find('h3');
				$(title).wrapInner('<a href="'+data_href+'"></a>');

				$(this).siblings(".popover").on("mouseleave", function () {
					$(_this).popover('hide');
				});
			}).on("mouseleave", function () {
				var _this = this;
				setTimeout(function () {
					if (!$(".popover:hover").length) {
						$(_this).popover("hide")
					}
				}, 100);
			});
		}
	} );
})(jQuery)
