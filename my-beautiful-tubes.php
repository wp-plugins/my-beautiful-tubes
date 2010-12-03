<?php
/*
Plugin Name: my beautiful tubes 
Plugin URI: http://gadgets-code.com
Description: A plugin which allows blogger to embed youtube video on the post
Version: 1.0
Author: Gadgets-Code.Com
Author URI: http://gadgets-code.com
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

  add_meta_box('tube-url-meta',__('Enter the Youtube Video Share Link','tube-plugin'),'tube_meta_box','post','side','default');
  
  add_action('save_post','tube_save_meta_box');

}


function tube_meta_box($post,$box) {


  $tube_url = get_post_meta($post->ID,'_tubes_url',true);
  $tube_position = get_post_meta($post->ID,'_tubes_position',true); 

  echo '<p>'.__('Tube URL','tube-plugin'). ': <input type="text" name="tubes_url" value="'.esc_attr($tube_url).'"/></p>
   <p>'.__('Video Position','tube-plugin'). ': <select name="tubes_position" id="tubes_position">
     <option value="top-left" '.(is_null($tube_position) || $tube_position=='top-left' ? 'selected="selected"' : '').'>Top Left</option>
     <option value="top-right" '.($tube_position=='top-right' ? 'selected="selected"' : '').'>Top Right</option>
     <option value="bottom-left" '.($tube_position=='bottom-left' ? 'selected="selected"' : '').'>Bottom Left</option>
     <option value="bottom-right" '.($tube_position=='bottom-right' ? 'selected="selected"' : '').'>Bottom Right</option></select></p>';

}

function tube_save_meta_box($post_id) {

  if(isset($_POST['tubes_position'])) {

    update_post_meta($post_id,'_tubes_position',esc_attr($_POST['tubes_position']));
    update_post_meta($post_id,'_tubes_url',esc_attr($_POST['tubes_url']));
  }

}

function displays_video($content) {

$post_id = get_the_ID();
$video_url = get_post_meta($post_id,'_tubes_url',true);
$video_position = get_post_meta($post_id,'_tubes_position',true);

   if (is_single() || is_home()) {


       $vidurl = preg_match("/(http:\/\/)\w+\.\w+\.\w+\/watch\?v\=\w+/",$video_url,$v_match);
 
        if($vidurl==1) {
             
         $vidtube = $v_match[0];
  
         $vidtube = str_replace("=","/",str_replace("watch?","",$vidtube)); 

          if($video_position=='top-left') {

           $vidtubes = "<div style=\"float:left;margin-right:6px;margin-top:7px;margin-bottom:2px;\">"."<object width=\"300\" height=\"300\"><param name=\"movie\" value=$vidtube></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=$vidtube type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"300\" height=\"300\"></embed></object>"."</div>";
           return $vidtubes.$content;
     
           } elseif ($video_position=='top-right') {

           $vidtubes = "<div style=\"float:right;margin-left:6px;margin-top:7px;margin-bottom:2px;\">"."<object width=\"300\" height=\"300\"><param name=\"movie\" value=$vidtube></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=$vidtube type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"300\" height=\"300\"></embed></object>"."</div>";
           return $vidtubes.$content;
       
           } elseif ($video_position=='bottom-left') {

           $vidtubes = "<div style=\"float:left;margin-right:6px;margin-top:3px;margin-bottom:2px;\">"."<object width=\"300\" height=\"300\"><param name=\"movie\" value=$vidtube></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=$vidtube type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"300\" height=\"300\"></embed></object>"."</div>";
           return $content.$vidtubes;

           } elseif ($video_position=='bottom-right') {

           $vidtubes = "<div style=\"float:right;margin-left:6px;margin-top:3px;margin-bottom:2px;\">"."<object width=\"300\" height=\"300\"><param name=\"movie\" value=$vidtube></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=$vidtube type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"300\" height=\"300\"></embed></object>"."</div>";
           return $content.$vidtubes;
 
           } } else { return $content; }
     
     } else { return $content; }
     
} 

  add_filter('the_content','displays_video');
 
?>