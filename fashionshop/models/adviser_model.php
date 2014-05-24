<?php


class Adviser_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	function test(){
	return true;
	}
  

    function insert( $data = array() ) {
        $data["name"] = $this->db->escape_str($data["name"]);
        $data["email"] = $this->db->escape_str($data["email"]);
        $data["content"] = $this->db->escape_str($data["content"]);
        $data["title"] = $this->db->escape_str($data["title"]);
        $data["name"] = htmlspecialchars( $data["name"] );
        $data["email"] = htmlspecialchars( $data["email"] );
        $data["title"] = htmlspecialchars( $data["title"] );
        $data["content"] = htmlspecialchars( $data["content"] );
        $datetime = date('Y-m-d H:i:s');
        $sql = "INSERT INTO fs_guestbook (guestbook_id,name,email,title,datetime,content) VALUES ('null','". $data["name"] ."','". $data["email"] ."','". $data["title"] ."','$datetime','". $data["content"] ."')";
        return $this->db->query( $sql );
    }

   
}