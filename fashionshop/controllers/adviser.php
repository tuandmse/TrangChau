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
		$data["node_view"] = $this->Adviser_model->node_view();
		$data["cF_node_view"] = $this->Adviser_model->node_view_filter_CfType();

		
		$data["question_view"] =  $this->Adviser_model->question_view();
		
		//if( $this->input->post("submitInfor") ) {
         //   if( $this->Adviser_model->test()) 	{
         //      $data["postedInfor"] = true;
		//	   $data["postedStyle"] = false;
        //    }
        //}
        if( $this->input->post("submitInfor") ) {
		
		    
           $answerYN = array();
			foreach( $data["node_view"] as $node_entry )
			 {
			$answerYN[$node_entry->questionNode]  =  $this->input->post($node_entry->questionNode);
			}
			
			$answerCF = array();
			foreach( $data["cF_node_view"] as $cf_node_entry )
			 {
			$answerYN[$cf_node_entry->nodesNode]  =  $this->input->post($cf_node_entry->nodesNode);
			}


           // if( $this->Adviser_model->test()) 	{
            //   $data["postedStyle"] = true;
			  // $data["postedInfor"] = false;
            //}
        }
		 $this->load->view("call_adviser.php", $data);
	}
}
?>

