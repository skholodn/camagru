"use strict";

var uploadForm = document.getElementById('upload');
var addImgError = document.getElementById('addImgError');
var addImgSuccess = document.getElementById('addImgSuccess');
var avaDiv = document.getElementById('ava');

function ImgLoader()
{
	removeAlert();
	var ajax = new XMLHttpRequest();
	var data = new FormData(document.forms.upload);

	ajax.open('POST', 'photo/upload', true);
	ajax.send(data);


	ajax.onreadystatechange = function() {
		if (this.readyState != 4)
			return;
		if (this.status == 200) {
			var text = this.responseText;
			console.log(text);
			switch (text)	{
				case 'error':
					addImgError.classList.remove('collapse');
					addImgError.innerHTML = '<strong>Error!</strong> You failed file uploading.';
					break;
				default:
					addImgSuccess.classList.remove('collapse');
					addImgSuccess.innerHTML = '<strong>Congrats!</strong> Yor uploaded image to gallery successfully.';
					break;
			}		
		}

		return;
	}
}

function removeAlert() {
	var alert = document.querySelectorAll(".alert");
	alert.forEach(function(element) {
		if (!element.classList.contains('collapse')){
			element.classList.add('collapse');
		}
	});
}

// CAMERA USE

function change(element) {
	var arts = document.getElementsByClassName('art');
	arts[element].style.display = arts[element].style.display === 'none' || !arts[element].style.display ? 'block' : 'none';
}

function moveart(elem) {
	document.onmousedown = function () {return false};
	elem.style.cursor = 'move';
	document.onmousemove = function (e) {
		var x = event.pageX;
		var y = event.pageY;
		var top = elem.offsetTop;
		var left = elem.offsetLeft;

		var rect = document.getElementById('monitor').getBoundingClientRect();
		console.log(rect.top, rect.right, rect.bottom, rect.left);
		
		top = y - rect.top;
		left = x - rect.right;
		document.onmousemove = function (e) {
			x = e.pageX;
			y = e.pageY;
			top = y - rect.top;
			left = x - rect.right;

			if (y > rect.top && y < rect.bottom - elem.offsetHeight)
				elem.style.top = y + 'px';
			if (x > rect.left && x < rect.right - elem.offsetHeight)
				elem.style.left = x + 'px';
			return false;
		};
	};
	document.onkeydown = function(e) {
		e = e || window.event;
		if (e.keyCode === 187 && elem.clientHeight < document.getElementById('monitor').clientHeight - 340){
			elem.style.height = elem.clientHeight + 5 + 'px';
			elem.style.width = 'auto';
		}
		if (e.keyCode === 189 && elem.clientHeight > 7){
			elem.style.height = elem.clientHeight - 5 + 'px';
			elem.style.width = 'auto';
		}
		return true;
	};
	document.onmouseup = function (e) {
		elem.style.cursor = 'auto';
		document.onmousedown = function () {};
		document.onmousemove = function () {};
		return false;
	};
}

window.onload = async () => {
	const video = document.getElementById('monitor');
	const canvas = document.getElementById('photo');
	const shutter = document.getElementById('shutter');
	const save = document.getElementById('save');

	try {
		video.srcObject = await navigator.mediaDevices.getUserMedia({video: true});

		await new Promise((resolve) => video.onloadedmetadata = resolve);
		canvas.width = video.videoWidth;
		canvas.height = video.videoHeight;
		
		document.getElementById('splash').hidden = true;
		document.getElementById('photoApp').hidden = false;
		var element =  document.getElementById('photoApp');
		var cs = getComputedStyle(element);
		var paddingX = parseFloat(cs.paddingLeft) + parseFloat(cs.paddingRight);
		var borderX = parseFloat(cs.borderLeftWidth) + parseFloat(cs.borderRightWidth);

		// Element width and height minus padding and border
		var elementWidth = element.offsetWidth - paddingX - borderX;
		var coef = elementWidth / canvas.width;
		// console.log("download", coef);
		shutter.onclick = function () {
			// getting all images
			var stickers = []
			var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')
			for (var i = 0; i < checkboxes.length; i++) {
				stickers.push(checkboxes[i].value);
			}
			document.getElementById('save').hidden = false;
			canvas.getContext('2d').drawImage(video, 0, 0);
			var png = document.getElementsByClassName('art');
			for (var i = 0; i < stickers.length; i++) {
				console.log(stickers[i]);
				var pic = new Image();
				pic.src = stickers[i];
				for (var a = 0; a < png.length; a++) {
				if (png[a].src == pic.src) {
					var rectPng = png[a];
					pic.width = rectPng.width;
					pic.width = rectPng.width;
					var rectVideo = document.getElementById('monitor').getBoundingClientRect();
					var rectPhoto = png[a].getBoundingClientRect();
					canvas.getContext('2d').drawImage(rectPng, (rectPhoto.left - rectVideo.left)/coef, (rectPhoto.top - rectVideo.top)/coef, rectPng.width/coef, rectPng.height/coef);
				}
			}
			}
		};
		save.onclick = function() {
			var img = canvas.toDataURL();
			var xhr = new XMLHttpRequest();
			var url = "/photo/save";
			var formData = new FormData();
			formData.append("img", img);
			xhr.open("POST", url, true);
			xhr.send(formData);
			// console.log(formData);
			xhr.onreadystatechange = function () {
				if (xhr.readyState === 4 && xhr.status === 200) {
					var text = xhr.responseText;
					console.log(text);
					if (text == 'error'){
						addImgError.classList.remove('collapse');
						addImgError.innerHTML = '<strong>Error!</strong> You failed to save photo from webcam.';
					}
					else {
						addImgSuccess.classList.remove('collapse');
						addImgSuccess.innerHTML = '<strong>Congrats!</strong> Yor saved image to gallery successfully.';
					}
				}
			};
		} 
	} catch (err) {
		console.error(err);
	}
};

