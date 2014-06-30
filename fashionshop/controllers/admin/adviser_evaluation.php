<?php
/**
 * User: Ce No
 * Date: 5/23/14
 * Time: 8:00 PM
 */

class Adviser_Evaluation extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->auth->check_access('Advisers') && !$this->auth->check_access('Admin')) {
            redirect($this->config->item('admin_folder') . '/orders');
        }
        $this->load->library('form_validation');
        $this->load->model(array('Adviser_evaluation_model', 'Adviser_node_model'));
    }

    function index()
    {
        $data = array();
        $data["evaluation"] = $this->Adviser_evaluation_model->view();
        foreach ($data["evaluation"] as $evaluation) {
            $nodeArray = array();
            $nodeArray = json_decode($evaluation->evaluationSelected);
            $newContent = '';
            foreach ($nodeArray as $key => $select) {
                $node = $this->Adviser_node_model->viewdetails($select->node);
                if ($node) {
                    $newContent = $newContent . '<b>' . $node->nodesContent . '</b> (<i>' . $select->node . '</i>)[Giá trị:' . $select->cf . ']';
                } else {
                    $newContent = $newContent . '<b><font color="red">CHÚ Ý!<br>Không tìm thấy dữ liệu của nút này! Nút có thể đã bị xóa! (<i>' . $select->node . '</i>)</b></font>';
                }
                if ($key < count($nodeArray) - 1) {
                    $newContent = $newContent . '</br>';
                }
            }
            $evaluation->evaluationSelected = $newContent;
            switch ($evaluation->evaluationRate) {
                case 0:
                    $evaluation->evaluationRate = 'Rất Tệ';
                    break;
                case 0.2:
                    $evaluation->evaluationRate = 'Rất Không Chính Xác';
                    break;
                case 0.4:
                    $evaluation->evaluationRate = 'Không Chính Xác';
                    break;
                case 0.6:
                    $evaluation->evaluationRate = 'Bình Thường';
                    break;
                case 0.8:
                    $evaluation->evaluationRate = 'Chính Xác';
                    break;
                case 1:
                    $evaluation->evaluationRate = 'Rất Chính Xác';
                    break;
            }
            $nodeAdvise = $this->Adviser_node_model->viewdetails($evaluation->evaluationConclusion);
            if ($nodeAdvise) {
                $evaluation->evaluationConclusion = '<b>' . $nodeAdvise->nodesContent . '</b> (<i>' . $nodeAdvise->nodesNode . '</i>)';
            } else {
                $evaluation->evaluationConclusion = '<b><font color="red">CHÚ Ý!<br>Không tìm thấy dữ liệu của nút này! Nút có thể đã bị xóa! (<i>' . $evaluation->evaluationConclusion . '</i>)</b></font>';
            }
        }
        $this->view($this->config->item('admin_folder') . '/adviser_evaluation', $data);
    }

    function bulk_delete()
    {
        $orders = $this->input->post('order');

        if ($orders) {
            foreach ($orders as $order) {
                $this->Adviser_evaluation_model->delete_adviser_evaluation($order);
            }
            $this->session->set_flashdata('message', 'Những đánh giá được chọn đã bị xóa!');
        } else {
            $this->session->set_flashdata('error', 'Bạn chưa chọn đánh giá nào!');
        }
        //redirect as to change the url
        redirect($this->config->item('admin_folder') . '/adviser_evaluation');
    }
}

