<?php


class Adviser extends Front_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model(array('Adviser_model'));
        $query =
            "CREATE TABLE IF NOT EXISTS " . $this->db->dbprefix('adviser_question') . " (
            questionNode varchar(11) CHARACTER SET utf8 NOT NULL ,
            questionContent text CHARACTER SET utf8 NOT NULL,
            questionType varchar(11) CHARACTER SET utf8 NOT NULL,
            PRIMARY KEY (questionNode)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
		
		
		
		";
        $this->db->query($query);
    }
	function index()
	{
		  $data = array();
        $data["postedStyle"] = false;
		$data["postedInfor"] = false;
		$data["posted"] = false;
		$data["entries"] = $this->Adviser_model->view();
		if( $this->input->post("submitInfor") ) {
            if( $this->Adviser_model->test()) 	{
               $data["postedInfor"] = true;
			   $data["postedStyle"] = false;
            }
        }
        if( $this->input->post("submitStyle") ) {
            $data = array(
			  "gender"	=> $this->input->post("gender"),
                "age"	=> $this->input->post("age"),
                "height"	=> $this->input->post("height"),
                "weight"	=> $this->input->post("weight"),
                "skin"	=> $this->input->post("skin"),
                "congviec"	=> $this->input->post("a1"),
                "thanhlich"	=> $this->input->post("a2"),
                "quyenru"	=> $this->input->post("a3"),
                "catinh"	=> $this->input->post("a4"),
                "nhenhang"	=> $this->input->post("a5"),
                "tretrung"	=> $this->input->post("a6"),
                "sanhdieu"	=> $this->input->post("a7"),
                "hoatdong"	=> $this->input->post("a8")
            );
            if( $this->Adviser_model->test()) 	{
               $data["postedStyle"] = true;
			   $data["postedInfor"] = false;
            }
        }
	          // $this->load->view("guestbook.php", $data);
		 $this->load->view("call_adviser.php", $data);
	}
}
?>

