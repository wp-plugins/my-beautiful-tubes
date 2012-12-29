<?php
add_filter('the_content','displays_video');

function displays_video($content) {

   $youtube_share_link = get_post_meta(get_the_ID(), '_tubes_url', true);
   $video_img_link =  get_post_meta(get_the_ID(), '_tubes_img_link', true);
   $fbcomment = "";
   $display_video ="";
   $display_img_video="";

   if (is_single() || is_page() ) {

       $vidurl = preg_match("/http:\/\/youtu.be\/[-\.\w]+/", $youtube_share_link, $v_match);
       $vid_img_url = preg_match("/http:\/\/youtu.be\/[-\.\w]+/", $video_img_link, $v_img_match);

       if($vidurl === 1) {

         $vidtu = $v_match[0];
         $vidtube = $vidtu;
         $vidtube = str_replace("http://youtu.be/","", $vidtube);

         $display_video = "<div class='beauty-tube-wrap'><div class='beauty-video-wrap'>"."<iframe width=\"473\" height=\"266\" src=\"http://www.youtube.com/embed/$vidtube\" frameborder=\"0\" allowfullscreen></iframe></div>";

         $fbcomment = "<div id=\"fb-root\"></div>
                       <script>(function(d, s, id) {
                         var js, fjs = d.getElementsByTagName(s)[0];
                         if (d.getElementById(id)) return;
                         js = d.createElement(s); js.id = id;
                         js.src = \"//connect.facebook.net/en_US/all.js#xfbml=1\";
                         fjs.parentNode.insertBefore(js, fjs);
                        }(document, \'script\', \'facebook-jssdk\'));</script>

                       <div class=\"fb-comments\" data-href=\"$vidtu\" data-width=\"473\" data-num-posts=\"10\" data-colorscheme=\"dark\"></div></div>";

         return $content.$display_video.$fbcomment;

        } elseif ($vid_img_url === 1){

           $img_post_id = get_the_ID();
           $post_categories = wp_get_post_categories( $img_post_id );

           $args = array(
             'numberposts' => -1,
             'offset' => 0,
             'category' => $post_categories[0],
             'orderby' => 'rand',
             'order' => 'DESC',
             'include' =>'',
             'exclude' => $img_post_id
           );

           $imgposts = get_posts( $args );
           $imagelinks = '';
           $countimg = 0;
           foreach($imgposts as $impost) {

              if($countimg == 4)
               break;
              $post_title = $impost->post_title;
              $post_linkage = get_permalink( $impost->ID );
              $video_imag =  get_post_meta($impost->ID, '_tubes_img_link', true);
              $img_linkage = preg_match("/http:\/\/youtu.be\/[-\.\w]+/", $video_imag, $imgg_match);
              if($imgg_match[0] == '') {
                continue;
              }
              $imgl = $imgg_match[0];
              $imgl = str_replace("http://youtu.be/","", $imgl);
              $youtubes_imgs = "http://img.youtube.com/vi/$imgl/1.jpg";
              $images =  "<div class='beauty-img-wrap'><img id='shv' class='beauty-image' src='$youtubes_imgs' name='$imgl'/>";
              $postlink = "<p class='beauty-pi-tag'><a href='$post_linkage'>$post_title</a></p></div>";
              $imagelinks .= $images.$postlink;
              $countimg++;

           }

           $imagelinks = "<div class='beauty-img-main-wrap'><hr class='beauty-line'/>Related Videos and Posts : <br/><hr class='beauty-line'/>" .$imagelinks. "</div>";

           $vidtub = $v_img_match[0];
           $vid_tube = $vidtub;
           $vid_tube = str_replace("http://youtu.be/","", $vid_tube);
           $display_img_video = "<div class='beauty-tube-wrapper'><div class='beauty-video-wrap'>"."<iframe id='beauty-tubes-video' width=\"473\" height=\"266\" src=\"http://www.youtube.com/embed/$vid_tube\" frameborder=\"0\" allowfullscreen></iframe></div>" .$imagelinks. "</div>";

           return $content.$display_img_video;
        }
    }

    return $content;

}
?>