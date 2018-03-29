<div id="restorePass" class="collapse alert alert-success"></div>
<p>Enter your email. And you will get the new password in your email.</p>
<div class="form">
	<form method="post" name="passReset" id="passReset" onsubmit="sendRequest();return false;">
		<div class="form-group">
			<label for="email">Email address:</label>
			<input id="email" class="form-control" type="email" name="email" placeholder="Enter your email" required>
			<div id="emailError" class="collapse alert alert-danger"></div>
		</div>
			<input class="btn btn-primary" type="submit" value="Reset password">
	</form>
	<script src="/js/restore.js"></script>
</div>