<?php


class Adviser extends Front_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model(array(
            'Adviser_model', 'Adviser_rule_model', 'Adviser_node_model'));
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
		$data["products_image"] =array();
		
        if ($this->input->post("submitInfor")) {
            
						$answerYN = array();
						$answer = array();
						$i= 0;
                        foreach( $data["question_view"] as $node_entry )
                        {
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
						
						
						//echo $this->get_lastNode($answer);
						$data["products_image"] = $this->Adviser_model->get_product_by_ruleNode($this->get_lastNode($answer));
						//var_dump($data["products_image"]);
						//echo $this->advice_processing($answer);
				    $data["postedInfor"] = true;
					
					$data["advice"]= $this->advice_processing($answer);
					$data["base_url"]= $this->uri->segment_array();


        }
        $this->view("call_adviser.php", $data);
    }
	
	
	function get_lastNode($inputs)
    {
        header('Content-Type: text/html; charset=utf-8');
        $rules = $this->Adviser_rule_model->view();

        $usable_rule = $this->get_usable_rule($inputs, $rules);

        if (count($usable_rule) > 0) {
            $superFinal = new stdClass();
			
            $superFinal->node = '';
            $superFinal->cf = '';
            $finalResult = array();
            $maxCF = 0;
            foreach ($usable_rule as $key => $urule) {
                $exploded = $this->multiexplode(array("^", "=>"), $urule->rulesContent);
                $lastItem = $exploded[count($exploded) - 1];
                array_push($finalResult, $urule);
                unset($usable_rule[$key]);
                $usable_rule = array_values($usable_rule);
                foreach ($usable_rule as $key2 => $urule2) {
                    $exploded2 = $this->multiexplode(array("^", "=>"), $urule2->rulesContent);
                    $lastItem2 = $exploded2[count($exploded2) - 1];
                    if ($lastItem2 == $lastItem) {
                        array_push($finalResult, $urule2);
                        unset($usable_rule[$key2]);
                        $usable_rule = array_values($usable_rule);
                    }
                }
                if ($this->calculateCF($inputs, $finalResult) > $maxCF) {
                    $superFinal->node = $lastItem;
                    $superFinal->cf = $this->calculateCF($inputs, $finalResult);
                    $maxCF = $this->calculateCF($inputs, $finalResult);
                }
                $finalResult = array();
            }
			if($superFinal->node !=""){
             
			 return $superFinal->node;

			}else{
			return  ' ';

			}
			
			
        } else {
           return  'Thông tin bạn cung cấp không đủ để chúng tôi tư vấn cho bạn!';
        }
		
    }
	
	
	function multiexplode($delimiters, $string)
    {
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return $launch;
    }

    function check_exist_in_arrays($inputs, $ruleId)
    {
        foreach ($inputs as $input) {
            if ($input->node == $ruleId) {
                return true;
            }
        }
        return false;
    }

	
	
    function advice_processing($inputs)
    {
        header('Content-Type: text/html; charset=utf-8');
        $rules = $this->Adviser_rule_model->view();

        $usable_rule = $this->get_usable_rule($inputs, $rules);

        if (count($usable_rule) > 0) {
            $superFinal = new stdClass();
			
            $superFinal->node = '';
            $superFinal->cf = '';
            $finalResult = array();
            $maxCF = 0;
            foreach ($usable_rule as $key => $urule) {
                $exploded = $this->multiexplode(array("^", "=>"), $urule->rulesContent);
                $lastItem = $exploded[count($exploded) - 1];
                array_push($finalResult, $urule);
                unset($usable_rule[$key]);
                $usable_rule = array_values($usable_rule);
                foreach ($usable_rule as $key2 => $urule2) {
                    $exploded2 = $this->multiexplode(array("^", "=>"), $urule2->rulesContent);
                    $lastItem2 = $exploded2[count($exploded2) - 1];
                    if ($lastItem2 == $lastItem) {
                        array_push($finalResult, $urule2);
                        unset($usable_rule[$key2]);
                        $usable_rule = array_values($usable_rule);
                    }
                }
                if ($this->calculateCF($inputs, $finalResult) > $maxCF) {
                    $superFinal->node = $lastItem;
                    $superFinal->cf = $this->calculateCF($inputs, $finalResult);
                    $maxCF = $this->calculateCF($inputs, $finalResult);
                }
                $finalResult = array();
            }
			if($superFinal->node !=""){
            $suggestNodes = $this->Adviser_node_model->viewdetails($superFinal->node);
           return  'Trang phục phù hợp với bạn là: ' . $suggestNodes->nodesContent;

			}else{
			return  'Thông tin bạn cung cấp không đủ để chúng tôi tư vấn cho bạn!';

			}
			
			
        } else {
           return  'Thông tin bạn cung cấp không đủ để chúng tôi tư vấn cho bạn!';
        }
		
    }

    // get usable rule depends on user's input
    function get_usable_rule($inputs, $rules)
    {
        // init the array for outputting
        $usable_rule = array();
        foreach ($rules as $rule) {
            // explode the rulesContent content into multiple nodesNode
            $exploded = $this->multiexplode(array("^", "=>"), $rule->rulesContent);
            $flag = true;
            // for each nodesNode in the rulesContent
            foreach ($exploded as $key => $nodesNode) {
                // if nodesNode is in the leftside
                if ($key < count($exploded) - 1) {
                    // if nodesNode is not exist in user's inputs
                    // flag=false as the rule is not usable
                    if (!$this->check_exist_in_arrays($inputs, $nodesNode)) {
                        $flag = false;
                    }
                }
            }
            // if flag remain true after the foreach loop, rule is usable
            // push rule to the array for outputting
            if ($flag == true) {
                array_push($usable_rule, $rule);
            }
        }
        // return the array of usable rule(s)
        return $usable_rule;
    }

    // get the single input from user's input
    function getSingleInputFormInputs($inputs, $id)
    {
        foreach ($inputs as $input) {
            if ($input->node == $id) {
                return $input;
            }
        }
    }

    function calculateCF($inputs, $finalResult)
    {
        $fArray = array();
        foreach ($finalResult as $ruleTemp) {
            $exploded = $this->multiexplode(array("^", "=>"), $ruleTemp->rulesContent);
            $minCF = $this->getSingleInputFormInputs($inputs, $exploded[0])->cf;
            foreach ($exploded as $key => $id) {
                if ($key < count($exploded) - 1) {
                    if ($this->getSingleInputFormInputs($inputs, $id)->cf < $minCF) {
                        $minCF = $this->getSingleInputFormInputs($inputs, $id)->cf;
                    }
                }
            }
            $f = $minCF * $ruleTemp->rulesCF;
            array_push($fArray, $f);
        }
        return $this->recursiveCertainty($fArray);
    }

    // calculate the certainty
    function recursiveCertainty($inputs)
    {
        // if input array is empty, return 0
        if (count($inputs) == 0) {
            return 0;
        } //else if input array contains 1 item, return its value
        else if (count($inputs) == 1) {
            return $inputs[0];
        } else {
            // this happens when multiple rules have the same conclusion
            // if both CF are positive
            // CF(t) = CF(t1) + CF(t2) – CF(t1) * CF(t2)
            if ($inputs[0] > 0 && $inputs[1] > 0) {
                $tam = $inputs[0] + $inputs[1] - ($inputs[0] * $inputs[1]);
            } // if both CF are negative
            // CF(t) = CF(t1) + CF(t2) + CF(t1) * CF(t2)
            else if ($inputs[0] < 0 && $inputs[1] < 0) {
                $tam = $inputs[0] + $inputs[1] + ($inputs[0] * $inputs[1]);
            } // otherwise
            // CF(t) = (CF(t1) + CF(t2)) / (1 – MIN(ABS(CF(t1)), ABS(CF(t2))))
            else {
                $tam = ($inputs[0] + $inputs[1]) / (1 - min(abs($inputs[0]), abs($inputs[1])));
            }
            // set CF(t) to the first item in array
            $inputs[0] = $tam;
            // remove the second item out of array
            unset($inputs[1]);
            // reindex the array
            $inputs = array_values($inputs);
            // call recursively function until the input arrays has only 1 item
            $this->recursiveCertainty($inputs);
        }
    }


    
}
?>
