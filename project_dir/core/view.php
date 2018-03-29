<?php

// namespace core;

class View
{
    public function renderTamplate($content, $date = array()){
        
        if (is_array($date)){
            extract($date);
        }
        include_once ROOT . '../app/views/header.view.php';
        include_once ROOT . '../app/views/' . $content . '.view.php';
		include_once ROOT . '../app/views/footer.view.php';
    }

    public function renderSide($content, $sideBar, $date = array()){
    	if (is_array($date)){
    		extract($date);
    	}
    	include_once ROOT . '../app/views/header.view.php';
    	include_once ROOT . '../app/views/' . $content . '.view.php';
    	include_once ROOT . '../app/views/' . $sideBar . '.view.php';
    	include_once ROOT . '../app/views/footer.view.php';
    }

    public function renderContent($content, $date = array()){
        if (is_array($date)){
            extract($date);
        }
        include_once ROOT . '../app/views/header.view.php';
        echo $content;
        include_once ROOT . '../app/views/footer.view.php';
    }    

}