<?php

class RegistrationController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->model = new RegistrationModel();
	}

	public function actionRegister()
	{
		$data['title'] = 'Registration form';
		$this->view->renderTamplate('registration', $data);
		return true;
	}

	public function actionCheck() {
		$username = htmlspecialchars($_POST['username']);
		$email = htmlspecialchars($_POST['email']);
		$password = htmlspecialchars($_POST['password']);
		$passwordConfirm = htmlspecialchars($_POST['passwordConfirm']);

		$userResult = $this->model->searchUser(htmlspecialchars($_POST['username']));
		$emailResult = $this->model->searchEmail(htmlspecialchars($_POST['email']));
		if (!$username || !$email || !$passwordConfirm || !$password || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo 'empty';
		}
		else if ($password != $passwordConfirm) {
			echo 'not same password';
		}
		else if ($userResult) {
			echo "user exist";
		}
		else if ($emailResult)
		{
			echo "email exist";		
		}
		else if (strlen($password) < 8)
		{
			echo 'short password';
		}
		else {
			echo "true";
		}
		return true;
	}
 
	public function actionSave() {
		$username = htmlspecialchars($_POST['username']);
		$email = htmlspecialchars($_POST['email']);
		$password = htmlspecialchars($_POST['password']);
		$password_hash = hash('md5', hash('md5', $password));
		$activation_code = md5($username.$email.rand(0, 1000));
		if (!$this->model->setNewUser($username, $email, $password_hash, $activation_code)) {
			echo 'registration failed';
		}
		else if (!$this->sendActivationMail($username, $email, $activation_code))
			echo 'mail sending failed';
		else {
			echo 'true';
		}
		return true;
	}

	public function actionConfirm($email, $activation_code) {
		$data['title'] = 'Registration confirmation';
		if ($activation_code == $this->model->searchActivationCode($email)['activation_code'])
		{
			$this->model->setConfirmation($email);
			$template = '<div class="alert alert-success"><strong>Success!</strong>You confirmed registration. To start using Camagru, please Log In </div>';
			$this->view->renderContent($template, $data);
		}
		else {
			$template = '<div class="alert alert-danger"><strong>Error!</strong>You confirmation failed, due to bad link.</div>';
			$this->view->renderContent($template, $data);
		}
		return true;
	}
	
	public function sendActivationMail($login, $email, $activation_code) {
        $header = "From: no-reply@camagru.ua";
        $subject = "Confirm the registration - Camagru.Inc";
        $message = "Dear $login, welcome to Camagru!\n";
        $message .= "To confirm the registration use the link below:\n";
        $path = Config::ROOT_URI."/registration/confirm/".$email."/".$activation_code;
        $message .= $path;
        return mail($email, $subject, $message, $header);
    }

}