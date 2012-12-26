<?php
add_filter('the_content','displays_video');

function displays_video($content) {

   $youtube_share_link = get_post_meta(get_the_ID(), '_tubes_url', true);
   $fbcomment = "";
   $display_video ="";

   if (is_single() || is_page() ) {

       $vidurl = preg_match("/http:\/\/youtu.be\/[-\.\w]+/", $youtube_share_link, $v_match);

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



        }
    }
    return $content.$display_video.$fbcomment;

}
?>