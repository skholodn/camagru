<div id="addImgSuccess" class="collapse alert alert-success"></div>
<div id="upload_img" class="form-group">
	<fieldset class="text-center">
		<legend>Add image into gallery</legend>
	</fieldset>
	<form id="upload" name="upload" enctype="multipart/form-data" onsubmit="ImgLoader();return false;" method="POST">
		<input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
		<input name="userfile" type="file" class="form-control"/><br>
		<div id="addImgError" class="collapse alert alert-danger"></div>
		<input type="submit" value="Upload File" class="btn btn-primary form-control" />
	</form>
</div><br>

<section id="splash">
  <p id="errorMessage">Loading...</p>
</section>

<section id="photoApp" hidden>
	<video id="monitor" autoplay></video>
	<img class="art" src="/img/stickers/glasses.png" onmousedown="moveart(this);return false;">
	<img class="art" src="/img/stickers/zzz.png" onmousedown="moveart(this);return false;">
	<img class="art" src="/img/stickers/mustache.png" onmousedown="moveart(this);return false;">
	<img class="art" src="/img/stickers/hair.png" onmousedown="moveart(this);return false;">
  	<div id="stickers" class="container">
		<div class="row">
			<div class="col-3">
				<input type="checkbox" value="/img/stickers/glasses.png" onchange="change(0);return false">
				<img src="/img/stickers/glasses.png">
			</div>
			<div class="col-3">
				<input type="checkbox" value="/img/stickers/zzz.png" onchange="change(1);return false">
				<img src="/img/stickers/zzz.png">
			</div>
			<div class="col-3">
				<input type="checkbox" value="/img/stickers/mustache.png" onchange="change(2);return false">
				<img src="/img/stickers/mustache.png">
			</div>
			<div class="col-3">
				<input type="checkbox" value="/img/stickers/hair.png" onchange="change(3);return false">
				<img src="/img/stickers/hair.png">
			</div>
		</div>
		<div class="row">
			<button id="shutter" class="col-6 btn btn-primary">&#x1F4F7;</button>
			<button id="save" class="col-6 btn btn-warning" hidden="true">&#x1F4BE;</button>
		</div>
	</div>
	<canvas id="photo"></canvas>
</section>


<script src="/js/photo.js"></script>