<?php

class PhotoController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->model = new PhotoModel;
	}
	
	public function actionMake()
	{
		if (!$this->before())
		{
			header('Location: /login');
			exit;
		}
		$data['title'] = 'Make photo';
		$this->view->renderTamplate('photo', $data);
		return true;
	}

	public function actionUpload()
	{
		if (!isset($_FILES['userfile']['name']) || $_FILES['userfile']['error'] > 0)
		{
			echo 'error';
			return true;
		}
		$lastId = $this->model->getLastId();
		if (is_array($lastId))
			$lastId = $lastId[0];
		$defaultName = (($lastId + 1). mb_strrchr($_FILES['userfile']['name'], '.'));
		$filePath = 'img/'.Session::get('user_name').'/'.$defaultName;
		$dirName = 'img/' . Session::get('user_name');
		if ($this->model->uploadImg($filePath))
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

	public function actionSave()
	{
		if (!$_POST['img'])
		{
			echo 'error';
			return true;
		}
		$data = $_POST['img'];
		$type = 0;
		$lastId = $this->model->getLastId();
		if (is_array($lastId))
			$lastId = $lastId[0];
		$defaultName = ($lastId + 1).'.jpg';
		$filePath = 'img/'.Session::get('user_name').'/'.$defaultName;
		$dirName = 'img/' . Session::get('user_name');
		if ($this->model->uploadImg($filePath))
		{
			if (!file_exists($dirName))
				mkdir($dirName);
			list($type, $data) = explode(';', $data);
			list(, $data)      = explode(',', $data);
			$data = base64_decode($data);
			file_put_contents($filePath, $data);
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