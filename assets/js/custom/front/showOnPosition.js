/**
 * This function takes an array of options. 
 * 
 * When the trigger elem is visible (on the page) the first stays hidden.
 * When the trigger element leaves the page, the first elem shows again.
 * 
 * The class option is the class to toggle. This is not required. The default is 'show'
 * 
 * customWindowHeight allows you to remove height from the window.
 * This can be used to make up for fixed headers.
 * Integers and Dom elements can be passed to this.
 * 
 * The DOM should be loaded with the first element with an opacity of 0.
 * When the second elem disappears, the first element has a class of "show" added
 * 
 * i.e. $('.image').showOnPosition($('.header'));
 **/ 

(function ( $ ) {

    $.fn.showOnPosition = function( options ){

        var defaults = {
            triggerElem         : '',
            class               : 'show',
            customWindowHeight  : 0,
        }    
        
        var settings = $.extend({}, defaults, options);        
        
        if ( settings.triggerElem ){
            
            /**
             * Check to see if we have a custom window height.
             * We also need to check if the user has used a dom element
             * instead of an int.
             **/
            
            if( settings.customWindowHeight ) {

                //Returns true if not a number
                if( isNaN( settings.customWindowHeight ) ){
                                        
                    if ( isjQueryElement( settings.customWindowHeight ) ){

                        settings.customWindowHeight = settings.customWindowHeight.height();
                        
                    }
                    
                }
                
            }
            
            console.log( settings.customWindowHeight );
            
            var secondaryCount = settings.triggerElem.length;

            if( settings.triggerElem.length && secondaryCount ){

                if( settings.triggerElem.is(':visible') ){

                    var primaryEl       = this,
                        windowHeight    = window.innerHeight; 
                    
                    $(window).scroll(function() {

                        if( secondaryCount < 2 ){

                            singleElem();

                        } else {

                            manyElem();

                        }

                    });

                }

            }
            
        }
        
        
        function singleElem(){
            
            var visible = true;
            
            var secElemHeight   = settings.triggerElem.height() - settings.customWindowHeight,
                secElemPosition = settings.triggerElem.offset().top - $(window).scrollTop() + secElemHeight;
                                    
            if( secElemPosition > 0 || windowHeight < secElemPosition ){  
                primaryEl.removeClass(settings.class);
            } else {
                primaryEl.addClass(settings.class);
            }
                        
        }
        
        
        function manyElem(){
            
            var visible = true;
            
            settings.triggerElem.each(function() {
                
                var secElemHeight   = $(this).height() - settings.customWindowHeight,
                    secElemPosition = $(this).offset().top - $(window).scrollTop() + secElemHeight; 
                
                if( secElemPosition < 0 || windowHeight < secElemPosition || secElemPosition < 0 && windowHeight < secElemPosition ){
                    //Visible already set to true
                } else {
                    visible = false;
                }

            });
            
            //Trigger is still visible
            if ( visible ){
                primaryEl.removeClass(settings.class);
            } else {
                primaryEl.addClass(settings.class);
            }
            
        }

    };
    
}( jQuery ));