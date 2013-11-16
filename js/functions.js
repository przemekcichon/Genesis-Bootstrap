(function($) {
  "use strict";
  
  /*
    var menu = $('.navbar .navbar-nav');
    menu.dropotron({
        mode: 'slide'
    });
    */
   $(function(){
       
       $('.navbar-nav').superfish({
			delay:       1000,                            // one second delay on mouseout
			animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation
			speed:       'fast',                          // faster animation speed
			autoArrows:  false                            // disable generation of arrow mark-up
		});
                
       //Bootstrap first nav item clickable         
       $('.navbar-nav > .dropdown .sf-with-ul').click(function(){
            location.href = this.href;
        });
       
   });
   
   
    var jPM = $.jPanelMenu({
        menu: '.navbar-nav',
        trigger: '.responsive-menu-icon',
        duration: 300,
        afterOpen: function() {
            var btn = $('.site-header').find('.responsive-menu-icon');
            btn.addClass('bt-menu-open');
        },
        afterClose: function() {
            var btn = $('.site-header').find('.responsive-menu-icon');
            btn.removeClass('bt-menu-open');
        }
    });
    jPM.on();
  
})(jQuery);


