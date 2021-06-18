<?php

namespace Project\Controllers;

use \Core\Controller;
use \Project\Models\Links;

class  LinksController extends Controller{
    protected $title = "Links";

    public function getLinkForm(){
        return $this->render('links/getLinkForm', []);
    }

    public function redirect($params){
        return $this->render('links/redirect', [
            'link' => $params['link']
        ]);
    }

    public function show(){
        $data = (new Links)->getAll();
        return $this->render('links/show', ['links' => $data]);
    }

    public function delete($params){
        (new Links)->deleteFromDb($params['id']);
        return $this->render("links/delete", []);
    }
}
