<?php

class GalleryController extends Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->model = new GalleryModel;
	}

	public function actionViewall() {
		Session::unsetFilter();
		$data['title'] = 'All gallery';
		$data['users'] = $this->model->getUsers();
		$data['images'] = $this->model->getAllImages();
		$data['page'] = 1;
		$data['max_page'] = $this->model->getMaxPages(0);
		$this->view->renderTamplate('gallery', $data);
		return true;
	}

	public function actionLike() {
		$image_id = intval($_POST['image_id']);
		$image_owner = htmlspecialchars($_POST['image_owner']);
		if ($image_owner == Session::get('user_name') || !Session::isLoggedOnUser())
			return true;
		$sendEmail = $this->model->setLike($image_id);
		$email = $this->model->getImageOwnerEmail($image_owner);
		if ($sendEmail && $email)
			$this->sendLikeMail(Session::get('user_name'), $email);
		return true;
	}

	public function sendLikeMail($login, $email) {
        $header = "From: no-reply@camagru.ua";
        $subject = "You get like from ".$login." - Camagru.Inc";
        $message = "Dear user, ".$login." resently liked your photo!\n";
        $message .= "To view it, visit our site!";
        return mail($email, $subject, $message, $header);
    }

	public function actionFilter(){
		$login_filter = htmlspecialchars($_POST['login_filter']);
		Session::setAdd('login_filter', $login_filter);
		return true;
	}

	public function actionView($page_id)
	{
		$data['title'] = 'Gallery - page '.$page_id;
		$data['users'] = $this->model->getUsers();
		$data['images'] = $this->model->getImages(Session::get('login_filter'), $page_id);
		$data['page'] = $page_id;
		$data['max_page'] = $this->model->getMaxPages(Session::get('login_filter'));
		if ($page_id > $data['max_page'])
		{
			header('Location: /404');
			exit;
		}
		$this->view->renderTamplate('gallery', $data);
		return true;
	}

	public function actionImage($imageId)
	{
		$data['title'] = 'Image '.$imageId;
		$data['image'] = $this->model->getImage($imageId);
		$this->view->renderTamplate('image', $data);
		return true;
	}

	public function actionGetcomment()
	{
		$comment_limit = intval($_POST['comment_limit']);
		$image_id = intval($_POST['image_id']);
		$comments = $this->model->getComments($comment_limit, $image_id);
		echo json_encode($comments);
		return true;
	}

	public function actionComment()
	{
		if (!Session::isLoggedOnUser())
			return true;
		$text = htmlspecialchars($_POST['text_comment']);
		$commenter_id = Session::get('user_id');
		$imageId = intval($_POST['image_id']);
		$comentsInfo = $this->model->addComment($imageId, $commenter_id, $text);
		if (!$comentsInfo)
			return true;
		echo json_encode($comentsInfo);
		return true;
	}

	public function actionDelete()
	{
		$imageId = intval($_POST['imageId']);
		$imagePath = substr($_POST['imagePath'], 1);
		$this->model->deleteImg($imageId);
		unlink($imagePath);
		return true;
	}
}