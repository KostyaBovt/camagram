<div class="container-camera">
	<div class="main-camera">
			<div class="video" style="position: relative;">
        <img id="video_sticker" style="position: absolute; left:150px; top:90px; width:170px;" src="">
				<video id="video" autoplay="true"></video>
				<canvas id="canvas" hidden="true"></canvas>
				<div class="output" id="output" style="display:none">
					<img id="photo">
				</div>
			</div>
			<div class="video-buttons">
        <button id="startbutton">Capture</button>
        <button id="cancelbutton" style="display:none">Cancel</button>
				<button id="postbutton" disabled>Post photo</button>
        <label for="upload-photo">Choose file to upload</label>
        <input type="file" name="photo" id="upload-photo"/>
			</div>
		<div class="images-camera">
      <?php 
        foreach ($view_data['stickers'] as $sticker) {
          echo '<div class="image-camera"><img id="' . $sticker->id . '" src="/assets/img/' . $sticker->id .'.png"></div>';
        }
      ?>
		</div>
	</div>


 	<div class="sidebar-camera">
		<div class="sidebar-image-camera"><img src="<?php echo ROOT_PATH; ?>assets/img/test.png"></div>
		<div class="sidebar-image-camera"><img src="<?php echo ROOT_PATH; ?>assets/img/test.png"></div>
		<div class="sidebar-image-camera"><img src="<?php echo ROOT_PATH; ?>assets/img/test.png"></div>
		<div class="sidebar-image-camera"><img src="<?php echo ROOT_PATH; ?>assets/img/test.png"></div>
		<div class="sidebar-image-camera"><img src="<?php echo ROOT_PATH; ?>assets/img/test.png"></div>
	</div>
</div>

<script type="text/javascript">

var currentSticker = null;

function addStickers() {
  var stickers = document.querySelectorAll(".image-camera img");
  console.log(stickers);
  for (var i = stickers.length - 1; i >= 0; i--) {
    stickers[i].addEventListener('click', function(e) {
      console.log(e.target.id, e.target.src);
      currentSticker = e.target;
      var videoImg = document.getElementById("video_sticker");
      videoImg.src = currentSticker.src; 
    });
  }
}

(function() {
  addStickers();

  // The width and height of the captured photo. We will set the
  // width to the value defined here, but the height will be
  // calculated based on the aspect ratio of the input stream.

  var width = 500;    // We will scale the photo width to this
  var height = 0;     // This will be computed based on the input stream

  // |streaming| indicates whether or not we're currently streaming
  // video from the camera. Obviously, we start at false.

  var streaming = false;

  // The various HTML elements we need to configure or control. These
  // will be set by the startup() function.

  var video = null;
  var canvas = null;
  var photo = null;
  var startbutton = null;

  function startup() {
    video = document.getElementById('video');
    canvas = document.getElementById('canvas');
    photo = document.getElementById('photo');
    startbutton = document.getElementById('startbutton');
    cancelbutton = document.getElementById('cancelbutton');
    output = document.getElementById('output');
    postbutton = document.getElementById('postbutton');

    navigator.getMedia = ( navigator.getUserMedia ||
                           navigator.webkitGetUserMedia ||
                           navigator.mozGetUserMedia ||
                           navigator.msGetUserMedia);

    navigator.getMedia(
      {
        video: true,
        audio: false
      },
      function(stream) {
        if (navigator.mozGetUserMedia) {
          video.mozSrcObject = stream;
        } else {
          var vendorURL = window.URL || window.webkitURL;
          video.src = vendorURL.createObjectURL(stream);
        }
        video.play();
      },
      function(err) {
        console.log("An error occured! " + err);
      }
    );

    video.addEventListener('canplay', function(ev){
      if (!streaming) {
        height = video.videoHeight / (video.videoWidth/width);
      
        // Firefox currently has a bug where the height can't be read from
        // the video, so we will make assumptions if this happens.
      
        if (isNaN(height)) {
          height = width / (4/3);
        }
      
        video.setAttribute('width', width);
        video.setAttribute('height', height);
        canvas.setAttribute('width', width);
        canvas.setAttribute('height', height);
        streaming = true;
      }
    }, false);

    startbutton.addEventListener('click', function(ev){
      takepicture();
      ev.preventDefault();
    }, false);

    cancelbutton.addEventListener('click', function(ev){
      startbutton.style.display='inline';
      cancelbutton.style.display='none';
      output.style.display='none';
      video.style.display='block';
      postbutton.setAttribute('disabled', 'true');
      clearphoto();     
      ev.preventDefault();
    }, false);
    
    clearphoto();
  }

  // Fill the photo with an indication that none has been
  // captured.

  function clearphoto() {
    var context = canvas.getContext('2d');
    context.fillStyle = "#AAA";
    context.fillRect(0, 0, canvas.width, canvas.height);

    var data = canvas.toDataURL('image/png');
    photo.setAttribute('src', data);
  }
  
  // Capture a photo by fetching the current contents of the video
  // and drawing it into a canvas, then converting that to a PNG
  // format data URL. By drawing it on an offscreen canvas and then
  // drawing that to the screen, we can change its size and/or apply
  // other changes before drawing it.

  function takepicture() {
    var context = canvas.getContext('2d');
    if (width && height) {
      canvas.width = width;
      canvas.height = height;
      context.drawImage(video, 0, 0, width, height);
    
      var data = canvas.toDataURL('image/png');
      photo.setAttribute('src', data);
      output.style.display='block';
      video.style.display='none';
      startbutton.style.display='none';
      cancelbutton.style.display='inline';      
      postbutton.removeAttribute('disabled');      
    } else {
      clearphoto();
    }
  }

  // Set up our event listener to run the startup process
  // once loading is complete.
  window.addEventListener('load', startup, false);
})();

document.getElementById('postbutton').addEventListener('click', function() {
	var post_image = document.getElementById('photo').src;
	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'shot', true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("image=" + post_image + "&sticker_id=" + currentSticker.id);
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
        var response = xhr.responseText;
			  alert("Photo was saved!");
		}
	};
});

</script>