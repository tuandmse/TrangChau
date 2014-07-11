<?php
/**
 * User: Trang Chau
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

    function index($order_by = "evaluationId", $sort_order = "DESC", $code = 0, $page = 0, $rows = 10)
    {
        $data = array();
        $data['order_by'] = $order_by;
        $data['sort_order'] = $sort_order;
        $data['evaluation'] = $this->Adviser_evaluation_model->view(array('order_by' => $order_by, 'sort_order' => $sort_order, 'rows' => $rows, 'page' => $page));
        $data['total'] = $this->Adviser_evaluation_model->view(array('order_by' => $order_by, 'sort_order' => $sort_order), true);
        $this->load->library('pagination');
        $config['base_url'] = site_url($this->config->item('admin_folder') . '/adviser_evaluation/index/' . $order_by . '/' . $sort_order . '/'. $code . '/');
        $config['total_rows'] = $data['total'];
        $config['per_page'] = $rows;
        $config['uri_segment'] = 7;
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['full_tag_open'] = '<div class="pagination"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $this->pagination->initialize($config);
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

