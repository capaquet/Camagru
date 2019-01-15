<?php

Class Image {

    public function save_image($db, $id_owner){
        require '/app/config/info_db.php';    
        $db->query("INSERT INTO " .$db_config['db_name'].".".$db_config['img_table']. " SET img_owner = ?", [$id_owner]);
    }

    public function search_image($db, $id_owner){
        require '/app/config/info_db.php';
        $photo_list = $db->query("SELECT * FROM " .$db_config['db_name'].".".$db_config['img_table']. " WHERE img_owner = ?", [$id_owner])->fetchall();
        return $photo_list;
    }

    public function delete_image($db, $id_img){
        require '/app/config/info_db.php';
        $db->query("DELETE FROM " .$db_config['db_name'].".".$db_config['img_table']. " WHERE img_id = ?", [$id_img]);
    }
   
    public function add_like(){

    }

    public function delete_like(){

    }
}