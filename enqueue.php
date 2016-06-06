<?php
/**
 * @package: ThemeAxe
 * @author: Shahriar
 * @date: 5/13/16
 * Plugin CSS,JS enqueue
 */

function tmx_wonder_widgets_enqueue($hook) {
    if ( 'widgets.php' != $hook ) {
        return;
    }

    /*wp_register_style( 'materialize_css', plugin_dir_url( __FILE__ ) . 'res/css/materialize.min.css', false, '1.0.0' );
    wp_enqueue_style( 'materialize_css' );*/

    wp_register_style( 'tmx_wonder_widgets_admin_css', plugin_dir_url( __FILE__ ) . 'res/css/tmx-wonder-widgets.css', false, '1.0.0' );
    wp_enqueue_style( 'tmx_wonder_widgets_admin_css' );

    wp_register_script( 'materialize_js', plugin_dir_url( __FILE__ ) . 'res/js/materialize.min.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script('jquery');
    wp_enqueue_script('materialize_js');
}
add_action( 'admin_enqueue_scripts', 'tmx_wonder_widgets_enqueue' );