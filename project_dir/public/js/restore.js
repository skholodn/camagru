"use strict";
var form = document.getElementById('passReset');
var emailError = document.getElementById('emailError');
var restorePass = document.getElementById('restorePass');

function sendRequest()
{
	removeAlert();
	var ajax = new XMLHttpRequest();
	var data = new FormData(document.forms.passReset);

	ajax.open('POST', 'checkpass', true);
	ajax.send(data);
	ajax.onreadystatechange = function() {
		if (this.readyState != 4)
			return;
		if (this.status == 200) {
			var text = this.responseText;
			console.log(text);
			switch (text)	{
				case 'empty':
					emailError.classList.remove('collapse');
					emailError.innerHTML = '<strong>Error!</strong> don\'t touch html. I see you.';
					break;				
				case 'wrong email':
					emailError.classList.remove('collapse');
					emailError.innerHTML = '<strong>Error!</strong> Wrong email!';
					break;
				case 'true':
					restorePass.classList.remove('collapse');
					restorePass.innerHTML = '<strong>Success!</strong> Check your email for new password!';
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