<?php
/**
 * User: Trang Chau
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

    function index($order_by = "cfId", $sort_order = "DESC", $code = 0, $page = 0, $rows = 10)
    {
        $data['order_by'] = $order_by;
        $data['sort_order'] = $sort_order;
        $data['cfs'] = $this->Adviser_cf_model->view(array('order_by' => $order_by, 'sort_order' => $sort_order, 'rows' => $rows, 'page' => $page));
        $data['total'] = $this->Adviser_cf_model->view(array('order_by' => $order_by, 'sort_order' => $sort_order), true);

        $this->load->library('pagination');
        $config['base_url'] = site_url($this->config->item('admin_folder') . '/adviser_cf/index/' . $order_by . '/' . $sort_order . '/' . $code . '/');
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

