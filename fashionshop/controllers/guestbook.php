<?php
/**
 * User: Trang Chau
 * Date: 5/23/14
 * Time: 8:00 PM
 */

class Guestbook extends Front_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model(array('Guestbook_model'));
        $query =
            "CREATE TABLE IF NOT EXISTS " . $this->db->dbprefix('guestbook') . " (
            guestbook_id int(11) NOT NULL auto_increment,
            name varchar(255) CHARACTER SET utf8 NOT NULL,
            email varchar(255) CHARACTER SET utf8 NOT NULL,
            title varchar(255) CHARACTER SET utf8 NOT NULL,
            datetime datetime NOT NULL,
            content text CHARACTER SET utf8 NOT NULL,
            PRIMARY KEY (guestbook_id)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10;";
        $this->db->query($query);
    }

    function index()
    {
        $data = array();
        $data["posted"] = false;
        if ($this->input->post("submit")) {
            $data = array(
                "name" => $this->input->post("name"),
                "email" => $this->input->post("email"),
                "content" => $this->input->post("content"),
                "title" => $this->input->post("title")
            );
            if ($this->Guestbook_model->insert($data)) {
                $data["posted"] = true;
            }
        }
        $this->load->view("guestbook.php", $data);
    }
}

