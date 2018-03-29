<div id="profileSuccess" class="collapse alert alert-success"></div>
<div id="ava" style="background-image: url('/<?php echo $user_info['avatar'] ? $user_info['avatar'] : 'img/site/profile.jpg'; ?>');  background-repeat: no-repeat; background-size: 100% 100%;">
    <p id="ava_text" onclick="if (document.getElementById('add_ava').classList.contains('collapse'))
    							document.getElementById('add_ava').classList.remove('collapse');
    						else
    							document.getElementById('add_ava').classList.add('collapse');
    							return false;">Change photo</p>
 </div>
  <div id="add_ava" class="collapse form-group">
        <fieldset class="text-center">
            <legend>Add avatar</legend>
        </fieldset>
        <form id="upload" name="upload" enctype="multipart/form-data" onsubmit="AvatarLoader();return false;" method="POST">
            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
            <input name="userfile" type="file" class="form-control"/><br>
            <div id="fileError" class="collapse alert alert-danger"></div>
            <input type="submit" value="Upload File" class="btn btn-primary form-control" />
        </form>
    </div><br>
 <p class="text-center">To change information, fill the input fields and click <strong>Save button</strong>.</p>
<div class="form">
	<form method="post" name="profile" id="profile" onsubmit="sendRequest();return false;">
		<div class="form-group">
			<label for="login">Login:</label>
			<input id="login" class="form-control" type="text" name="username" value="<?php echo $user_info['login']; ?>" autofocus="" required>
			<div id="loginError" class="collapse alert alert-danger"></div>
		</div>
		<div class="form-group">
			<label for="email">Email address:</label>
			<input id="email" class="form-control" type="email" name="email" value="<?php echo $user_info['email']; ?>" required>
			<div id="emailError" class="collapse alert alert-danger"></div>
		</div>
		<div class="form-group">
			<input type="checkbox" name="notify_me" value="true" <?php echo $user_info['notify_me'] == 1 ? 'checked' : ''; ?>> <i> Notify me in email, about new likes for my images!</i>
		</div>
		<div class='text-center'>
			<label class="font-weight-bold"> --- Changing password --- </label>
		</div>
		<div class="form-group">
			<label for="old_password">Old password:</label>
			<input id="old_password" class="form-control" type="password" name="old_password" placeholder="Enter your old password">
			<div id="passOldError" class="collapse alert alert-danger"></div>
		</div>
		<div class="form-group">
			<label for="new_password">New password:</label>
			<input id="new_password" class="form-control" type="password" name="new_password" placeholder="Enter your new password">
			<div id="passNewError" class="collapse alert alert-danger"></div>
		</div>
		<div class="form-group">
			<label for="passwordConfirm">New password confirmation:</label>
			<input id="passwordConfirm" class="form-control" type="password" name="passwordConfirm" placeholder="Confirm your new password">
		</div>
			<input class="btn btn-primary form-control" type="submit" value="Save">
	</form>

	<script src="/js/profile.js"></script>
</div>