<?php
/**
 * User: Ce No
 * Date: 5/23/14
 * Time: 8:00 PM
 */

class Adviser_Question extends Admin_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model(array('Adviser_question_model'));
    }

    function index() {
        $data = array();
        $data["questions"] = $this->Adviser_question_model->view();
        $this->view($this->config->item('admin_folder').'/adviser_question', $data);
    }

    function viewdetails($id){
        $data['guestbook'] = $this->Adviser_question_model->viewdetails($id);
        $this->view($this->config->item('admin_folder').'/adviser_question/form/'.$id, $data);
    }

    function form($id = false){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $data['page_title']		= 'Câu Hỏi';

        //default values are empty if the customer is new
        $data['questionNode']		= '';
        $data['questionContent']	= '';
        $data['questionType']	= '';

        if ($id)
        {
            $this->question_id		= $id;
            $question			= $this->Adviser_question_model->viewdetails($id);
            //if the administrator does not exist, redirect them to the admin list with an error
            if (!$question)
            {
                $this->session->set_flashdata('message', 'Không thể tìm thấy câu hỏi yêu cầu!');
                redirect($this->config->item('admin_folder').'/adviser_question');
            }
            //set values to db values
            $data['questionNode']			= $question->questionNode;
            $data['questionContent']	= $question->questionContent;
            $data['questionType']	= $question->questionType;
            $data["questions"] = $this->Adviser_question_model->question_answer($id);
        }

        $this->form_validation->set_rules('questionNode', 'Nút', 'trim|max_length[20]');
        $this->form_validation->set_rules('questionContent', 'Nội Dung', 'trim');
        //$this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|max_length[128]');
        //$this->form_validation->set_rules('username', 'lang:username', 'trim|required|max_length[128]|callback_check_username');
        $this->form_validation->set_rules('questionType', 'Loại Câu Hỏi', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->view($this->config->item('admin_folder').'/adviser_question_form', $data);
        }
        else
        {
            $save['questionNode']		= $this->input->post('questionNode');
            $save['questionContent']	= $this->input->post('questionContent');
            $save['questionType']	= $this->input->post('questionType');

            $questionNode = $this->Adviser_question_model->save_adviser_question($save);
            $nodesNodes = $this->input->post('nodesNode');
            $nodesContents = $this->input->post('nodesContent');

            if(count($nodesContents) >0){
                foreach( $nodesContents as $key=>$nodesContent){
                    if($nodesContent!='') {
                        $saveNode['nodesNode'] = $nodesNodes[$key];
                        $saveNode['nodesContent'] = $nodesContent;
                        $saveNode['questionNode'] = $questionNode;
                        $this->Adviser_question_model->save_adviser_question_answer($saveNode);
                    }
                }
            }
            $this->session->set_flashdata('message', 'Câu hỏi đã được lưu!');
            redirect($this->config->item('admin_folder').'/adviser_question');
        }
    }

    function bulk_delete()
    {
        $orders	= $this->input->post('order');

        if($orders)
        {
            foreach($orders as $order)
            {
                $this->Adviser_question_model->delete($order);
            }
            $this->session->set_flashdata('message', 'Những gợi ý được chọn đã bị xóa!');
        }
        else
        {
            $this->session->set_flashdata('error', 'Bạn chưa chọn gợi ý nào!');
        }
        //redirect as to change the url
        redirect($this->config->item('admin_folder').'/adviser_question');
    }
}

