<?php


class PhotoModel extends Model
{
	public function getLastId()
	{
		try {
			$result = $this->db->prepare('SELECT `id` FROM `photos` ORDER BY `id` DESC LIMIT 1');
			$result->execute();
			return $result->fetch();
		} catch (PDOException $e) {
			return 0;
		}
	}
	
	public function uploadImg($pathToFile)
	{
		$uid = Session::get('user_id');
		$i_date = time();
		try {
			$result = $this->db->prepare('INSERT INTO `photos`(`path`, `user_id`, `date`) VALUES (:pathToFile, :uid, :i_date)');
			$result->bindParam(':pathToFile', $pathToFile);
			$result->bindParam(':uid', $uid);
			$result->bindParam(':i_date', $i_date);
			$result->execute();
			return true;
		} catch (PDOException $e) {
			return 0;
		}
	}
}