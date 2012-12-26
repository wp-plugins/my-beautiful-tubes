<?php
wp_register_sidebar_widget(
    'my_beautiful_tubes_widget',
    'Beauty Tube',
    'beautiful_tubes_widget',
    array(
        'description' => 'My Beautiful Tubes Plugin Widget'
    )
);

function beautiful_tubes_widget() {

   if( is_single() || is_page() ) {

     $video_sidebar_url = get_post_meta(get_the_ID(),'_tubes_sidebar_link',true);
     $vidurl = preg_match("/http:\/\/youtu.be\/[-\.\w]+/", $video_sidebar_url, $v_match);
      if($vidurl === 1) {

        $vidtu = $v_match[0];
        $vidtu = str_replace("http://youtu.be/","",$vidtu);
        echo "<li id='my-beautiful-tubes-side-widget' class='widget widget_beauty_tube'><div class='beautiful-tubes-side-widget'>";
        echo "<iframe width='270' height='152' src=\"http://www.youtube.com/embed/$vidtu\" frameborder=\"0\" allowfullscreen></iframe>";
        echo "</div></li>";

      }

   }
}
?>