<?php


class Adviser_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function test()
    {
        return true;
    }


    function get_product_by_ruleNode($id)
    {
        $this->db->order_by('id', 'ASC');
        $this->db->where('adviserNode', $id);
        $result = $this->db->get('products');
        return $result->result();

    }


    function node_view_filter_CfType($idCF)
    {
        //sort by alphabetically by default
        $this->db->order_by('nodesNode', 'ASC');
        $this->db->where('questionNode', $idCF);

        $result = $this->db->get('adviser_nodes');
        return $result->result();

    }

    function node_view()
    {
        //sort by alphabetically by default
        $this->db->order_by('nodesNode', 'ASC');

        $result = $this->db->get('adviser_nodes');
        return $result->result();

    }

    function node_view_filterYN($idCF)
    {
        //sort by alphabetically by default
        $this->db->order_by('nodesNode', 'ASC');

        $this->db->where('questionNode != "' . $idCF . '" and questionNode is NOT NULL  and  questionNode !="" ', null, false);

        $result = $this->db->get('adviser_nodes');
        return $result->result();

    }

    function node_filter_questionNode($qN)
    {
        //sort by alphabetically by default
        $this->db->order_by('nodesNode', 'ASC');
        $this->db->where('questionNode', $qN);
        $result = $this->db->get('adviser_nodes');
        return $result->result();

    }


    function question_view()
    {
        //sort by alphabetically by default
        $this->db->order_by('questionNode', 'ASC');
        $this->db->where('questionType', 'YN');
        $result = $this->db->get('adviser_question');
        return $result->result();

    }

    function findIDCF()
    {
        //sort by alphabetically by default
        $this->db->order_by('questionNode', 'ASC');
        $this->db->where('questionType', 'CF');
        $result = $this->db->get('adviser_question');
        return $result->result();

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


}