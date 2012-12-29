<?php

 if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')){
   exit();
 }

 $allposts = get_posts('numberposts=-1&post_type=post&post_status=any');

 foreach( $allposts as $postinfo) {
    delete_post_meta($postinfo->ID, '_tubes_url');
    delete_post_meta($postinfo->ID, '_tubes_wt');
    delete_post_meta($postinfo->ID, '_tubes_ht');
    delete_post_meta($postinfo->ID, '_tubes_position');
    delete_post_meta($postinfo->ID, '_tubes_rel_title');
    delete_post_meta($postinfo->ID, '_tubes_rel_des');
    delete_post_meta($postinfo->ID, '_tubes_rel_link');
    delete_post_meta($postinfo->ID, '_tubes_videos_link');
    delete_post_meta($postinfo->ID, '_tubes_sidebar_link');
    delete_post_meta($postinfo->ID, '_tubes_img_link');
 }

 $allpages = get_pages();

 foreach( $allpages as $pageinfo) {
    delete_post_meta($pageinfo->ID, '_tubes_url');
    delete_post_meta($pageinfo->ID, '_tubes_wt');
    delete_post_meta($pageinfo->ID, '_tubes_ht');
    delete_post_meta($pageinfo->ID, '_tubes_position');
    delete_post_meta($pageinfo->ID, '_tubes_rel_title');
    delete_post_meta($pageinfo->ID, '_tubes_rel_des');
    delete_post_meta($pageinfo->ID, '_tubes_rel_link');
    delete_post_meta($pageinfo->ID, '_tubes_videos_link');
    delete_post_meta($pageinfo->ID, '_tubes_sidebar_link');
 }
?>