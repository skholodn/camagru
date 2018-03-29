"use strict";
var form = document.getElementById('LogIn');
var userError = document.getElementById('loginError');
var passError = document.getElementById('passError');


function sendRequest()
{
	removeAlert();
	var ajax = new XMLHttpRequest();
	var data = new FormData(document.forms.LogIn);
	var validationStatus = false;
	
	ajax.open('POST', 'login/check', true);
	ajax.send(data);
	// for (var [key, value] of data.entries()) { 
 //  		console.log(key, value);
	// }
	ajax.onreadystatechange = function() {
		if (this.readyState != 4)
			return;
		if (this.status == 200) {
			var text = this.responseText;
			console.log(text);
			switch (text)	{
				case 'empty':
					userError.classList.remove('collapse');
					userError.innerHTML = '<strong>Error!</strong> don\'t touch html. I see you.';
					break;				
				case 'user not found':
					userError.classList.remove('collapse');
					userError.innerHTML = '<strong>Error!</strong> The user not found!';
					break;
				case 'wrong password':
					passError.classList.remove('collapse');
					passError.innerHTML = '<strong>Error!</strong> Wrong password!';
					break;
				case 'not confirmed':
					userError.classList.remove('collapse');
					userError.innerHTML = '<strong>Error!</strong> You need to confirm your email before using profile.';
					break;
				case 'true':
					validationStatus = true;
					break;
			}		
			if (validationStatus)
				window.location.href = "/";
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