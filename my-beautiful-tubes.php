<?php
/*
Plugin Name: my beautiful tubes
Plugin URI: http://wordpress.org/plugins/my-beautiful-tubes/
Description: A plugin which allows blogger to embed youtube's' video within the post and page and get more views for that video.
Version: 1.8.6
Author: GadgetsChoose
Author URI: http://onmouseenter.com/
License: GPLv2
*/

/* Copyright 2013 Gadgets-Code.Com (e-mail : morning131@hotmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, please visit <http://www.gnu.org/licenses/>.

*/

/* Include various files need for this major plugin file */

include_once('my-beautiful-tubes-meta-box-setting.inc.php');
include_once('my-beautiful-tubes-side-widget.inc.php');
include_once('my-beautiful-tubes-displays-content.inc.php');
include_once('my-beautifultubes-register-tinymce-buttons.inc.php');

function load_beautiful_script() {
        wp_register_script( 'my-beautiful-tubes-script', plugins_url('js/btwu.js', __FILE__), array('jquery'), '1.0.1', true  );
        wp_enqueue_script( 'my-beautiful-tubes-script' );
        wp_register_style('myBeautyStyleSheet', plugins_url( 'my-beautiful-tubes-style.css' , __FILE__ ), array(), '35', 'all' );
        wp_enqueue_style( 'myBeautyStyleSheet');
}

add_action('init', 'load_beautiful_script');

function mytube_tutorial_link($links, $file) {

    if ( $file == 'my-beautiful-tubes/my-beautiful-tubes.php' ) {
        /* Insert the link at the end*/
        $links['tutorial'] = sprintf( '<a href="%s"> %s </a>', 'http://onmouseenter.com/how-to-get-more-youtube-video-view-from-facebook/', __( 'Tutorial', 'my-beautiful-tubes' ) );
    }
    return $links;

}

add_filter('plugin_action_links', 'mytube_tutorial_link', 10, 2);
?>