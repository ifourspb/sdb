jQuery(document).ready(function() {
    jQuery('.gallery-icon a').fancybox(
      {'overlayShow': true, 'hideOnContentClick': true, 'overlayOpacity': 0.85}
    );
    jQuery('.size-medium').parent().fancybox(
          {'overlayShow': true, 'hideOnContentClick': true, 'overlayOpacity': 0.85}
    );
	 jQuery('.size-large').parent().fancybox(
          {'overlayShow': true, 'hideOnContentClick': true, 'overlayOpacity': 0.85}
    );
    jQuery('.size-full').parent().fancybox(
          {'overlayShow': true, 'hideOnContentClick': true, 'overlayOpacity': 0.85}
              );
});
