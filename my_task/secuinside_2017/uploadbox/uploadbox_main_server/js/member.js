var ckImage = false;
var imageURL ='';
var userNick ='';
var userPW = '';

function image_upload(html, $target){
	var formData = new FormData();
	formData.append("type","profile");
	formData.append("file",$('input[name="profile"]')[0].files[0]);

	$.ajax({
	    url: 'upload.php',
	    data:formData,
	    type: 'POST',
	    dataType: 'html',
	    cache: false,
	    contentType: false,
	    processData: false,
	    success:function(data){ 
	  		if(data.indexOf('error!') == -1){
	    		ckImage = true;
	    		imageURL = data;
	    		alert('upload ok');
	    	}
	    	else{
	    		alert(data);
	    	}
	    }
	});
}
$(document).ready(function(){
	$("#profileupdate").click(function(){
		if(ckImage){
			userNick = $('input[name="nick"]').val();
			userPW = $('input[name="pw"]').val();

			if(userNick == '' || userPW == '' || imageURL == ''){
				alert('check your parameters');
			}
			else{
				var formData = new FormData();
				formData.append("pw", userPW);
				formData.append("nick", userNick);
				formData.append("profile", imageURL);
				$.ajax({
				    url: '?ad=member&mi=profile',
				    data:formData,
				    type: 'POST',
				    dataType: 'html',
				    cache: false,
				    contentType: false,
				    processData: false,
				    success:function(data){ 
				  		if(data.indexOf('error!') == -1){
				    		alert('update success');
				    		location.href ='index.php';
				    	}
				    	else{
				    		alert(data.split('error!')[1].split('\n'));
				    	}
				    }
				});
			}
		}
		else{
			alert('plz upload image');
		}
	})

	$("#returnURL").val(document.referrer);
});