"use strict";


function makeLike(image_id, image_owner) {
	var likeBlock = document.getElementById(image_id);
	var numberLikes = document.getElementById(image_id+'_numb');

	var xhr = new XMLHttpRequest();
	var url = "/gallery/like";
	var formData = new FormData();
	formData.append("image_id", image_id);
	formData.append("image_owner", image_owner);
		
	xhr.open("POST", url, true);
	xhr.send(formData);
	//console.log(data);
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && xhr.status === 200) {
			var text = this.responseText;
			console.log(text);
			if (!text)
				return;
			var myObj = JSON.parse(text);
			console.log(myObj);
			switch (myObj.status)	{
				case 'like set':
					likeBlock.classList.remove('far');
					likeBlock.classList.add('fas');
					numberLikes.innerHTML = myObj.count;
					break;
				case 'like remove':
					likeBlock.classList.remove('fas');
					likeBlock.classList.add('far');
					numberLikes.innerHTML = myObj.count;
					break;
			}
		}
	};
}

function setUserFilter(login_filter){
		var ajax = new XMLHttpRequest();
		var url = "/gallery/filter";
		var formData = new FormData();
		formData.append("login_filter", login_filter);

		ajax.open("POST", url, true);
		ajax.send(formData);

		ajax.onreadystatechange = function () {
		if (ajax.readyState === 4 && ajax.status === 200) {
			console.log(this.responseText);
			window.location.href = "/gallery/1";
		}

	};
}

function deleteImg(imageId, imagePath)
{
	var ajax = new XMLHttpRequest();
		var url = "/gallery/delete";
		var formData = new FormData();
		formData.append("imageId", imageId);
		formData.append("imagePath", imagePath);
		ajax.open("POST", url, true);
		ajax.send(formData);
		ajax.onreadystatechange = function () {
		if (ajax.readyState === 4 && ajax.status === 200) {
			console.log(this.responseText);
			window.location.href = "/gallery/1";
		}
	};
}