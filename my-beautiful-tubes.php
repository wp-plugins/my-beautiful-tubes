<?php
/*
Plugin Name: my beautiful tubes
Plugin URI: http://todayprofits.gadgets-code.com/2010/12/24/my-beautiful-tubes/
Description: A plugin which allows blogger to embed youtube video on the post
Version: 1.2
Author: Gadgets-Code.Com
Author URI: http://todayprofits.gadgets-code.com
*/


/* Copyright 2010 Gadgets-Code.Com (e-mail : morning131@hotmail.com)

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


add_action('admin_init','my_beautiful_tubes_meta_box_init');

function my_beautiful_tubes_meta_box_init() {

  add_meta_box('tube-url-meta',__('Enter Youtube Video Share Link','tube-plugin'),'tube_meta_box','post','side','default');

  add_action('save_post','tube_save_meta_box');

}


function tube_meta_box($post,$box) {


  $tube_url = get_post_meta($post->ID,'_tubes_url',true);
  $tube_wt = get_post_meta($post->ID,'_tubes_wt',true);
  $tube_ht = get_post_meta($post->ID,'_tubes_ht',true);
  $tube_position = get_post_meta($post->ID,'_tubes_position',true);

  echo '<p>'.__('Video URL','tube-plugin'). ': <input type="text" name="tubes_url" value="'.esc_attr($tube_url).'"/></p>
        <p>'.__('Video Width','tube-plugin'). ': <input type="text" name="tubes_wt" value="'.esc_attr($tube_wt).'"/></p>
        <p>'.__('Video Height','tube-plugin'). ': <input type="text" name="tubes_ht" value="'.esc_attr($tube_ht).'"/></p>
        <p>'.__('Video Position','tube-plugin'). ': <select name="tubes_position" id="tubes_position">
        <option value="top-left" '.(is_null($tube_position) || $tube_position=='top-left' ? 'selected="selected"' : '').'>Top Left</option>
        <option value="top-right" '.($tube_position=='top-right' ? 'selected="selected"' : '').'>Top Right</option>
        <option value="bottom-left" '.($tube_position=='bottom-left' ? 'selected="selected"' : '').'>Bottom Left</option>
       <option value="bottom-right" '.($tube_position=='bottom-right' ? 'selected="selected"' : '').'>Bottom Right</option></select></p>';

}

function tube_save_meta_box($post_id) {

  if(isset($_POST['tubes_position'])) {

    $tubeH = trim($_POST['tubes_ht']);
    $tubeW = trim($_POST['tubes_wt']);

    update_post_meta($post_id,'_tubes_url',esc_attr($_POST['tubes_url']));
    update_post_meta($post_id,'_tubes_wt',esc_attr($tubeW));
    update_post_meta($post_id,'_tubes_ht',esc_attr($tubeH));
    update_post_meta($post_id,'_tubes_position',esc_attr($_POST['tubes_position']));

  }

}

function displays_video($content) {

   $art_id = get_the_ID();
   $video_url = get_post_meta($art_id,'_tubes_url',true);
   $video_position = get_post_meta($art_id,'_tubes_position',true);
   $vd_W = get_post_meta($art_id,'_tubes_wt',true);
   $vd_H = get_post_meta($art_id,'_tubes_ht',true);

   if (is_single() || is_home()) {


        $vidurl = preg_match("/(http:\/\/)\w+\.\w+\.\w+\/watch\?v\=\w+/",$video_url,$v_match);

        if($vidurl==1) {

         $vidtu = $v_match[0];
         $vidtube = $vidtu;
         $vidtube = str_replace("=","/",str_replace("watch?","",$vidtube));
         $tweet_vid = "Watch this video at $vidtu or visit the article site on ";

          if($video_position=='top-left') {

           $vidtubes = "<div style=\"float:left;margin-right:6px;margin-top:7px;margin-bottom:2px;\">"."<object width=$vd_W height=$vd_H><param name=\"movie\" value=$vidtube></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=$vidtube type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=$vd_W height=$vd_H></embed></object>".
                       "<br/><script type=\"text/javascript\" src=\"http://platform.twitter.com/widgets.js\"></script>
                       <a href=\"http://twitter.com/share\"  class=\"twitter-share-button\"
                       data-text=\"$tweet_vid\"
                       data-count=\"none\">Tweet</a></div>";
           return $vidtubes.$content;

           } elseif ($video_position=='top-right') {

           $vidtubes = "<div style=\"float:right;margin-left:6px;margin-top:7px;margin-bottom:2px;\">"."<object width=$vd_W height=$vd_H><param name=\"movie\" value=$vidtube></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=$vidtube type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=$vd_W height=$vd_H></embed></object>".
                       "<br/><script type=\"text/javascript\" src=\"http://platform.twitter.com/widgets.js\"></script>
                        <a href=\"http://twitter.com/share\"  class=\"twitter-share-button\"
                        data-text=\"$tweet_vid\"
                        data-count=\"none\">Tweet</a></div>";
           return $vidtubes.$content;

           } elseif ($video_position=='bottom-left') {

           $vidtubes = "<div style=\"float:left;margin-right:6px;margin-top:3px;margin-bottom:2px;\">"."<object width=$vd_W height=$vd_H><param name=\"movie\" value=$vidtube></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=$vidtube type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=$vd_W height=$vd_H></embed></object>".
                       "<br/><script type=\"text/javascript\" src=\"http://platform.twitter.com/widgets.js\"></script>
                        <a href=\"http://twitter.com/share\"  class=\"twitter-share-button\"
                        data-text=\"$tweet_vid\"
                        data-count=\"none\">Tweet</a></div>";
           return $content.$vidtubes;

           } elseif ($video_position=='bottom-right') {

           $vidtubes = "<div style=\"float:right;margin-left:6px;margin-top:3px;margin-bottom:2px;\">"."<object width=$vd_W height=$vd_H><param name=\"movie\" value=$vidtube></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=$vidtube type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=$vd_W height=$vd_H></embed></object>".
                       "<br/><script type=\"text/javascript\" src=\"http://platform.twitter.com/widgets.js\"></script>
                       <a href=\"http://twitter.com/share\"  class=\"twitter-share-button\"
                       data-text=\"$tweet_vid\"
                       data-count=\"none\">Tweet</a></div>";
           return $content.$vidtubes;

           } } else { return $content; }

     } else { return $content; }

}

  add_filter('the_content','displays_video');

  function my_beautiful_tubes_deactivate(){
     $theseblog = get_bloginfo('url');
     wp_mail("Passionandlove3@hotmail.com","my beautiful tubes deactivated","$theseblog has deactivated your plugin.");
    }

  function my_beautiful_tubes_activate(){
     $theseblog = get_bloginfo('url');
     wp_mail("Passionandlove3@hotmail.com","my beautiful tubes activated","$theseblog has activated your plugin.");
    }

    register_deactivation_hook(__FILE__,'my_beautiful_tubes_deactivate');
    register_activation_hook(__FILE__,'my_beautiful_tubes_activate');

?>