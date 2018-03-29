<?php

class LoginModel extends Model
{
	// $b=$a->prepare("UPDATE `users` SET user=:var");
	// $b->bindParam(":var",$var);
	// $b->execute();

	public function getUser($login)
	{
		if ($login)
		{
			try {
				$result = $this->db->prepare('SELECT `id`, `login`, `password`, `confirm`
								FROM `users`
								WHERE `login`=:login');
				$result->bindParam(':login', $login);
				$result->execute();
				return $result->fetch();
			} catch (PDOException $e) {
				return false;
			}
		}
		return false;
	}

	public function changePass($email)
	{
		if ($email)
		{
			try {
				$result = $this->db->prepare("SELECT `email`
									FROM `users`
									WHERE `email`=:email");
				$result->bindParam(':email', $email);
				$result->execute();
				if (!empty($result->fetch())) {
					$pass = md5(md5('12345678'));
					$change = $this->db->prepare('UPDATE `users`
						SET `password` = :pass
						WHERE `email` = :email');
					$change->bindParam(':pass', $pass);
					$change->bindParam(':email', $email);
					$change->execute();
					return false;    
				}
			} catch (PDOException $e) {
				return true;
			}

		}
		return true;
	}

	public function getUserPassLogin($login_c)
	{
		try {
			$result = $this->db->prepare('SELECT `id`,`login`,`password` from `users` WHERE `login`=:login_c');
			$result->bindParam(':login_c', $login_c);
			$result->execute();
			return $result->fetch();
		} catch (PDOException $e) {
			return 0;
		}
	}
}