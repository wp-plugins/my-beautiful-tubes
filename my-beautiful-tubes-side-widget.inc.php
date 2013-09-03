<?php

//register latest video sidebar widget
wp_register_sidebar_widget(
    'my_tube_post_video_widget',   // unique widget id
    'Latest Videos Widget',          // widget name
    'my_tube_post_video_widget_display',  // callback function
    array(                  // options
        'description' => 'Display Latest Videos'
    )
);

function my_tube_post_video_widget_display() {

 // only shows on single post
 if( is_single() ) {
  $args = array(
   'posts_per_page' => 6,
   'caller_get_posts' => 1,
   'post__not_in'=>get_option('sticky_posts'),
   'order'=>'DESC'
  );
  query_posts( $args );
  if ( have_posts() ) :
   echo "<h3 class=\"my_tube_currents_widgets_header\">Latest Videos</h3>";
   while ( have_posts() ) : the_post();
    if($video_url = get_post_meta(get_the_ID(), '_tubes_url',true)) {
        $vidurl = preg_match("/http:\/\/youtu.be\/[-\.\w]+/", $video_url, $v_match);
    } else if($video_url = get_post_meta(get_the_ID(), '_tubes_img_link',true)) {
        $vidurl = preg_match("/http:\/\/youtu.be\/([-\.\w]+)/", $video_url, $v_match);
    }

    if($vidurl === 1) {
     $vidurl = null;
     $videoid = explode("youtu.be/", $v_match[0]);
     $youtubes_imgs = "http://img.youtube.com/vi/$videoid[1]/1.jpg";
     $youtubelink = "http://youtu.be/$videoid[1]";
     echo "<div id='my_tube_sticky_posts_widget' class='widget my_tube_sticky_posts_widget'>";
    ?>
    <div class="my_tube_sticky_posts_img_wraps">
       <a href="<?php echo $youtubelink; ?>" target="_blank" title="open page to youtube video">
        <img src="
        <?php
          echo $youtubes_imgs;
         ?>
         "/>
       </a>
    </div>
    <div class="my_tube_sticky_posts_text_wraps">
        <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title() ?></a>
    </div>
 <?php
     echo "</div>";
    }
    endwhile;
    echo "<hr class='my_tube_widget_seperator'/>";
  endif;
  wp_reset_query();
 }
}

//register sticky video sidebar widget
wp_register_sidebar_widget(
    'my_tube_feature_video_widget',   // unique widget id
    'Feature Video Widget',          // widget name
    'my_tube_feature_video_widget_display',  // callback function
    array(                  // options
        'description' => 'Display Feature Videos'
    )
);

function my_tube_feature_video_widget_display() {

 // only shows on single post and homepage
 if( is_single() || is_home() ) {

  $args = array(
   'posts_per_page' => 6,
   'post__in' => get_option('sticky_posts'),
   'order'=>'DESC'
  );
  query_posts( $args );
  if ( have_posts() ) :
   echo "<h3 class=\"my_tube_sticky_widgets_header\">Feature Videos</h3>";
   while ( have_posts() ) : the_post();
    if($video_url = get_post_meta(get_the_ID(), '_tubes_url',true)) {
        $vidurl = preg_match("/http:\/\/youtu.be\/[-\.\w]+/", $video_url, $v_match);
    } else if($video_url = get_post_meta(get_the_ID(), '_tubes_img_link',true)) {
        $vidurl = preg_match("/http:\/\/youtu.be\/([-\.\w]+)/", $video_url, $v_match);
    }

    if($vidurl === 1) {
     $vidurl = null;
     $videoid = explode("youtu.be/", $v_match[0]);
     $youtubes_imgs = "http://img.youtube.com/vi/$videoid[1]/1.jpg";
     $youtubelink = "http://youtu.be/$videoid[1]";
     echo "<div id='my_tube_sticky_posts_widget' class='widget my_tube_sticky_posts_widget'>";
    ?>
    <div class="my_tube_sticky_posts_img_wraps">
       <a href="<?php echo $youtubelink; ?>" target="_blank" title="open page to youtube video">
        <img src="
        <?php
          echo $youtubes_imgs;
         ?>
         "/>
       </a>
    </div>
    <div class="my_tube_sticky_posts_text_wraps">
        <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title() ?></a>
    </div>
 <?php
     echo "</div>";
    }
    endwhile;
    echo "<hr class='my_tube_widget_seperator'/>";
  endif;
  wp_reset_query();
 }
}

wp_register_sidebar_widget(
    'my_beautiful_tubes_widget',
    'Related Video Widget',
    'beautiful_tubes_widget',
    array(
        'description' => 'Display Related Video'
    )
);

function beautiful_tubes_widget() {

   if( is_single() || is_page() ) {

     $video_sidebar_url = get_post_meta(get_the_ID(),'_tubes_sidebar_link',true);
     $vidurl = preg_match("/http:\/\/youtu.be\/[-\.\w]+/", $video_sidebar_url, $v_match);
      if($vidurl === 1) {

        $vidtu = $v_match[0];
        $vidtu = str_replace("http://youtu.be/","",$vidtu);
        echo "<h3 class=\"my_tube_related_widgets_header\">Related Video</h3>";
        echo "<div class='beautiful-tubes-side-widget'>";
        echo "<iframe class='related_tube' src=\"http://www.youtube.com/embed/$vidtu\" frameborder=\"0\" allowfullscreen></iframe>";
        echo "</div>";
        echo "<hr class='my_tube_widget_seperator'/>";

      }

   }
}
?>