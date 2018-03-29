"use strict";

var uploadForm = document.getElementById('upload');
var fileError = document.getElementById('fileError');
var profileSuccess = document.getElementById('profileSuccess');
var avaDiv = document.getElementById('ava');

function AvatarLoader()
{
	removeAlert();
	var ajax = new XMLHttpRequest();
	var data = new FormData(document.forms.upload);

	ajax.open('POST', 'profile/upload', true);
	ajax.send(data);


	ajax.onreadystatechange = function() {
		if (this.readyState != 4)
			return;
		if (this.status == 200) {
			var text = this.responseText;
			console.log(text);
			switch (text)	{
				case 'error':
					fileError.classList.remove('collapse');
					fileError.innerHTML = '<strong>Error!</strong> You failed file uploading.';
					break;
				default:
					avaDiv.style.backgroundImage = "url("+text+")";
					profileSuccess.classList.remove('collapse');
					profileSuccess.innerHTML = '<strong>Congrats!</strong> Yor change your avatar successfully.';
					break;
			}		
		}

		return;
	}
}

var form = document.getElementById('profile');
var userError = document.getElementById('loginError');
var emailError = document.getElementById('emailError');
var passOldError = document.getElementById('passOldError');
var passNewError = document.getElementById('passNewError');

function sendRequest(login, email, confirm)
{
	removeAlert();
	var ajax = new XMLHttpRequest();
	var data = new FormData(document.forms.profile);

	ajax.open('POST', 'profile/check', true);
	ajax.send(data);

	ajax.onreadystatechange = function() {
		if (this.readyState != 4)
			return;
		if (this.status == 200) {
			var text = this.responseText;
			console.log(text);
			switch (text)	{
				case 'empty login':
					userError.classList.remove('collapse');
					userError.innerHTML = '<strong>Error!</strong> don\'t touch html. I see you.';
					break;
				case 'empty email':
					emailError.classList.remove('collapse');
					emailError.innerHTML = '<strong>Error!</strong> don\'t touch html. I see you.';
					break;
				case 'empty password':
					passOldError.classList.remove('collapse');
					passOldError.innerHTML = '<strong>Error!</strong> To change password, you need to fill all password fields.';
					break;											
				case 'username already exist':
					userError.classList.remove('collapse');
					userError.innerHTML = '<strong>Error!</strong> This username already exist, try new one!';
					break;
				case 'email already exist':
					emailError.classList.remove('collapse');
					emailError.innerHTML = '<strong>Error!</strong> This email already exist, try new one!';
					break;
				case 'wrong old password':
					passOldError.classList.remove('collapse');
					passOldError.innerHTML = '<strong>Error!</strong> Wrong old password!';
					break;
				case 'password too short':
					passNewError.classList.remove('collapse');
					passNewError.innerHTML = '<strong>Error!</strong> The password should be longer than 7 symbols!';
					break;
				case 'password doesn\'t equal':
					passNewError.classList.remove('collapse');
					passNewError.innerHTML = '<strong>Error!</strong> The password should be equal!';
					break;
				case 'true':
					profileSuccess.classList.remove('collapse');
					profileSuccess.innerHTML = '<strong>Congrats!</strong> Yor change your profile successfully.';
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