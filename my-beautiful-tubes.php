<?php
/*
Plugin Name: my beautiful tubes
Plugin URI: http://gadgets-code.com/my-beautiful-tubes-tutorial-part-1-how-to-insert-video-images-under-your-video/
Description: A plugin which allows blogger to embed youtube videos on the post and page
Version: 1.7.6
Author: Gadgets-Code.Com
Author URI: https://plus.google.com/b/100673180703646429119/
License: GPLv2
*/

/* Copyright 2012 Gadgets-Code.Com (e-mail : morning131@hotmail.com)

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
  add_meta_box('tube-url-meta',__('Enter Youtube Video Share Link','tube-plugin'),'tube_meta_box','page','side','default');
  add_action('save_post','tube_save_meta_box');

}


function tube_meta_box($post,$box) {

  $tube_url = get_post_meta($post->ID,'_tubes_url',true);
  $tube_wt = get_post_meta($post->ID,'_tubes_wt',true);
  $tube_ht = get_post_meta($post->ID,'_tubes_ht',true);
  $tube_position = get_post_meta($post->ID,'_tubes_position',true);
  $tube_rel_title = get_post_meta($post->ID,'_tubes_rel_title',true);
  $tube_rel_des = get_post_meta($post->ID,'_tubes_rel_des',true);
  $tube_rel_link = get_post_meta($post->ID,'_tubes_rel_link',true);
  $tube_videos_link= get_post_meta($post->ID,'_tubes_videos_link',true);
  $tube_sidebar_link= get_post_meta($post->ID,'_tubes_sidebar_link',true);

  echo '<p>'.__('Video URL','tube-plugin'). ': <input type="text" name="tubes_url" value="'.esc_attr($tube_url).'"/></p>
        <p>'.__('Video Width','tube-plugin'). ': <input type="text" name="tubes_wt" value="'.esc_attr($tube_wt).'"/></p>
        <p>'.__('Video Height','tube-plugin'). ': <input type="text" name="tubes_ht" value="'.esc_attr($tube_ht).'"/></p>
        <p>'.__('Video Position','tube-plugin'). ': <select name="tubes_position" id="tubes_position">
        <option value="top-left" '.(is_null($tube_position) || $tube_position=='top-left' ? 'selected="selected"' : '').'>Top Left</option>
        <option value="top-right" '.($tube_position=='top-right' ? 'selected="selected"' : '').'>Top Right</option>
        <option value="bottom-left" '.($tube_position=='bottom-left' ? 'selected="selected"' : '').'>Bottom Left</option>
        <option value="bottom-right" '.($tube_position=='bottom-right' ? 'selected="selected"' : '').'>Bottom Right</option></select></p>
        <p>'.__('Links Title','tube-plugin'). ': <input type="text" name="tubes_rel_title" value="'.esc_attr($tube_rel_title).'"/></p>
        <p>'.__('Related Links Description','tube-plugin'). ':<br/><textarea name="tubes_rel_des" rows="10" cols="30">'.esc_attr($tube_rel_des).'</textarea></p>
        <p>'.__('Related Links','tube-plugin'). ':<br/><textarea name="tubes_rel_link" rows="10" cols="30">'.esc_attr($tube_rel_link).'</textarea></p>
        <p>'.__('Enter More Video Links','tube-plugin'). ':<br/><textarea name="tubes_videos_link" rows="10" cols="30">'.esc_attr($tube_videos_link).'</textarea></p>
        <p>'.__('Sidebar Video Link','tube-plugin'). ': <input type="text" name="tubes_sidebar_link" value="'.esc_attr($tube_sidebar_link).'"/></p>';

}

function tube_save_meta_box($post_id) {

  if(isset($_POST['tubes_position'])) {

    $tubeH = trim($_POST['tubes_ht']);
    $tubeW = trim($_POST['tubes_wt']);

    update_post_meta($post_id,'_tubes_url',esc_attr($_POST['tubes_url']));
    update_post_meta($post_id,'_tubes_wt',esc_attr($tubeW));
    update_post_meta($post_id,'_tubes_ht',esc_attr($tubeH));
    update_post_meta($post_id,'_tubes_position',esc_attr($_POST['tubes_position']));
    update_post_meta($post_id,'_tubes_rel_title',esc_attr($_POST['tubes_rel_title']));
    update_post_meta($post_id,'_tubes_rel_des',esc_attr($_POST['tubes_rel_des']));
    update_post_meta($post_id,'_tubes_rel_link',esc_attr($_POST['tubes_rel_link']));
    update_post_meta($post_id,'_tubes_videos_link',esc_attr($_POST['tubes_videos_link']));
    update_post_meta($post_id,'_tubes_sidebar_link',esc_attr($_POST['tubes_sidebar_link']));

  }

}

function displays_video($content) {

   $art_id = get_the_ID();
   $video_url = get_post_meta($art_id,'_tubes_url',true);
   $video_position = get_post_meta($art_id,'_tubes_position',true);
   $vd_W = get_post_meta($art_id,'_tubes_wt',true);
   $vd_H = get_post_meta($art_id,'_tubes_ht',true);
   $tube_sel_title = get_post_meta($art_id,'_tubes_rel_title',true);
   $tube_sel_description = get_post_meta($art_id,'_tubes_rel_des',true);
   $tube_sel_link =  get_post_meta($art_id,'_tubes_rel_link',true);
   $youtube_links =  get_post_meta($art_id,'_tubes_videos_link',true);
   $sel_description = explode(",",$tube_sel_description);
   $sel_link = explode(",",$tube_sel_link);
   $youtube_share_links = explode(",",$youtube_links);
   $youtubes_imgs = array();
   $video_keys = array();
   $imgvd_W = ($vd_W)."px";

   if (is_single() || is_page() ) {


        $vidurl = preg_match("/http:\/\/youtu.be\/[-\.\w]+/",$video_url,$v_match);

        if($vidurl==1) {

         $vidtu = $v_match[0];
         $vidtube = $vidtu;
         $vidtube = str_replace("http://youtu.be/","",$vidtube);
         $addup = "";
         $addup_two="";

        if(sizeof($youtube_share_links)>0) {

          for($tbs=0;$tbs<sizeof($youtube_share_links);$tbs++) {

           $link_to_youtube = $youtube_share_links[$tbs];
           $vidurl_youtubes = preg_match("/http:\/\/youtu.be\/[-\.\w]+/",$link_to_youtube,$v_match1);

           if($vidurl_youtubes==1) {

             $vidtu1 = $v_match1[0];
             $vidtu1 = str_replace("http://youtu.be/","",$vidtu1);
             $video_keys[$tbs] = $vidtu1;
             $youtubes_imgs[$tbs] = "http://img.youtube.com/vi/$vidtu1/1.jpg";

          } else {continue;}}}

          if($video_position=='top-left') {

           $vidtubes = "<div style=\"float:left;margin-right:2px;margin-top:5px;margin-bottom:1px;\">"."<iframe width=$vd_W height=$vd_H src=\"http://www.youtube.com/embed/$vidtube\" frameborder=\"0\" allowfullscreen></iframe>";

           if($sel_description[0]!=''){
            $addup.= "<br/><form><select onchange=\"location.href=this.options[this.selectedIndex].value;\" size=\"1\" style=\"background:grey;color:white;font-size:17px;\"><option value=\"\">$tube_sel_title</option>";

                       for($selOpt=0;$selOpt<sizeof($sel_description);$selOpt++) {
                       $decsrp = $sel_description[$selOpt];
                       $declink = $sel_link[$selOpt];
                       $addup.="<option value=$declink>$decsrp</option>";
                       }
                       $addup.="</select></form>";}else{$addup.="";}

                       if($youtubes_imgs[0]!=''){
                        $addup_two.="<div style='width:$imgvd_W;'>";
                        for($show_video_images=0;$show_video_images<sizeof($youtube_share_links);$show_video_images++) {
                         $image_video_link = $youtubes_imgs[$show_video_images];
                         $vkey = $video_keys[$show_video_images];
                         $addup_two.="<img id='shv' style='float:left;' src='$image_video_link' name='$vkey' />";
                       }
                       $addup_two.="</div></div>";}else{$addup_two.="</div>";}

             return $vidtubes.$addup.$addup_two.$content;

           } elseif ($video_position=='top-right') {

           $vidtubes = "<div style=\"float:right;margin-left:2px;margin-top:5px;margin-bottom:1px;\">"."<iframe width=$vd_W height=$vd_H src=\"http://www.youtube.com/embed/$vidtube\" frameborder=\"0\" allowfullscreen></iframe>";

          if($sel_description[0]!=''){
           $addup.= "<br/><form><select onchange=\"location.href=this.options[this.selectedIndex].value;\" size=\"1\" style=\"background:grey;color:white;font-size:17px;\"><option value=\"\">$tube_sel_title</option>";

                       for($selOpt=0;$selOpt<sizeof($sel_description);$selOpt++) {
                       $decsrp = $sel_description[$selOpt];
                       $declink = $sel_link[$selOpt];
                       $addup.="<option value=$declink>$decsrp</option>";
                       }
                       $addup.="</select></form>";}else{$addup.="";}

                       if($youtubes_imgs[0]!=''){
                        $addup_two.="<div style='width:$imgvd_W;'>";
                        for($show_video_images=0;$show_video_images<sizeof($youtube_share_links);$show_video_images++) {
                         $image_video_link = $youtubes_imgs[$show_video_images];
                         $vkey = $video_keys[$show_video_images];
                         $addup_two.="<img id='shv' style='float:left;' src='$image_video_link' name='$vkey' />";
                       }
                       $addup_two.="</div></div>";}else{$addup_two.="</div>";}

             return $vidtubes.$addup.$addup_two.$content;

           } elseif ($video_position=='bottom-left') {

           $vidtubes = "<div style=\"float:left;margin-right:2px;margin-top:3px;margin-bottom:1px;\">"."<iframe width=$vd_W height=$vd_H src=\"http://www.youtube.com/embed/$vidtube\" frameborder=\"0\" allowfullscreen></iframe>";

           if($sel_description[0]!=''){
            $addup.= "<br/><form><select onchange=\"location.href=this.options[this.selectedIndex].value;\" size=\"1\" style=\"background:grey;color:white;font-size:17px;\"><option  value=\"\">$tube_sel_title</option>";

                       for($selOpt=0;$selOpt<sizeof($sel_description);$selOpt++) {
                       $decsrp = $sel_description[$selOpt];
                       $declink = $sel_link[$selOpt];
                       $addup.="<option value=$declink>$decsrp</option>";
                       }
                       $addup.="</select></form>";}else{$addup.="";}

                       if($youtubes_imgs[0]!=''){
                        $addup_two.="<div title='hey' style='width:$imgvd_W;'>";
                        for($show_video_images=0;$show_video_images<sizeof($youtube_share_links);$show_video_images++) {
                         $image_video_link = $youtubes_imgs[$show_video_images];
                         $vkey = $video_keys[$show_video_images];
                         $addup_two.="<img id='shv' style='float:left;' src='$image_video_link' name='$vkey' />";
                       }
                       $addup_two.="</div></div>";}else{$addup_two.="</div>";}

             return $content.$vidtubes.$addup.$addup_two;

           } elseif ($video_position=='bottom-right') {

           $vidtubes = "<div style=\"float:right;margin-left:2px;margin-top:3px;margin-bottom:1px;\">"."<iframe width=$vd_W height=$vd_H src=\"http://www.youtube.com/embed/$vidtube\" frameborder=\"0\" allowfullscreen></iframe>";

           if($sel_description[0]!=''){
            $addup.= "<br/><form><select onchange=\"location.href=this.options[this.selectedIndex].value;\" size=\"1\" style=\"background:grey;color:white;font-size:17px;\"><option value=\"\">$tube_sel_title</option>";

                       for($selOpt=0;$selOpt<sizeof($sel_description);$selOpt++) {
                       $decsrp = $sel_description[$selOpt];
                       $declink = $sel_link[$selOpt];
                       $addup.="<option value=$declink>$decsrp</option>";
                       }
                       $addup.="</select></form>";}else{$addup.="";}

                       if($youtubes_imgs[0]!=''){
                       $addup_two.="<div style='width:$imgvd_W;'>";
                       for($show_video_images=0;$show_video_images<sizeof($youtube_share_links);$show_video_images++) {
                         $image_video_link = $youtubes_imgs[$show_video_images];
                         $vkey = $video_keys[$show_video_images];
                         $addup_two.="<img id='shv' style='float:left;' src='$image_video_link' name='$vkey' />";
                       }
                       $addup_two.="</div></div>";}else{$addup_two.="</div>";}

              return $content.$vidtubes.$addup.$addup_two;

           } } else { return $content; }

     } else { return $content; }

}

  add_filter('the_content','displays_video');

  function my_bea_video_init() {

   register_widget('le_bea_video');

  }

  add_action('widgets_init', 'my_bea_video_init');


  class le_bea_video extends WP_Widget {

  function le_bea_video() {
   $video_ops = array('classname'=>'le_bea_video', 'description'=>'Grab to Sidebar');
   parent::WP_Widget('le-bea-video', __('Beautiful Tubes'), $video_ops);
  }

  function widget($args, $instance) {
    extract($args);
    echo $before_widget;

    if(is_single() || is_page()) {

     $arti_id = get_the_ID();
     $video_sidebar_url = get_post_meta($arti_id,'_tubes_sidebar_link',true);
     $vidurl = preg_match("/http:\/\/youtu.be\/[-\.\w]+/",$video_sidebar_url,$v_match);
      if($vidurl==1) {
        $vidtu = $v_match[0];
        $vidtu = str_replace("http://youtu.be/","",$vidtu);
        $side_video = "<div id=\"sidevideo\" style=\"float:left;margin-left:3px;\"><iframe width='250' height='200' src=\"http://www.youtube.com/embed/$vidtu\" frameborder=\"0\" allowfullscreen></iframe></div>";
        echo $side_video;
      } else {echo '';}} else {echo '';}

     echo $after_widget;
   }

   function form($instance)  {

   }


   function update($new_instance, $old_instance) {
    return $instance;
   }
  }

   add_shortcode('likeVideos','show_like_video');

   function show_like_video($attr) {

    if(isset($attr['key'])) {
       $you_like_video = $attr['key'];
     } else {
       $content = '';
     }

    if(isset($attr['title'])) {
       $you_like_title = $attr['title'];
     } else {
       $you_like_title = 'click here!';
     }

     return "<div id=\"likeit\" style=\"cursor: pointer;\">$you_like_title</div><div id=\"showLikeVideo\" style=\"display:none;\"><iframe width=\"560\" height=\"315\" src=\"http://www.youtube.com/embed/$you_like_video\" frameborder=\"0\" allowfullscreen></iframe></div>";

   }

   function loading_jq() {
    if(!is_admin()){
     wp_enqueue_script( 'jquery');
    }
   }

    add_action('init','loading_jq');

    function image_clicks() {

     echo '<script type="text/javascript">
           jQuery(document).ready(function() {

            jQuery("img#shv").mouseover(function(event) {
             jQuery(this).fadeOut(5500);
             var videosrc = jQuery(this).attr("name");
             var video_tube_url = "http://www.youtube.com/embed/"+videosrc;
             jQuery(this).parent().parent().children().attr("src",video_tube_url);
            });

           });
         </script>';
    }

    function likeVideo_click() {

       echo '<script>
              jQuery(document).ready(function() {
                 jQuery(\'#likeit\').click(function() {
                   jQuery(\'#likeit\').hide();
                   jQuery(\'#showLikeVideo\').show();
                 });
               });</script>';
    }

   add_action( 'wp_dashboard_setup', 'gadgets_dashboard_widgets' );
   function gadgets_dashboard_widgets() {
     wp_add_dashboard_widget( 'dashboard_gadgets_feed', 'Developer News', 'gadgets_dashboard_feed');
   }
   function gadgets_dashboard_feed() {
     $gadgets_rss_feed = 'http://gadgets-code.com/feed';
     //show developer RSS feed
     echo '<div class="rss-widget">';
     wp_widget_rss_output( array(
      'url' => $gadgets_rss_feed,
      'title' => 'Developer News',
      'items' => 1,
      'show_summary' => 1,
      'show_author' => 0,
      'show_date' => 1
     ) );
     echo '</div>';
   }
   add_action('wp_footer','image_clicks');
   add_action('wp_footer','likeVideo_click');
?>