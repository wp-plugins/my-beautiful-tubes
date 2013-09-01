(function() {
   tinymce.create('tinymce.plugins.youtubevideo', {
      init : function(ed, url) {
         ed.addButton('youtubevideo', {
            title : 'Youtube',
            image : url+'/youtubed.png',
            onclick : function() {
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
				if(vkey !== undefined)
					vplayer = '<iframe width="' + width + '" height="' + height + '" src="http://www.youtube.com/embed/' + vkey + '" frameborder="0" allowfullscreen="true"></iframe>'; 
			ed.execCommand('mceInsertContent', false, vplayer);
			}
			
		}
                
                                 
            }
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
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('youtubevideo', tinymce.plugins.youtubevideo);
})();