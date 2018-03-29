"use strict";

var form = document.getElementById('register');
var userError = document.getElementById('loginError');
var emailError = document.getElementById('emailError');
var passError = document.getElementById('passError');
var passErrorConfirm = document.getElementById('passConfirm');
var htmlError = document.getElementById('htmlError');


function sendRequest()
{
	removeAlert();
	var ajax = new XMLHttpRequest();
	var data = new FormData(document.forms.registration);
	var validationStatus = false;

	ajax.open('POST', 'registration/check', true);
	ajax.send(data);
	ajax.onreadystatechange = function() {
		if (this.readyState != 4)
			return;
		if (this.status == 200) {
			var text = this.responseText;
			console.log(text);
			switch (text)	{
				case 'empty':
					htmlError.classList.remove('collapse');
					htmlError.innerHTML = '<strong>Error!</strong> don\'t touch html. I see you.';
					break;				
				case 'user exist':
					userError.classList.remove('collapse');
					userError.innerHTML = '<strong>Error!</strong> The user already exists!';
					break;
				case 'email exist':
					emailError.classList.remove('collapse');
					emailError.innerHTML = '<strong>Error!</strong> The email already exists!';
					break;
				case 'short password':
					passError.classList.remove('collapse');
					passError.innerHTML = '<strong>Error!</strong> The password should be longer than 7 symbols!';
					break;
				case 'not same password':
					passErrorConfirm.classList.remove('collapse');
					passErrorConfirm.innerHTML = '<strong>Error!</strong> Password need to be the same!';
					break;
				case 'true':
					validationStatus = true;
					break;
			}		

		}
		if (validationStatus)
			setRegistrationMessage();
		return;
	}
}


function setRegistrationMessage()
{
	var ajax = new XMLHttpRequest();
	var form = new FormData(document.forms.registration);

	ajax.open('POST', 'registration/save', true);
	ajax.send(form);
	var topDiv = document.getElementById('registerBlock');
	ajax.onreadystatechange = function() {
		if (ajax.readyState != 4)
			return;
		if (ajax.status == 200) {
			var text = ajax.responseText;
			console.log(text);
			switch (text)	{
				case 'registration failed':
					console.log('registration failed');
					topDiv.classList.remove('collapse', 'alert-success');
					topDiv.classList.add('alert-danger');
					topDiv.innerHTML = '<strong>Error!</strong> Registration failed, try again later!';
					break;				
				case 'mail sending failed':
					console.log('mail sending failed');
					topDiv.classList.remove('collapse', 'alert-success');
					topDiv.classList.add('alert-danger');
					topDiv.innerHTML = '<strong>Error!</strong> Error when sending a mail!';
					break;
				case 'true':
					console.log('true');
					topDiv.classList.remove('collapse');
					topDiv.innerHTML = '<strong>Success!</strong> You have Successfully registered.'
														' Check your email to confirm your profile';
					break;
			}
			var input = document.querySelectorAll('#login, #email, #password, #passwordConfirm');
			input.forEach(function(element) {
				element.value = "";
			});
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