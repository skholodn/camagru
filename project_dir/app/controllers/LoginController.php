<?php

class LoginController extends Controller
{
	protected $db;

	public function __construct()
	{
		parent::__construct();
		$this->model = new LoginModel();
	}

	public function actionEnter()
	{
		if ($this->before())
		{
			header('Location: /');
			exit;
		}
		$data['title'] = 'Log In';
		$this->view->renderTamplate('login', $data);
		return true;
	}

	public function actionRestore()
	{
		$data['title'] = 'Password change';
		$this->view->renderTamplate('restore', $data);
		return true;
	}

	public function actionCheck()
	{
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
		if (!empty($_POST['remember']))
			$remember = $_POST['remember'];
		$user = $this->model->getUser($username);
		if (!$username || !$password) {
			echo 'empty';
		}
		elseif (!$user) {
			echo 'user not found';
		}
		elseif ($user['password'] != md5(md5($password))) {
			echo 'wrong password';
		}
		elseif ($user['confirm'] != 1)
		{
			echo 'not confirmed';
		}
		else {
			Session::start();
			Session::setAdd('user_id', $user['id']);
			Session::setAdd('user_name', $username);
			if (!empty($remember))
			{
				Cookie::setAdd("login", $username);
				Cookie::setAdd("password", $user['password']);
			}
			echo 'true';
		}
		return true;
	}

	public function actionCheckpass()
	{
		$email = htmlspecialchars($_POST['email']);
		if (!$email) {
			echo 'empty';
		}
		elseif ($this->model->changePass($email)) {
			echo 'wrong email';
		}
		else {
			$this->sendPassChangeMail($email);
			echo 'true';
		}
		return true;
	}

	public function actionLogout()
	{
		Session::unsetUser();
		Cookie::delAdd('login');
		Cookie::delAdd('password');
		session_destroy();
		header('Location: /login');
		return true;
	}

	private function sendPassChangeMail($email) {
		$header = "From: no-reply@camagru.ua";
		$subject = "Resetting password - Camagru.Inc";
		$message = "Dear friend, here is yours new password:\n";
		$message .= "12345678\n";
		$message .= "\nP.S. You can change it in the profile.\n";
		return mail($email, $subject, $message, $header);
	}
	
	protected function before()
	{
		if (Cookie::get('login'))
		{
			$login_c = Cookie::get('login');
			$user = $this->model->getUserPassLogin($login_c);
			if ($user['login'] == Cookie::get('login') && $user['password'] == Cookie::get('password'))
			{
				Session::setAdd('user_name', Cookie::get('login'));
				Session::setAdd('user_id', $user['id']);
			}
		}
		if (Session::isLoggedOnUser())
			return true;
		return false;
	}
}