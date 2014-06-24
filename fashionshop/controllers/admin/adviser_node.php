<?php
/**
 * User: Ce No
 * Date: 5/23/14
 * Time: 8:00 PM
 */

class Adviser_Node extends Admin_Controller {

    // hàm khởi tạo
    function __construct()
    {
        parent::__construct();
        if(!$this->auth->check_access('Advisers') && !$this->auth->check_access('Admin'))
        {
            redirect($this->config->item('admin_folder').'/orders');
        }
        // load thư viện validation
        $this->load->library('form_validation');
        // load model
        $this->load->model(array('Adviser_node_model'));
        $this->lang->load('product');
    }

    // function index, khởi tạo trang chính khi sử dụng chức năng quản trị nút
    function index() {
        // khởi tạo biến data và load tất cả các nút có trong database
        $data = array();
        $data["nodes"] = $this->Adviser_node_model->view();
        // trả về view kèm data để hiển thị
        $this->view($this->config->item('admin_folder').'/adviser_node', $data);
    }

    function form($id = false){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $data['page_title']		= 'Nút';

        $data['nodesNode']		= '';
        $data['nodesContent']	= '';
        $data['questionType']	= '';

        if ($id)
        {
            $this->question_id		= $id;
            $node			= $this->Adviser_node_model->viewdetails($id);
            //if the administrator does not exist, redirect them to the admin list with an error
            if (!$node)
            {
                $this->session->set_flashdata('message', 'Không thể tìm thấy nút yêu cầu!');
                redirect($this->config->item('admin_folder').'/adviser_node');
            }
            //set values to db values
            $data['nodesNode']			= $node->nodesNode;
            $data['nodesContent']	= $node->nodesContent;
            $data['questionNode']	= $node->questionNode;
            //$data["questions"] = $this->Adviser_question_model->question_answer($id);
        }

        $this->form_validation->set_rules('nodesNode', 'Nút', 'trim|max_length[20]');
        $this->form_validation->set_rules('nodesContent', 'Nội Dung Nút', 'trim');

        if ($this->form_validation->run() == FALSE)
        {
            $this->view($this->config->item('admin_folder').'/adviser_node_form', $data);
        }
        else
        {
            $save['nodesNode']		= $this->input->post('nodesNode');
            $save['nodesContent']	= $this->input->post('nodesContent');
            $save['questionNode']	= null;

            $this->Adviser_node_model->save_adviser_node($save);

            $this->session->set_flashdata('message', 'Nút đã được lưu!');
            redirect($this->config->item('admin_folder').'/adviser_node');
        }
    }

    function bulk_delete()
    {
        $orders	= $this->input->post('order');

        if($orders)
        {
            foreach($orders as $order)
            {
                $this->Adviser_node_model->delete($order);
            }
            $this->session->set_flashdata('message', 'Những nút được chọn đã bị xóa!');
        }
        else
        {
            $this->session->set_flashdata('error', 'Bạn chưa chọn nút nào!');
        }
        //redirect as to change the url
        redirect($this->config->item('admin_folder').'/adviser_node');
    }
}

