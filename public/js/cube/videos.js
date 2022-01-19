if(typeof Cube == 'undefined'){
	Cube = {};
}

Cube.videos = {
	getVideoUrlData:function(url) {
		if(!url) return {};
		var data = {};
		var u1 = url.match(/.*youtu\.be\/(.*?)($|\?|#)/i);
		var u2 = url.match(/youtube\.com\/watch\?.*v=(.*?)($|&|#)/i);
		var u3 = url.match(/\.*vimeo.com\/(.*?)($|\?)/i);
		var u4 = url.match(/.*facebook.com\/(.*?)\/videos\/(.*?)\//i);
		
		if(u1){
			var id = u1[1];
			data = {
				ID:id,
				server: 'youtube',
				thumbnail: 'http://img.youtube.com/vi/'+id+'/hqdefault.jpg',
				embed_url: "http://www.youtube.com/embed/"+id+"?rel=0&wmode=opaque"
			};
		}else if(u2){
			var id = u2[1];
			data = {
				ID:id,
				server: 'youtube',
				thumbnail: 'http://img.youtube.com/vi/'+id+'/hqdefault.jpg',
				embed_url: "http://www.youtube.com/embed/"+id+"?rel=0&wmode=opaque"
			};
		}else if(u3){
			var d = u3[1].split("/");
			var id = d[d.length - 1];
			data = {
				ID:id,
				server: 'vimeo',
				thumbnail: null,
				embed_url: "http://player.vimeo.com/video/"+id+"?rel=0&wmode=opaque"
			};
		}
		else if(u4){
			var page_id = u4[1];
			var id = u4[2];
			data = {
				ID:id,
				server: 'vimeo',
				thumbnail: 'http://img.youtube.com/vi/'+id+'/hqdefault.jpg',
				embed_url: "https://www.facebook.com/v2.0/plugins/video.php?allowfullscreen=true&container_width=620&href=$ac%2F"+page_id+"%2Fvideos%2Fvb."+page_id+"%2F"+id+"%2F%3Ftype%3D3&locale=en_US&sdk=joey"
			};
		}
        return data;
	}
};