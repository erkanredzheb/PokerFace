/*function process_image(input){
	show_image(input);
	var path = $('#uploaded_image')[0].src;
	make_API_call(path);
}*/

function make_API_call(path){
	$.ajax({
        url: "Emotion_API_call.php",
        type: "POST",
        data: {path: path},
        success: function (response) {
        	document.getElementById("averages_returned").innerHTML = response;
        }
    });
}

function update_image(img_url){
	document.getElementById("uploaded_image").src = img_url;
}

function get_averages(){
	img_url = document.getElementById("upload_img_url").value;
	update_image(img_url);
	make_API_call(img_url);
}

function show_image(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#uploaded_image')
                .attr('src', e.target.result)
                .width(150)
                .height(200);
        };

        reader.readAsDataURL(input.files[0]);
    }
}