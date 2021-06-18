<?php

namespace Project\Models;
use \Core\Model;

class Links extends Model{
    public function getAll(){
        return $this->findMany("SELECT * FROM links");
    }

    public function deleteFromDb($id){
        $query = "DELETE FROM links WHERE id=".$id;
        $this->deleteData($query);
    }
}
