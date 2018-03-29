<?php

class ErrorController extends Controller
{
    public function actionError404() {
        header("HTTP/1.0 404 Not Found");
        $data['title'] = 'Error 404';
        $this->view->renderTamplate('error404', $data);
        return true;
    }
}