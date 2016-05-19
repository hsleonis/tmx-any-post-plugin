<?php
/*
Plugin Name: ThemeAxe Any Post Widget
Plugin URI: http://themeaxe.com/
Description: This plugin will help you to use any cusstom post or pages as widget.
Version: 1.1.1
Author: Md. Hasan Shahriar
Author URI: http://github.com/hsleonis
License: GPLv2 or later
Text Domain: themeaxe
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2016 ThemeAxe.
*/

if ( ! function_exists('tmx_pdf') ) {

// Register Custom Post Type
    function tmx_pdf() {

        $labels = array(
            'name'                  => _x( 'PDFs', 'Post Type General Name', 'themeaxe' ),
            'singular_name'         => _x( 'PDF', 'Post Type Singular Name', 'themeaxe' ),
            'menu_name'             => __( 'PDFs', 'themeaxe' ),
            'name_admin_bar'        => __( 'PDF', 'themeaxe' ),
            'archives'              => __( 'PDF Archives', 'themeaxe' ),
            'parent_item_colon'     => __( 'Parent PDF:', 'themeaxe' ),
            'all_items'             => __( 'All PDF', 'themeaxe' ),
            'add_new_item'          => __( 'Add New PDF', 'themeaxe' ),
            'add_new'               => __( 'Add New', 'themeaxe' ),
            'new_item'              => __( 'New PDF', 'themeaxe' ),
            'edit_item'             => __( 'Edit PDF', 'themeaxe' ),
            'update_item'           => __( 'Update PDF', 'themeaxe' ),
            'view_item'             => __( 'View PDF', 'themeaxe' ),
            'search_items'          => __( 'Search PDF', 'themeaxe' ),
            'not_found'             => __( 'Not found', 'themeaxe' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'themeaxe' ),
            'featured_image'        => __( 'Featured Image', 'themeaxe' ),
            'set_featured_image'    => __( 'Set featured image', 'themeaxe' ),
            'remove_featured_image' => __( 'Remove featured image', 'themeaxe' ),
            'use_featured_image'    => __( 'Use as featured image', 'themeaxe' ),
            'insert_into_item'      => __( 'Insert in PDF description', 'themeaxe' ),
            'uploaded_to_this_item' => __( 'Uploaded to this PDF description', 'themeaxe' ),
            'items_list'            => __( 'PDF list', 'themeaxe' ),
            'items_list_navigation' => __( 'PDF list navigation', 'themeaxe' ),
            'filter_items_list'     => __( 'Filter PDF list', 'themeaxe' ),
        );
        $args = array(
            'label'                 => __( 'PDF', 'themeaxe' ),
            'description'           => __( 'PDF Description', 'themeaxe' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', ),
            'taxonomies'            => array( 'category', 'post_tag' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
        );
        register_post_type( 'pdf', $args );

    }
    add_action( 'init', 'tmx_pdf', 0 );

}

require_once ('inc/TmxAnyPost.php');

add_action( 'widgets_init', function(){
    register_widget( 'ThemeAxe\TmxAnyPost' );
});