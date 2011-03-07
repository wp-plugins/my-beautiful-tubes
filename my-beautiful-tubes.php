<?php
/*
Plugin Name: my beautiful tubes
Plugin URI: http://todayprofits.gadgets-code.com/2011/01/17/my-beautiful-tubes-version-1-6/
Description: A plugin which allows blogger to embed youtube video on the post and page
Version: 1.6.6
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
   $imgvd_W = ($vd_W)."px";

   if (is_single() || is_page() ) {


        $vidurl = preg_match("/(http:\/\/)\w+\.\w+\.\w+\/watch\?v\=\w+/",$video_url,$v_match);

        if($vidurl==1) {

         $vidtu = $v_match[0];
         $vidtube = $vidtu;
         $vidtube = str_replace("=","/",str_replace("watch?","",$vidtube));
         $addup = "";
         $addup_two="";

        if(sizeof($youtube_share_links)>0) {

          for($tbs=0;$tbs<sizeof($youtube_share_links);$tbs++) {

           $link_to_youtube = $youtube_share_links[$tbs];
           $vidurl_youtubes = preg_match("/(http:\/\/)\w+\.\w+\.\w+\/watch\?v\=\w+/",$link_to_youtube,$v_match1);

           if($vidurl_youtubes==1) {

             $vidtu1 = $v_match1[0];

             $vid_imgids = preg_match("/\=\w+/",$vidtu1,$v_match2);
             $video_image_id = $v_match2[0];
             $video_image_id = str_replace("=","",$video_image_id);
             $youtubes_imgs[$tbs] = "http://img.youtube.com/vi/".$video_image_id."/1.jpg";

          } else {continue;}}}

          if($video_position=='top-left') {

           $vidtubes = "<div style=\"float:left;margin-right:2px;margin-top:5px;margin-bottom:1px;\">"."<object width=$vd_W height=$vd_H><param name=\"movie\" value=$vidtube></param><param name=\"allowFullScreen\" value=\"false\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><param name=\"bgcolor\" value=\"#000000\"></param><embed src=$vidtube type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"false\" width=$vd_W height=$vd_H bgcolor=\"#000000\"></embed></object>";

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

                       $addup_two.="<img id='shv' style='float:left;' src='$image_video_link' onclick=\"change_url(this)\"/>";
                       }
                       $addup_two.="</div></div>";}else{$addup_two.="</div>";}

            return $vidtubes.$addup.$addup_two.$content;

           } elseif ($video_position=='top-right') {

           $vidtubes = "<div style=\"float:right;margin-left:2px;margin-top:5px;margin-bottom:1px;\">"."<object width=$vd_W height=$vd_H><param name=\"movie\" value=$vidtube></param><param name=\"allowFullScreen\" value=\"false\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><param name=\"bgcolor\" value=\"#000000\"></param><embed src=$vidtube type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"false\" width=$vd_W height=$vd_H bgcolor=\"#000000\"></embed></object>";

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

                       $addup_two.="<img id='shv' style='float:left;' src='$image_video_link' onclick=\"change_url(this)\"/>";
                       }
                       $addup_two.="</div></div>";}else{$addup_two.="</div>";}

            return $vidtubes.$addup.$addup_two.$content;

           } elseif ($video_position=='bottom-left') {

           $vidtubes = "<div style=\"float:left;margin-right:2px;margin-top:3px;margin-bottom:1px;\">"."<object width=$vd_W height=$vd_H><param name=\"movie\" value=$vidtube></param><param name=\"allowFullScreen\" value=\"false\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><param name=\"bgcolor\" value=\"#000000\"></param><embed src=$vidtube type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"false\" width=$vd_W height=$vd_H bgcolor=\"#000000\"></embed></object>";

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

                       $addup_two.="<img id='shv' style='float:left;' src='$image_video_link' onclick=\"change_url(this)\"/>";
                       }
                       $addup_two.="</div></div>";}else{$addup_two.="</div>";}

             return $content.$vidtubes.$addup.$addup_two;

           } elseif ($video_position=='bottom-right') {

           $vidtubes = "<div style=\"float:right;margin-left:2px;margin-top:3px;margin-bottom:1px;\">"."<object width=$vd_W height=$vd_H><param name=\"movie\" value=$vidtube></param><param name=\"allowFullScreen\" value=\"false\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><param name=\"bgcolor\" value=\"#000000\"></param><embed src=$vidtube type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"false\" width=$vd_W height=$vd_H bgcolor=\"#000000\"></embed></object>";

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

                       $addup_two.="<img id='shv' style='float:left;' src='$image_video_link' onclick=\"change_url(this)\"/>";
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
    $video_sidebar_url = str_replace("=","/",str_replace("watch?","",$video_sidebar_url));
    if($video_sidebar_url){
    $side_video= "<div style=\"float:left;\"><object width=\"200\" height=\"190\" hspace=\"1\" vspace=\"1\" align=\"l\">
              <param name=\"movie\" value=$video_sidebar_url.\"?fs=1\"></param>
              <param name=\"allowfullscreen\" value=\"false\"></param>
              <param name=\"allowscriptaccess\" value=\"always\"></param>
              <param name=\"play\" value=\"false\"></param>
              <param name=\"loop\" value=\"false\"></param>
              <param name=\"bgcolor\" value=\"#000000\"></param>
              <embed src=$video_sidebar_url.\"?fs=0\" type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\"   allowfullscreen=\"false\" width=\"200\" hspace=\"1\" vspace=\"1\" height=\"190\" play=\"false\" loop=\"false\" bgcolor=\"#000000\" align=\"l\"></embed>
              </object></div>";

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


   function twitterB() {

   $the_art_url = get_the_ID();
   $the_art_link = get_permalink($the_art_url);
   $the_art_link=urlencode($the_art_link);

   return '<a href="http://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>'.'<iframe src="http://www.facebook.com/plugins/like.php?href='.$the_art_link.'&amp;layout=standard&amp;show_faces=false&amp;width=43&amp;action=like&amp;colorscheme=light&amp;height=20" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:43px; height:20px;" allowTransparency="true"></iframe>'."<a href=\"javascript:void(window.open('http://www.myspace.com/Modules/PostTo/Pages/?u='+encodeURIComponent(document.location.toString()),'ptm','height=450,width=550').focus())\">
    <img src=\"http://cms.myspacecdn.com/cms//ShareOnMySpace/Myspace_btn_Share.png\" border=\"0\" alt=\"Share on Myspace\" />
</a>"."<script type=\"text/javascript\">
      (function() {
      var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
      s.type = 'text/javascript';
      s.async = true;
      s.src = 'http://widgets.digg.com/buttons.js';
      s1.parentNode.insertBefore(s, s1);
      })();
      </script>
      <a class=\"DiggThisButton DiggIcon\"></a>";
   }

   add_shortcode("socialButtons","twitterB");

  function youtubeshortcodes($atts,$content=null) {

   extract(shortcode_atts(array("youtubeurl"=>'',"width"=>'',"height"=>''),$atts));

  $youtube_video_url = preg_match("/http:\/\/\w+\.\w+\.\w+\/watch\?v\=(\w+)/",$youtubeurl,$tube_match);

  if($youtube_video_url==1) {

   $tube_share_link = $tube_match[1];

   $iframeV = 'http://www.youtube.com/embed/'.$tube_share_link.'?rel=0&amp;hd=1';

   return '<iframe title="YouTube video player" class="youtube-player" type="text/html" width="'.$width.'"  height="'.$height.'" src="'.$iframeV.'" frameborder="0" allowFullScreen></iframe>';

  } else {return "";}
 }
   add_shortcode("youtubeV","youtubeshortcodes");


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
           var imgsrc = jQuery(this).attr("src");
           var video_img_id_array = /http:\/\/img.youtube.com\/vi\/(\w+)\/1\.jpg/.exec(imgsrc);
           var video_img_id = video_img_id_array[1];
           var video_tube_url = "http://www.youtube.com/v/"+video_img_id+"?fs=0&amp;hl=en_US";
           jQuery(this).parent().parent().children().children().attr("value",video_tube_url);
           jQuery(this).parent().parent().children().children("embed").attr("src",video_tube_url);
           });
         });
         </script>';
   }

    add_action('wp_footer','image_clicks');

    function analytic_create_menu() {

     add_menu_page('Enter Analytics Code','Analytics','administrator',__FILE__.'_analytics','analytic_settings_page');
     add_action('admin_init','analytic_register_settings');

}

    add_action('admin_menu','analytic_create_menu');

    function analytic_register_settings() {

     register_setting('analytic-settings-group','analytic_code');

}

    function analytic_settings_page() {

?>

   <div class="wrap">
    <h2><?php _e('Analytics Setting Options Page','analytic-plugin') ?></h2>

    <form method="post" action="options.php">
    <?php settings_fields('analytic-settings-group'); ?>
    <table class="form-table">

    <tr valign="top">
     <th scope="row"><?php _e('Analytics Code :','analytic-plugin') ?></th>
     <td><textarea name="analytic_code" rows="10" cols="30"><?php echo esc_attr(get_option('analytic_code')); ?></textarea></td>
    </tr>

    </table>

     <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e('Save Changes','analytic-plugin') ?>" />
     </p>

    </form>
   </div>

<?php }

    add_action('wp_head','add_analytic_code');

    function add_analytic_code() {

      $analytic_code = get_option('analytic_code');
       if ($analytic_code){
        echo $analytic_code;} else { echo "" ;}
     }

    function analytic_deactivate(){
      delete_option("analytic_code");
    }

   register_uninstall_hook(__FILE__,'analytic_deactivate');
?>