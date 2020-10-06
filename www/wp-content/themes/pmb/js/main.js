(function($){
    $(document).ready(function(){
		$("#menu-navigation").superfish({
											delay:       100,								// 0.1 second delay on mouseout 
											animation:   {opacity:'show',height:'show'},	// fade-in and slide-down animation 
											dropShadows: false								// disable drop shadows 
										});
	});
	
	//Contact page message handling
	function showContactPageMessages(){
		var errMsg = $("#fscf_form_error1");
		if (0<errMsg.length)
			$("#fscf-custom-error").css('display', 'block');
	}
	showContactPageMessages();
	
})(jQuery);

//Home page carousel
(function($){
	var covers, buttons, carousel = $("#book-cover-carousel"),
		timerKey, interval = 15000, longInterval = 30000;
	//Don't bother initializing anything if the carousel doesn't exist
	if (carousel.length){
		
		function changeCover(direction, isManual){
			
			//Cancel the timer in case this is a manual cover change
			clearTimeout(timerKey);
			
			var nextIndex, currIndex = $("li.current", covers).index();
			nextIndex = currIndex + (direction / Math.abs(direction));
			
			if (!isManual) {
				if (nextIndex >= $("li", covers).length)
					nextIndex = 0;
				else if (nextIndex < 0)
					nextIndex = $("li", covers).length - 1;
			} else {
				nextIndex = direction;
			}
			$($("a.carousel-link", carousel).removeClass("current")[nextIndex]).addClass("current");
			$("li:nth-child("+(currIndex+1)+")", covers).removeClass("current").fadeOut();
			$("li:nth-child("+(nextIndex+1)+")", covers).addClass("current").fadeIn();
			
			//Reset the timer to automatically swap out the carousel
			timerKey = setTimeout(function(){ changeCover(1, false);}, (isManual ? longInterval : interval));
		}
		
		function initCarousel(){
			covers = $("ul", carousel);
			buttons = $("#book-cover-carousel-controls", carousel);
			$("a.carousel-link", carousel).on("click.cover-carousel", function(evt) {
																				if (!$(this).hasClass("current")){
																					changeCover($(this).index(), true);
																				}
																				evt.preventDefault(); 
																			});
			
			//Kick off the timer to automatically swap out the carousel
			timerKey = setTimeout(function(){ changeCover(1, false); }, interval);
		}
		
		$(document).ready(function(){
			initCarousel();
		});
	}
})(jQuery);
