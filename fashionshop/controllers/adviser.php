<?php


class Adviser extends Front_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model(array(
            'Adviser_model', 'Adviser_rule_model', 'Adviser_node_model', 'Adviser_cf_model', 'Adviser_evaluation_model'));


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
        $data = array();
        $data["postedStyle"] = false;
        $data["postedInfor"] = false;
        $data["posted"] = false;
        $data["node_view"] = $this->Adviser_model->node_view();
        $data["ID_of_CF"] = $this->Adviser_model->findIDCF();
        $data["node_view_filterYN"] = $this->Adviser_model->node_view_filterYN($data["ID_of_CF"][0]->questionNode);
        $data["cF_node_view"] = $this->Adviser_model->node_view_filter_CfType($data["ID_of_CF"][0]->questionNode);
        $data["question_view"] = $this->Adviser_model->question_view();
        $data["products_image"] = array();

        $data["Adviser_cf"] = $this->Adviser_cf_model->view();


        if ($this->input->post("submitInfor")) {
            $answer = array();
            $i = 0;

            foreach ($data["question_view"] as $node_entry) { // lay cau hoi YN dua vao answer
                $obj = new stdClass();
                if ($this->input->post($node_entry->questionNode)) {
                    $obj->node = $this->input->post($node_entry->questionNode);
                    $obj->cf = 1;

                    $answer[$i] = $obj;
                    $i++;
                }

            }
            foreach ($data["cF_node_view"] as $cf_node_entry) { // lay cau hoi CF dua vao answer
                $obj = new stdClass();
                $obj->node = $cf_node_entry->nodesNode;
                if ($this->input->post($cf_node_entry->nodesNode)) {
                    $obj->cf = $this->input->post($cf_node_entry->nodesNode);
                    $answer[$i] = $obj;
                    $i++;
                }


            }
            $dataJson = json_encode((array)$answer);
            $data["evaluationSelected"] = $dataJson;

            $nodeAnswer = $this->advice_processing($answer);
            $data["products_image"] = $this->Adviser_model->get_product_by_ruleNode($nodeAnswer->nodesNode);
            $data["postedInfor"] = true;
            $data["postedStyle"] = false;
            $data["advice"] = $nodeAnswer->nodesContent;
            $data["base_url"] = $this->uri->segment_array();

            $data["evaluationConclusion"] = $nodeAnswer->nodesNode;


        }


        $this->view("call_adviser.php", $data);
    }

    function multiexplode($delimiters, $string) // để cắt dấu ^ va =>
    {
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return $launch;
    }

    function check_exist_in_arrays($inputs, $ruleId) //
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
            do {
                $oldSize = count($usable_rule);
                $inputs = $this->getMoreInputFromUsable($inputs, $usable_rule);
                $usable_rule = $this->get_usable_rule($inputs, $rules);
            } while (count($usable_rule) != $oldSize);
        }
        $usable_rule = $this->get_clean_usable_rule($usable_rule);
        if (count($usable_rule) > 0) {
            $superFinal = new stdClass();
            $superFinal->node = '';
            $superFinal->cf = '';
            $finalResult = array();
            $maxCF = 0;
            for ($i = 0; $i < count($usable_rule); $i) { // chay tim 2 luat co cung ket luan la lastitem va lastitem2 đưa vào finalresult
                $exploded = $this->multiexplode(array("^", "=>"), $usable_rule[$i]->rulesContent);
                $lastItem = $exploded[count($exploded) - 1];
                array_push($finalResult, $usable_rule[$i]);
                array_splice($usable_rule, $i, 1);
                for ($j = $i; $j < count($usable_rule); $j) {
                    $exploded2 = $this->multiexplode(array("^", "=>"), $usable_rule[$j]->rulesContent);
                    $lastItem2 = $exploded2[count($exploded2) - 1];
                    if ($lastItem2 == $lastItem) {
                        array_push($finalResult, $usable_rule[$j]);
                        array_splice($usable_rule, $j, 1);
                    } else {
                        $j++;
                    }
                }
                $calCF = $this->calculateCF($inputs, $finalResult); // tinh CF
                if ($calCF >= $maxCF) { // so sanh CF
                    $superFinal->node = $lastItem;
                    $superFinal->cf = $calCF;
                    $maxCF = $calCF; // chon CF lon nhat
                }
                $finalResult = array();
            }
            if ($superFinal->node != "") {
                $suggestNodes = $this->Adviser_node_model->viewdetails($superFinal->node);
                return $suggestNodes;
            } else {
                $suggestNodes = new stdClass();
                $suggestNodes->nodesContent = 'Thông tin bạn cung cấp không đủ để chúng tôi tư vấn cho bạn!';
                $suggestNodes->nodesNode = ' ';
                return $suggestNodes;
            }
        } else {
            $suggestNodes = new stdClass();
            $suggestNodes->nodesContent = 'Thông tin bạn cung cấp không đủ để chúng tôi tư vấn cho bạn!';
            $suggestNodes->nodesNode = ' ';
            return $suggestNodes;
        }

    }
    function get_clean_usable_rule($usable_rule){
        $finalResult = array();
        for ($i = 0; $i < count($usable_rule); $i) {
            $currentRule = $usable_rule[$i];
            $exploded = $this->multiexplode(array("^", "=>"), $currentRule->rulesContent);
            $lastItem = $exploded[count($exploded) - 1];
            //array_splice($usable_rule, $i, 1);
            if($this->is_cleanable($lastItem, $usable_rule) === false){
                array_push($finalResult, $currentRule);
            }
            $i++;
        }
        return $finalResult;
    }

    function is_cleanable($lastItem, $usable_rule){
        for ($j = 0; $j < count($usable_rule); $j) {
            $exploded2 = explode("=>", $usable_rule[$j]->rulesContent);
            $exploded2 = explode("^", $exploded2[0]);
            if(in_array($lastItem, $exploded2)){
                return true;
            }
            $j++;
        }
        return false;
    }

    function getMoreInputFromUsable($inputs, $usable_rule)
    {
        $finalResult = array();
        for ($i = 0; $i < count($usable_rule); $i) { // chay tim 2 luat co cung ket luan la lastitem va lastitem2 ??a vào finalresult
            $exploded = $this->multiexplode(array("^", "=>"), $usable_rule[$i]->rulesContent);
            $lastItem = $exploded[count($exploded) - 1];
            array_push($finalResult, $usable_rule[$i]);
            array_splice($usable_rule, $i, 1);
            for ($j = $i; $j < count($usable_rule); $j) {
                $exploded2 = $this->multiexplode(array("^", "=>"), $usable_rule[$j]->rulesContent);
                $lastItem2 = $exploded2[count($exploded2) - 1];
                if ($lastItem2 == $lastItem) {
                    array_push($finalResult, $usable_rule[$j]);
                    array_splice($usable_rule, $j, 1);
                } else {
                    $j++;
                }
            }
            $calCF = $this->calculateCF($inputs, $finalResult);
            $obj = new stdClass();
            $obj->node = $lastItem;
            $obj->cf = $calCF;
            array_push($inputs, $obj);
            $finalResult = array();
        }
        return $inputs;
    }

    function get_usable_rule($inputs, $rules) // dua nhung luat co the su dung vao 1 mang
    {
        $usable_rule = array();
        foreach ($rules as $rule) {
            $exploded = $this->multiexplode(array("^", "=>"), $rule->rulesContent);
            $flag = true;
            foreach ($exploded as $key => $nodesNode) {
                if ($key < count($exploded) - 1) {
                    if (!$this->check_exist_in_arrays($inputs, $nodesNode)) {
                        $flag = false;
                    }
                }
            }
            if ($flag == true) {
                array_push($usable_rule, $rule);
            }
        }
        return $usable_rule;
    }


    function getSingleInputFormInputs($inputs, $id)
    {
        foreach ($inputs as $input) {
            if ($input->node == $id) {
                return $input;
            }
        }
    }

    function calculateCF($inputs, $finalResult) //tính CF của mảng luật có cùng kết luận
    {
        $fArray = array(); // mang chua cac CF cua cac luat co cung ket luan
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
            array_push($fArray, $f); // fArray la 1 mang CF dung de chua CF cua mang luat finalresult
        }
        $value = $this->recursiveCertainty($fArray);
        return $value;
    }


    function recursiveCertainty($inputs)
    {

        if (count($inputs) == 0) {
            return 0;
        } else if (count($inputs) == 1) {
            return $inputs[0];
        } else {
            // CF(t) = CF(t1) + CF(t2) – CF(t1) * CF(t2)
            if ($inputs[0] > 0 && $inputs[1] > 0) {
                $tam = $inputs[0] + $inputs[1] - ($inputs[0] * $inputs[1]);
            } // CF(t) = CF(t1) + CF(t2) + CF(t1) * CF(t2)
            else if ($inputs[0] < 0 && $inputs[1] < 0) {
                $tam = $inputs[0] + $inputs[1] + ($inputs[0] * $inputs[1]);
            } // CF(t) = (CF(t1) + CF(t2)) / (1 – MIN(ABS(CF(t1)), ABS(CF(t2))))
            else {
                $tam = ($inputs[0] + $inputs[1]) / (1 - min(abs($inputs[0]), abs($inputs[1])));
            }
            $inputs[0] = $tam;
            array_splice($inputs, 1, 1);
            return $this->recursiveCertainty($inputs);
        }
    }
}
