<?php


class ProfileModel extends Model
{

	public function getUserInfo($id)
	{
		$id = intval($id);

		if ($id) {
			try {
				$result = $this->db->prepare('SELECT `email`, `login`, `avatar`, `notify_me`
									FROM `users`
									WHERE `id`=:id');
				$result->bindParam(":id", $id);
				$result->execute();
				$userInfo = $result->fetch();
				return $userInfo;
			} catch (PDOException $e) {
				return 0;
			}
		}
	}

	public function findUsernameDuplicated($login)
	{
		try {
			$result = $this->db->prepare('SELECT `id`
									FROM `users`
									WHERE `login`=:login');
			$result->bindParam(':login', $login);
			$result->execute();
			$userId = $result->fetch();
		} catch (PDOException $e) {
			return false;
		}
		if ($userId && Session::get('user_id') != $userId[0])
			return true;
		return false;
	}

	public function findEmailDuplicated($email)
	{
		try {
			$result = $this->db->prepare('SELECT `id`
								FROM `users`
								WHERE `email`=:email');
			$result->bindParam(':email', $email);
			$result->execute();
			$userId = $result->fetch();
		} catch (PDOException $e) {
			return false;
		}
		if ($userId && Session::get('user_id') != $userId[0])
			return true;
		return false;
	}

	public function checkPassword($hash_password, $user_id)
	{
		try {
			$result = $this->db->prepare('SELECT `password`
								FROM `users`
								WHERE `id`=:user_id');
			$result->bindParam(':user_id', $user_id);
			$result->execute();
			$password = $result->fetch();
		} catch (PDOException $e) {
			return false;
		}
		if ($password[0] != $hash_password)
			return true;
		return false;
	}

	public function changeWithPassword($login, $email, $notify_me, $hash_password)
	{
		$id = Session::get('user_id');

		try {
			$result = $this->db->prepare('UPDATE `users`
						SET `login` = :login, `email` = :email, `notify_me` = :notify_me, `password` = :hash_password
						WHERE `id` = :id');
			$result->bindParam(':login', $login);
			$result->bindParam(':email', $email);
			$result->bindParam(':notify_me', $notify_me);
			$result->bindParam(':hash_password', $hash_password);
			$result->bindParam(':id', $id);
			$result->execute();
		} catch (PDOException $e) {
			return false;
		}
	}

	public function changeWithoutPassword($login, $email, $notify_me)
	{
		$id = Session::get('user_id');
		try {
			$result = $this->db->prepare('UPDATE `users`
						SET `login` = :login, `email` = :email, `notify_me` = :notify_me
						WHERE `id` = :id');
			$result->bindParam(':login', $login);
			$result->bindParam(':email', $email);
			$result->bindParam(':notify_me', $notify_me);
			$result->bindParam(':id', $id);
			$result->execute();
		} catch (PDOException $e) {
			return false;
		}
	}

	public function setAvatar($pathToFile)
	{
		$id = Session::get('user_id');
		try {
			$result = $this->db->prepare('UPDATE `users`
						SET `avatar` = :pathToFile
						WHERE `id` = :id');
			$result->bindParam(':pathToFile', $pathToFile);
			$result->bindParam(':id', $id);
			$result->execute();
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}
}