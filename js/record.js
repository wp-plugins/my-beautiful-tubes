//Youtube upload widget code

var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
var widget;
var player;
function onYouTubeIframeAPIReady() {
	widget = new YT.UploadWidget('widget', {
          width: 600,
          events: {
            'onUploadSuccess': onUploadSuccess,
	    'onProcessingComplete': onProcessingComplete	
          }
        });
}

function onUploadSuccess(event) {
        alert('Your video was uploaded successfully and is currently under processed. Please wait for a few minutes and please do not close the recording panel yet until you see a share link in a prompt box!');
}

function onProcessingComplete(event) {
	var url = "http://youtu.be/" + event.data.videoId;
        prompt("Process complete! You can now copy the share link from this box and close the upload panel.",  url);
}