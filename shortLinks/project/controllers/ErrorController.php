<?php

namespace Project\Controllers;

use Core\Controller;

class ErrorController extends Controller{
    protected $title = "Error";

    public function notFound(){
        return $this->render('error/error', []);
    }
}
