<?php


class Adviser_eval extends Front_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model(array(
            'Adviser_model', 'Adviser_rule_model', 'Adviser_node_model', 'Adviser_cf_model', 'Adviser_evaluation_model'));


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


        if ($this->input->post("submitEval")) {


            $save["evaluationSelected"] = $this->input->post("selected");
            $save["evaluationConclusion"] = $this->input->post("conclusion");
            $save["evaluationRate"] = $this->input->post("eval");
            $this->Adviser_evaluation_model->save_adviser_evaluation($save);


        }


        $this->view("call_adviser.php", $data);
    }
}
