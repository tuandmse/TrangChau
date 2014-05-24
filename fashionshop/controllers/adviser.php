<?php


class Adviser extends Front_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model(array('Adviser_model'));
       
    }
	function index()
	{
		  $data = array();
        $data["postedStyle"] = false;
		$data["postedInfor"] = false;
		
		if( $this->input->post("submitInfor") ) {
		
		
            $data = array(
                "gender"	=> $this->input->post("gender"),
                "age"	=> $this->input->post("age"),
                "height"	=> $this->input->post("height"),
                "weight"	=> $this->input->post("weight"),
                "skin"	=> $this->input->post("skin")

            );
            if( $this->Adviser_model->test()) 	{
               $data["postedInfor"] = true;
			   $data["postedStyle"] = false;

            }

        }
        if( $this->input->post("submitStyle") ) {
		
		
            $data = array(
                "congviec"	=> $this->input->post("congviec"),
                "thanhlich"	=> $this->input->post("thanhlich"),
                "quyenru"	=> $this->input->post("quyenru"),
                "catinh"	=> $this->input->post("catinh"),
                "nhenhang"	=> $this->input->post("nhenhang"),
                "tretrung"	=> $this->input->post("tretrung"),
                "sanhdieu"	=> $this->input->post("sanhdieu"),
                "hoatdong"	=> $this->input->post("hoatdong"),

            );
            if( $this->Adviser_model->test()) 	{
               $data["postedStyle"] = true;
			   $data["postedInfor"] = false;

            }

        }
        $this->load->view("call_adviser.php", $data);
	}
}
?>

