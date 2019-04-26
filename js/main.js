$(document).ready(function(){

	// click on image tag 
	$(".register-default-image").on("click",function(){
		$(".register-file-input").click();
	});

	// uploade choosen image
	$(".register-file-input").on('change' , function(){
	    var file = document.getElementById('register-file-input').files[0];
	    var reader  = new FileReader();
	    // it's onload event and you forgot (parameters)
	    reader.onload = function(e)  {
	        var image = document.createElement("img");
	        // the result image data
                var data = e.target.result;
                if(data.substring(0,10) != "data:image"){
                    return false;
                }
	        image.src = e.target.result;
	        $(".register-default-image").attr('src' , e.target.result);
	        //document.body.appendChild(image);
	     }
	     // you have to declare the file loading
	     reader.readAsDataURL(file);
	});
    
});