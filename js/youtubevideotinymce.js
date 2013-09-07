(function() {
   tinymce.create('tinymce.plugins.youtubevideo', {
      init : function(ed, url) {
         ed.addButton('incvideo', {
            title : 'Insert Video',
            image : url+'/youtubed.png',
	    cmd : 'youtubevideo'
            
         });
	 ed.addButton('recordvideo', {
            title : 'Record Video',
            image : url+'/record.png',
	    cmd : 'recordvideo'
            
         });
	 ed.addCommand('youtubevideo', function() {
                var vidurl = prompt("Youtube Video URL", "");
                var height = prompt("Height", "300");
		var suggestWidth = (4/3) * height;
		var suggestWidth = parseInt(suggestWidth);
		var width = prompt("Width", suggestWidth);
		var varray = vidurl.split('&');
		var vkey = null;
		var vlist = null;
		var vplayer = null;
		if(varray.length === 3) {
 			vkey = varray[0].split('?')[1].split('=')[1];
			vlist = varray[2].split('=')[1];
			vplayer = '<iframe width="' + width + '" height="' + height + '" src="http://www.youtube.com/embed/' + vkey +'?list=' + vlist + '" frameborder="0" allowfullscreen="true"></iframe>';
			ed.execCommand('mceInsertContent', false, vplayer);
  		} else if(varray.length === 1) {
			vkey = varray[0].split('?');
			if(vkey.length === 2) {
				vkey = vkey[1].split('=')[1];
				vplayer = '<iframe width="' + width + '" height="' + height + '" src="http://www.youtube.com/embed/' + vkey + '" frameborder="0" allowfullscreen="true"></iframe>'; 
			ed.execCommand('mceInsertContent', false, vplayer);
			} else if(vkey.length === 1) {
				vkey = vkey[0].split('youtu.be/')[1];
				if(vkey !== undefined) {
					vplayer = '<iframe width="' + width + '" height="' + height + '" src="http://www.youtube.com/embed/' + vkey + '" frameborder="0" allowfullscreen="true"></iframe>'; 
					ed.execCommand('mceInsertContent', false, vplayer);
				}
			}
			
		}
         });
	 ed.addCommand('recordvideo', function() {
                ed.windowManager.open({
                	file : url + '/recorded.html',
                	width : 619,
                	height : 496,
                	inline : 1
            		}, {
                	plugin_url : url // Plugin absolute URL
            	});

        });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Youtube",
            author : 'Gadgets Choose',
            authorurl : 'http://onmouseenter.com/',
            infourl : 'http://onmouseenter.com/',
            version : "2.0"
         };
      }
   });
   tinymce.PluginManager.add('youtubevideo', tinymce.plugins.youtubevideo);
})();