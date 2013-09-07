<?php

function my_beautifultubes_TinyMCE_button() {

   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
      return;
   }

   if ( get_user_option('rich_editing') == 'true' ) {
      add_filter( 'mce_external_plugins', 'add_tube_plugin' );
      add_filter( 'mce_buttons', 'register_tube_button' );
   }
}

function register_tube_button( $buttons ) {
   array_push( $buttons, "recordvideo", "incvideo" );
   return $buttons;
}

function add_tube_plugin( $plugin_array ) {
   $plugin_array['youtubevideo'] = plugins_url('my-beautiful-tubes/js/youtubevideotinymce.js');
   return $plugin_array;
}

add_action('init', 'my_beautifultubes_TinyMCE_button');
?>