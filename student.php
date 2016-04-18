<!DOCTYPE html>
<html>
<head>
	<title>student</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="js/audiodisplay.js"></script>
	<script src="js/recorderjs/recorder.js"></script>
	<script src="js/main.js"></script>
	
	<style>
	html { overflow: hidden; }
	body { 
		font: 14pt Arial, sans-serif; 
		background: lightgrey;
		display: flex;
		flex-direction: column;
		height: 100vh;
		width: 100%;
		margin: 0 0;
	}
	canvas { 
		display: inline-block; 
		background: #202020; 
		width: 95%;
		height: 170px;
		box-shadow: 0px 0px 10px blue;
	}
	#controls {
		display: flex;
		flex-direction: row;
		align-items: center;
		justify-content: space-around;
		height: 20%;
		width: 100%;
	}
	#record { height: 15vh; }
	#record.recording { 
		background: red;
		background: -webkit-radial-gradient(center, ellipse cover, #ff0000 0%,lightgrey 75%,lightgrey 100%,#7db9e8 100%); 
		background: -moz-radial-gradient(center, ellipse cover, #ff0000 0%,lightgrey 75%,lightgrey 100%,#7db9e8 100%); 
		background: radial-gradient(center, ellipse cover, #ff0000 0%,lightgrey 75%,lightgrey 100%,#7db9e8 100%); 
	}
	#save, #save img { height: 10vh; }
	#save { opacity: 0.25;}
	#save[download] { opacity: 1;}
	#viz {
		height: 80%;
		width: 100%;
		display: flex;
		flex-direction: column;
		justify-content: space-around;
		align-items: center;
	}
	@media (orientation: landscape) {
		body { flex-direction: row;}
		#controls { flex-direction: column; height: 100%; width: 10%;}
		#viz { height: 100%; width: 90%;}
	}

	</style>
</head>

<body>

	<div class="container">
  <div class="jumbotron">
    <h1>Audio Recognition</h1>
    <p>Click the button below and start recording</p> 
  </div>
  <div class="row">
    <div class="col-sm-4">
      <h3>Audio files:</h3>

	<?php
	$dir    = 'audio/';
	$files = scandir($dir, 1);

	#print_r($files);
	?>

    <select id="clips" multiple="multiple" size="10" style="width:300px;" !important onchange="getAudioClip()">
    	<?php
    	$count = count($files);
    	foreach ($files as $i => $value) {
    		if ($count-- <= 2) {
        		break;
    		}
		   echo "<option value=\"$files[$i]\"";
		   echo ">$files[$i]</option>" ;
		}		
    	?>
    	
		
	</select>
	<button id="delete-button">Delete</button>
	<button id="compare-button" style="display:none;">asd</button>
    </div>
    <div class="col-sm-4">
      <div id="viz">
		
		<canvas id="wavedisplay2" width="1024" height="500"></canvas>
	  </div>
		<img id="record-stop" src="img/record-button.png" onclick="changeImage()" height="120" width="120">
      <img id="record-stop" src="img/play-button.png" onclick="playClip()" height="120" width="120">

    </div>
    <div class="col-sm-4">
    	<div id="viz">
		<canvas id="analyser" width="1024" height="500"></canvas>
		<canvas id="wavedisplay" width="1024" height="500"></canvas>
		</div>
    </div>
  </div>
</div>

<script type="text/javascript">
	function playClip() {
		var source = audioContext.createBufferSource();
		source.buffer = dec;
		source.connect(audioContext.destination);
		source.start(0);
	}
</script>

<script>
	function changeImage() {
    var image = document.getElementById('record-stop');
    var compare = document.getElementById('compare-button');
    if (image.src.match("record")) {
        image.src = "img/stop-button.png";
        audioRecorder.clear();
    	audioRecorder.record();
    } else {
        image.src = "img/record-button.png";
        audioRecorder.stop();
        recordAudio( saveAsTemp );
        setTimeout(function(){ compare.click(); }, 3000);
        

    }
    
}
</script>

<script type="text/javascript">
	var loadedAudioClip;
	function getAudioClip() {
		var x = document.getElementById("clips").value;
		loadedAudioClip = 'audio/' + x;
	    var request = new XMLHttpRequest();
		request.open('GET', 'audio/' + x, true);
		request.responseType = 'arraybuffer';
		request.onload = function() {
	    	var audioData = request.response;
			openFile(audioData);
			}
		request.send();
	}
</script>
	
<script type="text/javascript">
	//var loadedAudioClip;
	function loadAudioClip(data) {
		var canvas = document.getElementById( "wavedisplay2" );
		drawBuffer( canvas.width, canvas.height, canvas.getContext('2d'), data );
		//loadedAudioClip = data;
	}
</script>

<script type="text/javascript">

</script>
<script src="js/mfcc.js"></script>
</body>

</html>
