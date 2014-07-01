<?php
/**
 * User: Ce No
 * Date: 5/23/14
 * Time: 8:00 PM
 */

class Adviser_Node extends Admin_Controller
{

    // hàm khởi tạo
    function __construct()
    {
        parent::__construct();
        if (!$this->auth->check_access('Advisers') && !$this->auth->check_access('Admin')) {
            redirect($this->config->item('admin_folder') . '/orders');
        }
        // load thư viện validation
        $this->load->library('form_validation');
        // load model
        $this->load->model(array('Adviser_node_model'));
        $this->lang->load('product');
    }

    // function index, khởi tạo trang chính khi sử dụng chức năng quản trị nút
    function index($order_by = "nodesNode", $sort_order = "DESC", $code = 0, $page = 0, $rows = 10)
    {
        $data = array();
        $data['order_by'] = $order_by;
        $data['sort_order'] = $sort_order;
        $data['nodes'] = $this->Adviser_node_model->view(array('order_by' => $order_by, 'sort_order' => $sort_order, 'rows' => $rows, 'page' => $page));
        $data['total'] = $this->Adviser_node_model->view(array('order_by' => $order_by, 'sort_order' => $sort_order), true);

        $this->load->library('pagination');
        $config['base_url'] = site_url($this->config->item('admin_folder') . '/adviser_node/index/' . $order_by . '/' . $sort_order . '/'. $code . '/');
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
        $this->view($this->config->item('admin_folder') . '/adviser_node', $data);
    }

    function form($id = false)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $data['page_title'] = 'Nút';

        $data['nodesNode'] = '';
        $data['nodesContent'] = '';
        $data['questionType'] = '';

        if ($id) {
            $this->question_id = $id;
            $node = $this->Adviser_node_model->viewdetails($id);
            //if the administrator does not exist, redirect them to the admin list with an error
            if (!$node) {
                $this->session->set_flashdata('message', 'Không thể tìm thấy nút yêu cầu!');
                redirect($this->config->item('admin_folder') . '/adviser_node');
            }
            //set values to db values
            $data['nodesNode'] = $node->nodesNode;
            $data['nodesContent'] = $node->nodesContent;
            $data['questionNode'] = $node->questionNode;
            //$data["questions"] = $this->Adviser_question_model->question_answer($id);
        }

        $this->form_validation->set_rules('nodesNode', 'Nút', 'trim|max_length[20]');
        $this->form_validation->set_rules('nodesContent', 'Nội Dung Nút', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->view($this->config->item('admin_folder') . '/adviser_node_form', $data);
        } else {
            $save['nodesNode'] = $this->input->post('nodesNode');
            $save['nodesContent'] = $this->input->post('nodesContent');
            $save['questionNode'] = null;

            $this->Adviser_node_model->save_adviser_node($save);

            $this->session->set_flashdata('message', 'Nút đã được lưu!');
            redirect($this->config->item('admin_folder') . '/adviser_node');
        }
    }

    function bulk_delete()
    {
        $orders = $this->input->post('order');

        if ($orders) {
            foreach ($orders as $order) {
                $this->Adviser_node_model->delete($order);
            }
            $this->session->set_flashdata('message', 'Những nút được chọn đã bị xóa!');
        } else {
            $this->session->set_flashdata('error', 'Bạn chưa chọn nút nào!');
        }
        //redirect as to change the url
        redirect($this->config->item('admin_folder') . '/adviser_node');
    }
}

