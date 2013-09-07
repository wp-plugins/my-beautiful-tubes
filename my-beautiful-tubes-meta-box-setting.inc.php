<?php

add_action('admin_init','my_beautiful_tubes_meta_box_init');
add_action('admin_init','my_beautiful_tubes_second_meta_box_init');
add_action('wp_head', 'my_beauty_tube_share_buttons_loaded');

function my_beautiful_tubes_meta_box_init() {
  add_meta_box('tube-url-meta',__('Social Box','tube-plugin'),'tube_meta_box','post','side','default');
  add_meta_box('tube-url-meta',__('Social Box','tube-plugin'),'tube_meta_box','page','side','default');
  add_action('save_post','tube_save_meta_box');
}

//include social buttons code in video upload area
function my_beauty_tube_share_buttons_loaded() {
?>
    <script>
        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <script type="text/javascript">
        (function() {
             var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
             li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';
             var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
        })();
    </script>

    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<?php
}

function my_beautiful_tubes_second_meta_box_init() {
  add_meta_box('tubes-url-meta',__('Image Box','tube-plugin'),'tubes_meta_box','post','side','default');
}

function tubes_meta_box($post,$box) {

  $tube_img_link = get_post_meta($post->ID,'_tubes_img_link',true);
  wp_nonce_field( 'my_beautiful_tubes_meta_box_nonce', 'beautiful_tubes_meta_box_nonce' );

  echo '<p>'.__('Content ','tube-plugin'). ' : <input type="text" name="tubes_img_link" value="'.esc_attr($tube_img_link).'"/></p>';

}

function tube_meta_box($post,$box) {

  $tube_url = get_post_meta($post->ID,'_tubes_url',true);
  $tube_sidebar_link= get_post_meta($post->ID,'_tubes_sidebar_link',true);
  wp_nonce_field( 'my_beautiful_tubes_meta_box_nonce', 'beautiful_tubes_meta_box_nonce' );

  echo '<p>'.__('Content ','tube-plugin'). ' : <input type="text" name="tubes_url" value="'.esc_attr($tube_url).'"/></p>
        <p>'.__('Sidebar ','tube-plugin'). ' : <input type="text" name="tubes_sidebar_link" value="'.esc_attr($tube_sidebar_link).'"/></p>
        <p><a href="http://onmouseenter.com/how-to-get-more-youtube-video-view-from-facebook/" target="_blank">Help?</a></p>';
}

function tube_save_meta_box($post_id) {

    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
     return;

    if( !isset( $_POST['beautiful_tubes_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['beautiful_tubes_meta_box_nonce'], 'my_beautiful_tubes_meta_box_nonce' ) )
     return;

    if ( 'page' == $_POST['post_type'] ) {
      if ( !current_user_can( 'edit_page', $post_id ) )
        return;
    }
    else {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
    }

    if( isset( $_POST['tubes_url'] ) && $_POST['tubes_url']!=='' ) {
     update_post_meta( $post_id, '_tubes_url', esc_attr( $_POST['tubes_url'] ) );
    } else {
     delete_post_meta($post_id, '_tubes_url');
    }
    if( isset( $_POST['tubes_img_link'] ) && $_POST['tubes_img_link']!=='' ) {
     update_post_meta( $post_id, '_tubes_img_link', esc_attr( $_POST['tubes_img_link'] ) );
    } else {
     delete_post_meta($post_id, '_tubes_img_link');
    }
    if( isset( $_POST['tubes_sidebar_link'] ) && $_POST['tubes_sidebar_link']!=='' ) {
     update_post_meta( $post_id, '_tubes_sidebar_link', esc_attr( $_POST['tubes_sidebar_link'] ) );
    } else {
     delete_post_meta($post_id, '_tubes_sidebar_link');
    }

}
?>