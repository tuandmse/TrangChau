<?php
/**
 * User: Ce No
 * Date: 5/23/14
 * Time: 8:00 PM
 */

class Adviser_Rule extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model(array('Adviser_rule_model', 'Adviser_node_model'));
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

    function advice_processing()
    {
        $data1 = new stdClass();
        $data1->node = "NODE000012";
        $data1->cf = "0.6";
        $data2 = new stdClass();
        $data2->node = "NODE000013";
        $data2->cf = "0.2";
        $data3 = new stdClass();
        $data3->node = "NODE000018";
        $data3->cf = "0.8";
        $inputs = array('1' => $data1, "2" => $data2, "3" => $data3);
		
		
        $data["rules"] = $this->Adviser_rule_model->view();
        $usable_rule = array();
        echo 'Usable rule: <br>';
        foreach ($data["rules"] as $rule) {
            $exploded = $this->multiexplode(array("^", "=>"), $rule->rulesContent);
            $found = true;
            foreach ($exploded as $key => $ruleId) {
                if ($key < count($exploded) - 1) {
                    if (!$this->check_exist_in_arrays($inputs, $ruleId)) {
                        $found = false;
                    }
                }
            }
            if ($found == true) {
                echo $rule->rulesId.'<br>';
                array_push($usable_rule, $rule);
            }
        }
        foreach($usable_rule as $urule){
            $exploded = $this->multiexplode(array("^", "=>"), $urule->rulesContent);
            $lastItem = $exploded[count($exploded)-1];
            if(!$this->check_exist_in_arrays($inputs,$lastItem )){
                $dataTemp = new stdClass();
                $dataTemp->node = $lastItem;
                //$dataTemp->cf = $urule->rulesCF;
                array_push($inputs, $dataTemp);
            }
        }
        $superFinal = new stdClass();
        $finalResult = array();
        $maxCF = 0;
        foreach($usable_rule as $key=>$urule){
            $exploded = $this->multiexplode(array("^", "=>"), $urule->rulesContent);
            $lastItem = $exploded[count($exploded)-1];
            array_push($finalResult, $urule);
            unset($usable_rule[$key]);
            foreach($usable_rule as $key2=>$urule2){
                $exploded2 = $this->multiexplode(array("^", "=>"), $urule2->rulesContent);
                $lastItem2 = $exploded2[count($exploded2)-1];
                if($lastItem2 == $lastItem){
                    array_push($finalResult, $urule2);
                    unset($usable_rule[$key2]);
                }
            }
            if($this->calculateCF($inputs, $finalResult) > $maxCF){
                $superFinal->node = $lastItem;
                $superFinal->cf = $this->calculateCF($inputs, $finalResult);
                $maxCF = $this->calculateCF($inputs, $finalResult);
            }
            $finalResult = array();
        }

        $suggestNodes = $this->Adviser_node_model->viewdetails($superFinal->node);
        echo 'Trang phuc phu hop voi ban la: '.$suggestNodes->nodesContent;

    }

    function getInputFormInputs($inputs, $id){
        foreach($inputs as $input){
            if($input->node == $id){
                return $input;
            }
        }
    }

    function calculateCF($inputs, $finalResult){
        $fMang = array();
        foreach($finalResult as $ruleTemp){
            $exploded = $this->multiexplode(array("^", "=>"), $ruleTemp->rulesContent);
            $minCF = $this->getInputFormInputs($inputs,$exploded[0])->cf;
            foreach($exploded as $key=>$id){
                if($key < count($exploded) -1){
                    if($this->getInputFormInputs($inputs,$id)->cf < $minCF){
                        $minCF = $this->getInputFormInputs($inputs,$id)->cf;
                    }
                }
            }
            $f = $minCF*$ruleTemp->rulesCF;
            array_push($fMang, $f);
        }
        return $this->callToGod($fMang);
    }

    function callToGod($inputs){
        if(count($inputs) == 1){
            return $inputs[0];
        } else {
            $tam = 0;
            if($inputs[0] > 0 && $inputs[1] > 0){
                $tam = $inputs[0] + $inputs[1] - ($inputs[0]*$inputs[1]);
            } else if ($inputs[0] < 0 && $inputs[1] < 0){
                $tam = $inputs[0] + $inputs[1] + ($inputs[0]*$inputs[1]);
            } else {
                $tam = ($inputs[0] + $inputs[1])/ (1 - min(abs($inputs[0]), abs($inputs[1])));
            }
            $inputs[0] = $tam;
            unset($inputs[1]);
            $this->callToGod($inputs);
        }
    }


    function index()
    {
        $data = array();
        $data["rules"] = $this->Adviser_rule_model->view();
        foreach ($data["rules"] as $ruleKey => $rules) {
            $newContent = '';
            $exploded = $this->multiexplode(array("^", "=>"), $rules->rulesContent);
            foreach ($exploded as $key => $nodesNode) {
                $node = $this->Adviser_node_model->viewdetails($nodesNode);
                $newContent = $newContent . '<b>' . $node->nodesContent . '</b> (<i>' . $nodesNode . '</i>)';
                if ($key < count($exploded) - 2) {
                    $newContent = $newContent . '</br><font color="green"><b>+</b></font> ';
                } else if ($key < count($exploded) - 1) {
                    $newContent = $newContent . '<hr style="margin: 0px;"><font color="blue"><b>=></b></font> ';
                }
            }
            $data["rules"][$ruleKey]->rulesContent = $newContent;
        }
        $this->view($this->config->item('admin_folder') . '/adviser_rule', $data);
    }

    function viewdetails($id)
    {
        $data['guestbook'] = $this->Adviser_rule_model->viewdetails($id);
        $this->view($this->config->item('admin_folder') . '/adviser_node/form/' . $id, $data);
    }

    function calculate_result()
    {
        $questions = $this->Adviser_question_model->view();
        $nodes = $this->Adviser_node_model->view();

        $answers = array();
        foreach ($questions as $question) {
            if ($question->$questionType = 'YN') {
                $answers[$question->$questionNode] = $this->input->post($question->$questionNode);
            }
            if ($question->$questionType = 'CF') {
                $answers[$question->$questionNode] = $this->input->post($question->$questionNode);
            }
        }
    }

    function form($id = false)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $data['page_title'] = 'Luật';

        //default values are empty if the customer is new
        $data['rulesId'] = '';
        $data['rulesCF'] = '0.0';
        $data['lefthand'] = $this->Adviser_rule_model->list_lefthand();
        $data['righthand'] = $this->Adviser_rule_model->list_righthand();
        $this->form_validation->set_rules('rulesId', 'Nút', 'trim|max_length[20]');
        $this->form_validation->set_rules('rulesCF', 'Giá Trị CF', 'callback_validateCF');
        $this->form_validation->set_rules('rightclause', 'Nút Vế Phải', 'required');
        $this->form_validation->set_rules('leftclause', 'Nút Vế Trái', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->view($this->config->item('admin_folder') . '/adviser_rule_form', $data);
        } else {
            $save['rulesId'] = $this->input->post('rulesId');
            $save['rulesCF'] = $this->input->post('rulesCF');


            $lefthand = $this->input->post('leftclause');
            $rightclause = $this->input->post('rightclause');
            $ruleContent = '';
            if (count($lefthand) > 0) {
                foreach ($lefthand as $key => $nodesNode) {
                    $ruleContent = $ruleContent . $nodesNode;
                    if ($key < count($lefthand) - 1) {
                        $ruleContent = $ruleContent . '^';
                    }
                }
            }
            $ruleContent = $ruleContent . '=>' . $rightclause;

            $isRulesExist = $this->Adviser_rule_model->get_adviser_by_content($ruleContent);
            if (count($isRulesExist) > 0) {
                $this->session->set_flashdata('message', 'Luật đã tồn tại, không khởi tạo luật mới!');
                redirect($this->config->item('admin_folder') . '/adviser_rule');
            }

            $save['rulesContent'] = $ruleContent;

            $this->Adviser_rule_model->save_adviser_rule($save);

            $this->session->set_flashdata('message', 'Luật đã được lưu!');
            redirect($this->config->item('admin_folder') . '/adviser_rule');
        }
    }

    public function validateCF($str)
    {
        if (!is_numeric($str)) {
            return FALSE;
        }
        return ($str <= 1 && $str >= 0);
    }

    function bulk_delete()
    {
        $orders = $this->input->post('order');

        if ($orders) {
            foreach ($orders as $order) {
                $this->Adviser_rule_model->delete($order);
            }
            $this->session->set_flashdata('message', 'Những luật được chọn đã bị xóa!');
        } else {
            $this->session->set_flashdata('error', 'Bạn chưa chọn luật nào!');
        }
        //redirect as to change the url
        redirect($this->config->item('admin_folder') . '/adviser_rule');
    }
}

