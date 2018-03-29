<?php


class GalleryModel extends Model
{

	public function getUsers()
	{
		try {
			$result = $this->db->prepare('SELECT `login` FROM `users`');
			$result->setFetchMode(PDO::FETCH_ASSOC);
			$result->execute();
			$users = $result->fetchAll();
			foreach ($users as &$user)
			{
				$user['same'] = 0;
				if (Session::get('login_filter') == $user['login'])
					$user['same'] = 1;
			}
			return $users;
		} catch (PDOException $e) {
				return 0;
		}
	}

	public function isLikedByUser($image_id, $signup_user_id)
	{
		try {
			$result = $this->db->prepare('SELECT COUNT(`id`) as liked
				FROM `likes`
				WHERE `photo_id` = :image_id
				AND `user_id` = :signup_user_id');
			$result->bindParam(':image_id', $image_id);
			$result->bindParam(':signup_user_id', $signup_user_id);
			$result->execute();
			return $result->fetch()['liked'];
		} catch (PDOException $e) {
				return 0;
		}
	}

	public function getAllImages()
	{
		try {
			$result = $this->db->prepare('SELECT `photos`.`id` AS `id`, `users`.`login` AS `login`,
			`path`, COUNT(`comments`.`id`) AS `comments`
			FROM `photos`
			LEFT JOIN `users` ON `photos`.`user_id`=`users`.`id`
			LEFT JOIN `comments` ON `photos`.`id`=`comments`.`photo_id`
			GROUP BY `photos`.`id`
			ORDER BY `photos`.`date`
			LIMIT 6 OFFSET 0');
			$result->setFetchMode(PDO::FETCH_ASSOC);
			$result->execute();
			$images = $result->fetchAll();
	
			foreach ($images as &$image)
			{
				$image['liked'] = self::isLikedByUser($image['id'], Session::get('user_id'));
				$image['likes'] = self::getPhotoLikes($image['id']);
			}
			return $images;
		} catch (PDOException $e) {
				return 0;
		}
	}

	public function getMaxPages($login_filter)
	{
		try {
			$whereQuery = ' ';
			if ($login_filter)
				$whereQuery = ' WHERE `login`=:login_filter ';
			$result = $this->db->prepare('SELECT COUNT(`photos`.`id`) AS `count`
				FROM `photos`
				INNER JOIN `users` ON `photos`.`user_id`=`users`.`id`
				' . $whereQuery);
			if ($login_filter)
				$result->bindParam(':login_filter', $login_filter);
			$result->execute();
			return floor($result->fetch()['count'] / 6 + 1);
		} catch (PDOException $e) {
				return 0;
		}
	}

	public function getImages($login_filter, $page_id)
	{
		try {
			$whereQuery = ' ';
			if ($login_filter)
				$whereQuery = ' WHERE `login`=:login_filter ';
			$limitQuery = 'LIMIT 6 OFFSET '.($page_id - 1) * 6;
			$result = $this->db->prepare('SELECT `photos`.`id` AS `id`, `users`.`login` AS `login`,
				`path`, COUNT(`comments`.`id`) AS `comments`
				FROM `photos`
				LEFT JOIN `users` ON `photos`.`user_id`=`users`.`id`
				LEFT JOIN `comments` ON `photos`.`id`=`comments`.`photo_id`
				'.$whereQuery.'
				GROUP BY `photos`.`id`
				ORDER BY `photos`.`date` '.$limitQuery);
			$result->setFetchMode(PDO::FETCH_ASSOC);
			if ($login_filter)
				$result->bindParam(':login_filter', $login_filter);
			$result->execute();
			$images = $result->fetchAll();
		
			foreach ($images as &$image)
			{
				$image['path'] = '/'.$image['path'];
				$image['liked'] = self::isLikedByUser($image['id'], Session::get('user_id'));
				$image['likes'] = self::getPhotoLikes($image['id']);
			}
			return $images;	
		} catch (PDOException $e) {
				return 0;
		}
	}

	public function getPhotoLikes($photo_id)
	{
		try {
			$result = $this->db->prepare('SELECT COUNT(`id`) as liked
				FROM `likes`
				WHERE `photo_id` = :photo_id');
			$result->bindParam(':photo_id', $photo_id);
			$result->execute();
			return $result->fetch()['liked'];
		} catch (PDOException $e) {
				return 0;
		}
	}

	public function setLike($photo_id)
	{
		$user_id = Session::get('user_id');
		$likesByUser = self::isLikedByUser($photo_id, $user_id);
		$likesCount = self::getPhotoLikes($photo_id);
		$likesObj = new stdClass();
		try {
			if (!$likesByUser){
				$result = $this->db->prepare('INSERT INTO `likes`(`photo_id`, `user_id`) VALUES (:photo_id, :user_id)');
				$result->bindParam(':photo_id', $photo_id);
				$result->bindParam(':user_id', $user_id);
				$result->execute();
				$likesObj->status = 'like set';
				$likesObj->count = $likesCount + 1;
				$sendEmail = true;
			}
			else {
				$result = $this->db->prepare('DELETE FROM `likes` WHERE `user_id`=:user_id');
				$result->bindParam(':user_id', $user_id);
				$result->execute();
				$likesObj->status = 'like remove';
				$likesObj->count = $likesCount - 1;
				$sendEmail = false;
			}
			$myJSON = json_encode($likesObj);
			echo $myJSON;
			return $sendEmail;
		} catch (PDOException $e) {
				return 0;
		}
	}

	public function getImageOwnerEmail($image_owner)
	{
		try {
			$result = $this->db->prepare('SELECT `notify_me`, `email`
				FROM `users`
				WHERE `login` = :image_owner');
			$result->bindParam(':image_owner', $image_owner);
			$result->execute();
			$user_info = $result->fetch();
			if (!$user_info['notify_me'])
				return false;
			return $user_info['email'];
		} catch (PDOException $e) {
				return 0;
		}
	}

	public function getImage($imageId)
	{
		try {
			$result = $this->db->prepare('SELECT `photos`.`id` AS `id`, `users`.`login` AS `login`,`users`.`avatar` AS `owner_avatar`,
				`path`, `photos`.`date`, COUNT(`comments`.`id`) AS `comments`
				FROM `photos`
				LEFT JOIN `users` ON `photos`.`user_id`=`users`.`id`
				LEFT JOIN `comments` ON `comments`.`photo_id`= `photos`.`id`
				WHERE `photos`.`id`=:imageId');
			$result->bindParam(':imageId', $imageId);
			$result->setFetchMode(PDO::FETCH_ASSOC);
			$result->execute();
			$image = $result->fetchAll();
		} catch (PDOException $e) {
			header("Location: /404");
			exit();
		}
		if (!$image[0]['id']){
			header("Location: /404");
			exit();
		}
		$image[0]['date'] = date('F j, Y, g:i a', $image[0]['date']);
		$image[0]['liked'] = self::isLikedByUser($imageId, Session::get('user_id'));
		$image[0]['likes'] = self::getPhotoLikes($image[0]['id']);

		return $image[0];
	}

	public function getComments($comment_limit, $image_id)
	{
		try {
			$result = $this->db->prepare('SELECT `comments`.`id` AS `id`, `users`.`login` AS `login`,
				`users`.`avatar` AS `avatar`,
				 `date`, `text`
				FROM `comments`
				LEFT JOIN `users` ON `comments`.`user_id`=`users`.`id`
				WHERE `photo_id`=:image_id
				ORDER BY `date` DESC
				LIMIT 4 OFFSET '.$comment_limit * 4);
			$result->setFetchMode(PDO::FETCH_ASSOC);
			$result->bindParam(':image_id', $image_id);
			$result->execute();
			$comments = $result->fetchAll();
		} catch (PDOException $e) {
			return 0;
		}
		foreach ($comments as &$comment) {
			$comment['date'] = date('F j, Y, g:i a', $comment['date']);
		}
		return $comments;
	}

	public function addComment($imageId, $commenter_id, $c_text)
	{
		$c_date = time();
		try {
			$addComment = $this->db->prepare('INSERT INTO `comments`(`photo_id`, `user_id`, `text`, `date`)
				VALUES (:imageId, :commenter_id, :c_text, :c_date)');
			$addComment->bindParam(':imageId', $imageId);
			$addComment->bindParam(':commenter_id', $commenter_id);
			$addComment->bindParam(':c_text', $c_text);
			$addComment->bindParam(':c_date', $c_date);
			$addComment->execute();
			$commentObj = new stdClass();
			$commentId = $this->db->prepare('SELECT `id` FROM `comments` WHERE `date`=:c_date AND `photo_id`=:imageId');
			$commentId->bindParam(':imageId', $imageId);
			$commentId->bindParam(':c_date', $c_date);
			$commentId->execute();
			$commentObj->commentId = $commentId->fetch()[0];
			$commentObj->login = Session::get('user_name');
			$getAvatar = $this->db->prepare('SELECT `avatar` FROM `users` WHERE `id`=:commenter_id');
			$getAvatar->bindParam(':commenter_id', $commenter_id);
			$getAvatar->execute();
			$commentObj->avatar = $getAvatar->fetch()[0];
			$commentObj->text = $c_text;
			$commentObj->date = date('F j, Y, g:i a', $c_date);
			$commentCount = $this->db->prepare('SELECT COUNT(`id`) AS `count` FROM `comments` WHERE `photo_id`=:imageId');
			$commentCount->bindParam(':imageId', $imageId);
			$commentCount->execute();
			$commentObj->count = $commentCount->fetch()[0];
		} catch (PDOException $e) {
			return 0;
		}
		return $commentObj;
	}

	public function deleteImg($imageId)
	{
		try {
			$result = $this->db->prepare("DELETE FROM `photos` WHERE `id`=:imageId");
			$result->bindParam(":imageId", $imageId);
			$result->execute();
		} catch (PDOException $e) {
			return 0;
		}
	}
}