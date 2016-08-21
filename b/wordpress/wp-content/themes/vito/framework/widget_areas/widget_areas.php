<?php
function vito_widgets_init() {
    if (function_exists('register_sidebar')) {
        register_sidebar(array(
            'name' => esc_attr__( 'Sidebar Widgets', 'vito' ),
            'id'   => 'sidebar-widgets',
            'description'   => esc_attr__( 'These are widgets for the sidebar.', 'vito' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>'
        ));
    }//End
}
add_action( 'widgets_init', 'vito_widgets_init' );
?>