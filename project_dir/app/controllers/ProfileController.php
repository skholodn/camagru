<?php

class ProfileController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->model = new ProfileModel;
	}
	
  
	public function actionChange()
	{
		if (!$this->before())
		{
			header('Location: /login');
			exit;
		}
		$data['title'] = 'Profile';
		$data['user_info'] = $this->model->getUserInfo(Session::get('user_id'));      
		$this->view->renderTamplate('profile', $data);
		return true;
	}


	public function actionCheck()
	{
		$username = htmlspecialchars($_POST['username']);
		$email = htmlspecialchars($_POST['email']);
		$notify_me = !empty($_POST['notify_me']) ? 1 : 0;
		$old_password = htmlspecialchars($_POST['old_password']);
		$new_password = htmlspecialchars($_POST['new_password']);
		$passwordConfirm = htmlspecialchars($_POST['passwordConfirm']);
		$passChange = false;

		if (!$username)
		{
			echo 'empty login';
		}
		else if (!$email)
		{
			echo 'empty email';
		}
		else if (!($old_password && $new_password && $passwordConfirm) && !(!$old_password && !$new_password && !$passwordConfirm))
		{
			echo 'empty password';
		}
		else if ($this->model->findUsernameDuplicated($username))
		{
			echo 'username already exist';
		}
		else if ($this->model->findEmailDuplicated($email))
		{
			echo 'email already exist';
		}
		else if ($old_password && $this->model->checkPassword(md5(md5($old_password)), Session::get('user_id')))
		{
			echo 'wrong old password';
		}
		else if ($new_password && strlen($new_password) < 8)
		{
			echo 'password too short';
		}
		else if ($new_password != $passwordConfirm)
		{
			echo 'password doesn\'t equal';
		}
		else if ($old_password)
		{
			$hash_password = md5(md5($new_password));
			$this->model->changeWithPassword($username, $email, $notify_me, $hash_password);
			Cookie::delAdd('password');
			Cookie::setAdd('password', $hash_password);
			echo 'true';
		}
		else
		{
			$this->model->changeWithoutPassword($username, $email, $notify_me);
			echo 'true';
		}
		return true;
	}

	public function actionUpload()
	{
		if (!isset($_FILES['userfile']['name']) || $_FILES['userfile']['error'] > 0)
		{
			echo 'error';
			return true;
		}
		$defaultName = ('avatar' . mb_strrchr($_FILES['userfile']['name'], '.'));
		$filePath = 'img/'.Session::get('user_name').'/'.$defaultName;
		$dirName = 'img/' . Session::get('user_name');
		if ($this->model->setAvatar($filePath))
		{
			if (!file_exists($dirName))
				mkdir($dirName);
			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $filePath))
				echo $filePath;
			else
				echo "error";
		}
		else {
			echo 'error';
		}
		return true;
	}
  
	protected function before()
	{
		if (Session::isLoggedOnUser())
			return true;
		return false;
	}
}