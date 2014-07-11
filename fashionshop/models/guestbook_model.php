<?php
/**
 * Created by PhpStorm.
 * User: Trang Chau
 * Date: 5/23/14
 * Time: 8:04 PM
 */

class Guestbook_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function view($data = array(), $return_count = false)
    {
        if (empty($data)) {
            return $this->db->get('guestbook')->result();
        } else {

            if (!empty($data['rows'])) {
                $this->db->limit($data['rows']);
            }

            if (!empty($data['page'])) {
                $this->db->offset($data['page']);
            }

            if (!empty($data['order_by'])) {
                $this->db->order_by($data['order_by'], $data['sort_order']);
            }

            if ($return_count) {
                return $this->db->count_all_results('guestbook');
            } else {
                return $this->db->get('guestbook')->result();
            }
        }
    }

    function insert($data = array())
    {
        $data["name"] = $this->db->escape_str($data["name"]);
        $data["email"] = $this->db->escape_str($data["email"]);
        $data["content"] = $this->db->escape_str($data["content"]);
        $data["title"] = $this->db->escape_str($data["title"]);
        $data["name"] = htmlspecialchars($data["name"]);
        $data["email"] = htmlspecialchars($data["email"]);
        $data["title"] = htmlspecialchars($data["title"]);
        $data["content"] = htmlspecialchars($data["content"]);
        $datetime = date('Y-m-d H:i:s');
        $sql = "INSERT INTO fs_guestbook (guestbook_id,name,email,title,datetime,content) VALUES ('null','" . $data["name"] . "','" . $data["email"] . "','" . $data["title"] . "','$datetime','" . $data["content"] . "')";
        return $this->db->query($sql);
    }

    function viewdetails($id)
    {
        $this->db->where('guestbook_id', $id);
        $result = $this->db->get('guestbook');
        $guestbook = $result->row();
        return $guestbook;
    }

    function delete($id)
    {
        $this->db->where('guestbook_id', $id);
        $this->db->delete('guestbook');
    }
}