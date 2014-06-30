<?php
/**
 * User: Ce No
 * Date: 5/23/14
 * Time: 8:00 PM
 */

class Adviser_Cf extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->auth->check_access('Advisers') && !$this->auth->check_access('Admin')) {
            redirect($this->config->item('admin_folder') . '/orders');
        }
        $this->load->library('form_validation');
        $this->load->model(array('Adviser_cf_model'));
    }

    function index()
    {
        $data = array();
        $data["cfs"] = $this->Adviser_cf_model->view();
        $this->view($this->config->item('admin_folder') . '/adviser_cf', $data);
    }

    function form($id = false)
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $data['page_title'] = 'Chỉ Số';

        //default values are empty if the customer is new
        $data['cfId'] = '';
        $data['cfContent'] = '';
        $data['cfValue'] = '';
        $this->form_validation->set_rules('cfId', 'Id', 'trim|max_length[10]');
        $this->form_validation->set_rules('cfValue', 'Giá Trị CF', 'callback_validateCF');
        $this->form_validation->set_rules('cfContent', 'Nội Dung Chỉ Số', 'required');

        if ($id) {
            $this->cfId = $id;
            $cfMetrics = $this->Adviser_cf_model->viewdetails($id);
            if (!$cfMetrics) {
                $this->session->set_flashdata('message', 'Không thể tìm thấy chỉ số yêu cầu!');
                redirect($this->config->item('admin_folder') . '/adviser_cf');
            }
            //set values to db values
            $data['cfId'] = $cfMetrics->cfId;
            $data['cfContent'] = $cfMetrics->cfContent;
            $data['cfValue'] = $cfMetrics->cfValue;
        }

        if ($this->form_validation->run() == FALSE) {
            $this->view($this->config->item('admin_folder') . '/adviser_cf_form', $data);
        } else {
            $save['cfId'] = $this->input->post('cfId');
            $save['cfContent'] = $this->input->post('cfContent');
            $save['cfValue'] = $this->input->post('cfValue');

            $this->Adviser_cf_model->save_adviser_cf($save);

            $this->session->set_flashdata('message', 'Chỉ số đã được lưu!');
            redirect($this->config->item('admin_folder') . '/adviser_cf');
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
                $this->Adviser_cf_model->delete($order);
            }
            $this->session->set_flashdata('message', 'Những chỉ số được chọn đã bị xóa!');
        } else {
            $this->session->set_flashdata('error', 'Bạn chưa chọn chỉ số nào!');
        }
        //redirect as to change the url
        redirect($this->config->item('admin_folder') . '/adviser_cf');
    }
}

