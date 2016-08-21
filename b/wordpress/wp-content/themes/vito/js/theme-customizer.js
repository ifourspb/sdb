/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {

	// Update the site title in real time...
	wp.customize( 'blogname', function( value ) {
		value.bind( function( newval ) {
			$( '.ql_logo' ).html( newval );
		} );
	} );
	
	//Update the site description in real time...
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( newval ) {
			$( '.logo_desc' ).html( newval );
		} );
	} );

	
	//Update Headings color in real time...
	wp.customize( 'headings_color', function( value ) {
		value.bind( function( newval ) {
			$('h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a').each(function(index, el) {
				$(el).style('color', newval, 'important');
			});
		} );
	} );


  wp.customize( 'background_color', function( value ) {
    value.bind( function( newval ) {
      $('body').each(function(index, el) {
        $(el).style('background-color', newval, 'important');
      });
    } );
  } );




  /*
  //Header
  */

  //Update Header color in real time...
  wp.customize( 'header_textcolor', function( value ) {
    value.bind( function( newval ) {
      $('#header, #jqueryslidemenu ul.nav > li > a').each(function(index, el) {
        $(el).style('color', newval, 'important');
      });
    } );
  } );







  /*
  //Typography
  */

  //Update Font Content color in real time...
  wp.customize( 'content_typography_color', function( value ) {
    value.bind( function( newval ) {
      $('body').style('color', newval, 'important');
    } );
  } );

  //Update Font Links color in real time...
  wp.customize( 'links_typography_color', function( value ) {
    value.bind( function( newval ) {
      $('.post a, .widget a, .page a, #footer a').each(function(index, el) {
        $(el).style('color', newval, 'important');
      });
    } );
  } );



  //Update social icons in real time...
  wp.customize( 'social_facebook', function( value ) {
    value.bind( function( newval ) {
      updateSocial('facebook', newval);
    } );
  } );
  wp.customize( 'social_twitter', function( value ) {
    value.bind( function( newval ) {
      updateSocial('twitter', newval);
    } );
  } );
  wp.customize( 'social_instagram', function( value ) {
    value.bind( function( newval ) {
      updateSocial('instagram', newval);
    } );
  } );
  wp.customize( 'social_flickr', function( value ) {
    value.bind( function( newval ) {
      updateSocial('flickr', newval);
    } );
  } );
  wp.customize( 'social_youtube', function( value ) {
    value.bind( function( newval ) {
      updateSocial('youtube', newval);
    } );
  } );
  wp.customize( 'social_vimeo-square', function( value ) {
    value.bind( function( newval ) {
      updateSocial('vimeo-square', newval);
    } );
  } );
  wp.customize( 'social_linkedin', function( value ) {
    value.bind( function( newval ) {
      updateSocial('linkedin', newval);
    } );
  } );
  wp.customize( 'social_skype', function( value ) {
    value.bind( function( newval ) {
      updateSocial('skype', newval);
    } );
  } );
  wp.customize( 'social_google-plus', function( value ) {
    value.bind( function( newval ) {
      updateSocial('google-plus', newval);
    } );
  } );
  wp.customize( 'social_tumblr', function( value ) {
    value.bind( function( newval ) {
      updateSocial('tumblr', newval);
    } );
  } );
  wp.customize( 'social_dribbble', function( value ) {
    value.bind( function( newval ) {
      updateSocial('dribbble', newval);
    } );
  } );
  wp.customize( 'social_foursquare', function( value ) {
    value.bind( function( newval ) {
      updateSocial('foursquare', newval);
    } );
  } );
  wp.customize( 'social_pinterest', function( value ) {
    value.bind( function( newval ) {
      updateSocial('pinterest', newval);
    } );
  } );
  wp.customize( 'social_rss', function( value ) {
    value.bind( function( newval ) {
      updateSocial('rss', newval);
    } );
  } );



  //Update Social icons in real time
  function updateSocial(name, link){
    if (link.length > 0 && $(".n_"+name).length == 0) {
        $(".nav_social").append('<li class="n_'+ name +'"><a href="'+ link +'" ><i class="fa fa-'+name+'"></i></a></li>')
    }else if(link.length == 0){
      $(".n_"+ name).remove();
    }else{
      $(".n_"+ name +" a").attr('href', link);
    }
  }//updateSocial




} )( jQuery );











/*
.style() function to apple "!important" in real time
*/
(function($) {    
  if ($.fn.style) {
    return;
  }

  // Escape regex chars with \
  var escape = function(text) {
    return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
  };

  // For those who need them (< IE 9), add support for CSS functions
  var isStyleFuncSupported = !!CSSStyleDeclaration.prototype.getPropertyValue;
  if (!isStyleFuncSupported) {
    CSSStyleDeclaration.prototype.getPropertyValue = function(a) {
      return this.getAttribute(a);
    };
    CSSStyleDeclaration.prototype.setProperty = function(styleName, value, priority) {
      this.setAttribute(styleName, value);
      var priority = typeof priority != 'undefined' ? priority : '';
      if (priority != '') {
        // Add priority manually
        var rule = new RegExp(escape(styleName) + '\\s*:\\s*' + escape(value) +
            '(\\s*;)?', 'gmi');
        this.cssText =
            this.cssText.replace(rule, styleName + ': ' + value + ' !' + priority + ';');
      }
    };
    CSSStyleDeclaration.prototype.removeProperty = function(a) {
      return this.removeAttribute(a);
    };
    CSSStyleDeclaration.prototype.getPropertyPriority = function(styleName) {
      var rule = new RegExp(escape(styleName) + '\\s*:\\s*[^\\s]*\\s*!important(\\s*;)?',
          'gmi');
      return rule.test(this.cssText) ? 'important' : '';
    }
  }

  // The style function
  $.fn.style = function(styleName, value, priority) {
    // DOM node
    var node = this.get(0);
    // Ensure we have a DOM node
    if (typeof node == 'undefined') {
      return this;
    }
    // CSSStyleDeclaration
    var style = this.get(0).style;
    // Getter/Setter
    if (typeof styleName != 'undefined') {
      if (typeof value != 'undefined') {
        // Set style property
        priority = typeof priority != 'undefined' ? priority : '';
        style.setProperty(styleName, value, priority);
        return this;
      } else {
        // Get style property
        return style.getPropertyValue(styleName);
      }
    } else {
      // Get CSSStyleDeclaration
      return style;
    }
  };
})(jQuery);