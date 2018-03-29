<?php

class RegistrationModel extends Model
{

	public function searchUser($login)
	{
		if ($login)
		{
			try {
				$result = $this->db->prepare('SELECT `login`
									FROM `users`
									WHERE `login`=:login');
				$result->bindParam(':login', $login);
				$result->execute();
				if (empty($result->fetch())) {
					return false;    
				}
			} catch (PDOException $e) {
				return false;
			}
		return true;
		}
	}

	public function searchEmail($email)
	{
		if ($email)
		{
			try {
				$result = $this->db->prepare('SELECT `email`
								FROM `users`
								WHERE `email`=:email');
				$result->bindParam(':email', $email);
				$result->execute();
				if (empty($result->fetch())) {
					return false;    
				}
			} catch (PDOException $e) {
				return false;
			}
			return true;
		}
	}

	public function searchActivationCode($email)
	{
		if ($email)
		{
			try {
				$result = $this->db->prepare('SELECT `activation_code`
								FROM `users`
								WHERE `email`=:email');
				$result->bindParam(':email', $email);
				$result->execute();
				return $result->fetch();
			} catch (PDOException $e) {
				return false;
			}
		}
	}

	public function setConfirmation($email){
		try {
			$result = $this->db->prepare('UPDATE `users`
						SET `confirm` = 1
						WHERE `email` = :email');
			$result->bindParam(':email', $email);
			$result->execute();
		} catch (PDOException $e) {
				return false;
		}
	}

	public function setNewUser($username, $email, $password_hash, $activation_code)
	{
		try {
			$add = $this->db->prepare('INSERT INTO `users`(`login`, `email`, `password`, `activation_code`, `notify_me`)
				VALUES (:username, :email, :password_hash, :activation_code, 1)');
			$add->bindParam(':username', $username);
			$add->bindParam(':email', $email);
			$add->bindParam(':password_hash', $password_hash);
			$add->bindParam(':activation_code', $activation_code);
			$add->execute();
			if ($add->rowCount() == 1)
				return true;
			else
				return false;
		} catch (PDOException $e) {
				return false;
		}
	}
}