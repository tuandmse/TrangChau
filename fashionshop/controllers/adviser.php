<?php


class Adviser extends Front_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model(array(
            'Adviser_model'
        ));
        $query = "CREATE TABLE IF NOT EXISTS " . $this->db->dbprefix('adviser_question') . " (
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
        $data                = array();
        $data["postedStyle"] = false;
        $data["postedInfor"] = false;
        $data["posted"]      = false;
        $data["node_view"]   = $this->Adviser_model->node_view();
		
		$data["ID_of_CF"]   = $this->Adviser_model->findIDCF();

		
        $data["node_view_filterYN"]   = $this->Adviser_model->node_view_filterYN($data["ID_of_CF"][0]->questionNode);
        $data["cF_node_view"] = $this->Adviser_model->node_view_filter_CfType($data["ID_of_CF"][0]->questionNode);
        
        
        $data["question_view"] = $this->Adviser_model->question_view();
        
    
		
		
        if ($this->input->post("submitInfor")) {
            
						$answerYN = array();
						$answer = array();
						
						
						$i= 0;
                        foreach( $data["question_view"] as $node_entry )
                        {
						echo ''. $this->input->post($node_entry->questionNode);
						$obj = new stdClass();
						$obj->node =  $this->input->post($node_entry->questionNode);
						$obj->cf =  1;
						$answer[$i]=$obj;
						$i++;
						
						}
						
					
						
                        
                        $answerCF = array();
                        foreach( $data["cF_node_view"] as $cf_node_entry )
                         {
					    $obj = new stdClass();
						$obj->node = $cf_node_entry->nodesNode;
						$obj->cf =  $this->input->post($cf_node_entry->nodesNode);
						$answer[$i]=$obj;
						$i++;
                        }
						
			
			
        }
        
        $this->load->view("call_adviser.php", $data);
    }
    
}
?>
