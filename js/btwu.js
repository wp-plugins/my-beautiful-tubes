jQuery(document).ready( function() {
 jQuery("img#shv").click( function(event) {         
     var videosrc = jQuery(this).attr("name");
     var video_tube_url = "http://www.youtube.com/embed/"+videosrc;
     jQuery('#beauty-tubes-video').attr("src",video_tube_url);          
 });
});


         
