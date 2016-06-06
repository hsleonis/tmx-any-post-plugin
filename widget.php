<?php
/**
 * @package: ThemeAxe
 * @author: Shahriar
 * @date: 5/13/16
 * Widgets register
 */

require_once ('inc/TmxAnyPost.php');
require_once ('inc/TmxAuthorBio.php');

add_action( 'widgets_init', function(){
    register_widget( 'ThemeAxe\TmxAnyPost' );
    register_widget( 'ThemeAxe\TmxAuthor' );
});