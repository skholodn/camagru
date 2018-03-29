<div id="registerBlock" class="collapse alert alert-success"></div>
<h1 class="text-center">Registration</h1>
<p>Sign up this form to create new account. And start communication and making your own photos!</p>
<div class="form">
	<form method="post" name="registration" id="register" onsubmit="sendRequest();return false;">
		<div class="form-group">
			<div id="htmlError" class="collapse alert alert-danger"></div>
			<label for="login">Login:</label>
			<input id="login" class="form-control" type="text" name="username" placeholder="Enter your login" autofocus="" required>
			<div id="loginError" class="collapse alert alert-danger"></div>
		</div>
		<div class="form-group">
			<label for="email">Email address:</label>
			<input id="email" class="form-control" type="email" name="email" placeholder="Enter your email" required>
			<div id="emailError" class="collapse alert alert-danger"></div>
		</div>
		<div class="form-group">
			<label for="password">Password:</label>
			<input id="password" class="form-control" type="password" name="password" placeholder="Enter your password" required>
			<div id="passError" class="collapse alert alert-danger"></div>
		</div>
		<div class="form-group">
			<label for="passwordConfirm">Password confirmation:</label>
			<input id="passwordConfirm" class="form-control" type="password" name="passwordConfirm" placeholder="Confirm your password" required>
			<div id="passConfirm" class="collapse alert alert-danger"></div>
		</div>
			<input class="btn btn-primary" type="submit" value="Register">
	</form>
	<script src="/js/registration.js"></script>
</div>
