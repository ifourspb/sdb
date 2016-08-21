jQuery(document).ready( function($) {
  
  if( $('input#bytehand_from').length > 0 ) {
    
    // Cut to 11 characters on blur if it contains alphanumeric characters
    $('input#bytehand_from').blur( function(e) {
      $('input#bytehand_from').val( $('input#bytehand_from').val() );
    });
    
    // Do the same on form submit
    $('form#bytehand_options_form').submit( function(e) {
      $('input#bytehand_from').val( $('input#bytehand_from').val());      
    });    
  }
  
});
