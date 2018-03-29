<h1 class="text-center">Authorization</h1>
<p>Sign up this form to start communication and making your own photos!</p>
<div class="form">
	<form method="post" name="LogIn" id="LogIn" onsubmit="sendRequest();return false;">
		<div class="form-group">
			<label for="login">Login:</label>
			<input id="login" class="form-control" type="text" name="username" placeholder="Enter your login" autofocus="" required>
			<div id="loginError" class="collapse alert alert-danger"></div>
		</div>
		<div class="form-group">
			<label for="password">Password:</label>
			<input id="password" class="form-control" type="password" name="password" placeholder="Enter your password" required>
			<div id="passError" class="collapse alert alert-danger"></div>
			<div><a href="/login/restore">Forgot your password?</a></div>
		</div>
		<div class="form-group">
			<input type="checkbox" name="remember" value="true" checked> <i> Remember me!</i>
		</div>
			<input class="btn btn-primary" type="submit" value="Log In">
	</form>
	<script src="/js/login.js"></script>
</div>