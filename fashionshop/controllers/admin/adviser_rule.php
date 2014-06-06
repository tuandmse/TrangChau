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

    function index()
    {
        $data = array();
        $data["rules"] = $this->Adviser_rule_model->view();
        foreach ($data["rules"] as $ruleKey => $rules) {
            $newContent = '';
            $exploded = $this->multiexplode(array("^", "=>"), $rules->rulesContent);
            foreach ($exploded as $key => $nodesNode) {
                $node = $this->Adviser_node_model->viewdetails($nodesNode);
                $newContent = $newContent . '<b>'.$node->nodesContent . '</b> (<i>' . $nodesNode . '</i>)';
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
            $save['rulesContent'] = $ruleContent;

            $this->Adviser_rule_model->save_adviser_rule($save);

            $this->session->set_flashdata('message', 'Luật đã được lưu!');
            redirect($this->config->item('admin_folder') . '/adviser_rule');
        }
    }

    public function validateCF($str)
    {
        if ( ! is_numeric($str))
        {
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

