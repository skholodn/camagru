
var listElm = document.querySelector('#infiniteComments');

// Add 4 items.
var nextItem = 0;

var loadMore = function() { 
	var xhr = new XMLHttpRequest();
	var url = "/gallery/getcomment";
	var formData = new FormData();
	formData.append("comment_limit", nextItem);
	formData.append("image_id", document.getElementsByClassName("commentBox")[0].getAttribute('id'));
	xhr.open("POST", url, true);
	xhr.send(formData);
	//console.log(formData);
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && xhr.status === 200) {
			var text = xhr.responseText;
			console.log(text);
			var myObj = JSON.parse(text);
			console.log(myObj);
			if (!myObj.length && !nextItem){
				listElm.innerHTML = "no comments found";
			}
			else {
				if (!myObj.length)
					return;
				for (x in myObj) {
				console.log(myObj[x]);
				var item = document.createElement('li');
				var imgDiv = document.createElement('div');
				imgDiv.classList.add('commenterImage');
				var img = document.createElement('img');
				if (myObj[x]['avatar'])
					img.setAttribute('src', '/'+myObj[x]['avatar']);
				else
					img.setAttribute('src', '/img/site/profile.jpg');
				var textBlock = document.createElement('div');
				textBlock.classList.add('commentText');
				var name = document.createElement('strong');
				name.innerText = myObj[x]['login'];
				var content = document.createElement('p');
				content.innerText = myObj[x]['text'];
				var date = document.createElement('span');
				date.classList.add('date', 'sub-text');
				date.innerText = 'on '+myObj[x]['date'];
				listElm.appendChild(item);
				item.appendChild(imgDiv);
				imgDiv.appendChild(img);
				item.appendChild(textBlock);
				textBlock.appendChild(name);
				textBlock.appendChild(content);
				textBlock.appendChild(date);
				};
			}
		}
	};
	nextItem++;
}

// Detect when scrolled to bottom.
listElm.addEventListener('scroll', function() {
	console.log("listElm.scrollTop="+listElm.scrollTop);
	console.log("listElm.clientHeight="+listElm.clientHeight);
	console.log("listElm.scrollHeight="+listElm.scrollHeight);
  if (listElm.scrollTop + listElm.clientHeight >= listElm.scrollHeight) {
	loadMore();
  }
});

// Initially load some items.
loadMore();

// setting like

function makeLike(image_id, image_owner) {
	var likeBlock = document.getElementById(image_id+'_like');
	var numberLikes = document.getElementById(image_id+'_likeNumb');

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

function addComment(image_id, image_owner)
{
	var numberComments = document.getElementById(image_id+'_commentsNumb');
	var ajax = new XMLHttpRequest();
	var data = new FormData(document.forms.add_comment);
	var url = "/gallery/comment"
	data.append("image_id", image_id);
	data.append("image_owner", image_owner);

	ajax.open("POST", url, true);
	ajax.send(data);

	ajax.onreadystatechange = function () {
		if (ajax.readyState === 4 && ajax.status === 200) {
			var text = this.responseText;
			
			if (text) {
				var commentObj = JSON.parse(text);
				console.log(commentObj);
				numberComments.innerHTML = commentObj.count;
				var item = document.createElement('li');
				var imgDiv = document.createElement('div');
				imgDiv.classList.add('commenterImage');
				var img = document.createElement('img');
				if (commentObj['avatar'])
					img.setAttribute('src', '/'+commentObj['avatar']);
				else
					img.setAttribute('src', '/img/site/profile.jpg');

				var textBlock = document.createElement('div');
				textBlock.classList.add('commentText');
				var name = document.createElement('strong');
				name.innerText = commentObj['login'];
				var content = document.createElement('p');
				content.innerText = commentObj['text'];
				var date = document.createElement('span');
				date.classList.add('date', 'sub-text');
				date.innerText = 'on '+commentObj['date'];
				listElm.insertBefore(item, listElm.firstChild);
				item.appendChild(imgDiv);
				imgDiv.appendChild(img);
				item.appendChild(textBlock);
				textBlock.appendChild(name);
				textBlock.appendChild(content);
				textBlock.appendChild(date);
				document.forms.add_comment.reset();

			}
		}
	};
}