<?php
/**
 * User: Ce No
 * Date: 5/23/14
 * Time: 8:00 PM
 */

class Guestbook extends Admin_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model(array('Guestbook_model'));
        $query =
            "CREATE TABLE IF NOT EXISTS " . $this->db->dbprefix('guestbook') . " (
            guestbook_id int(11) NOT NULL auto_increment,
            name varchar(255) CHARACTER SET utf8 NOT NULL,
            email varchar(255) CHARACTER SET utf8 NOT NULL,
            title varchar(255) CHARACTER SET utf8 NOT NULL,
            datetime datetime NOT NULL,
            content text CHARACTER SET utf8 NOT NULL,
            PRIMARY KEY (guestbook_id)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10;";
        $this->db->query($query);
    }

    function index() {
        $data = array();
        $data["entries"] = $this->Guestbook_model->view();
        $this->view($this->config->item('admin_folder').'/guestbook', $data);
    }

    function viewdetails($id){
        $data['guestbook'] = $this->Guestbook_model->viewdetails($id);
        $this->view($this->config->item('admin_folder').'/guestbook_details', $data);
    }

    function send_response($guestbook_id='')
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'trangchau.fashionshop',
            'smtp_pass' => 'VIETHOAKHONGDAU',
            'mailtype' => 'html',
            'charset' => 'utf-8'
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");

        $this->email->from($this->config->item('email'), $this->config->item('company_name'));
        $this->email->to($this->input->post('recipient'));

        $this->email->subject($this->input->post('subject'));
        $this->email->message(html_entity_decode($this->input->post('content')));

        $this->email->send();

        $this->session->set_flashdata('message', 'Phản hồi đã được gửi đến: '.$this->input->post('recipient'));
        redirect($this->config->item('admin_folder').'/guestbook/viewdetails/'.$guestbook_id);
    }

    function bulk_delete()
    {
        $orders	= $this->input->post('order');

        if($orders)
        {
            foreach($orders as $order)
            {
                $this->Guestbook_model->delete($order);
            }
            $this->session->set_flashdata('message', 'Những gợi ý được chọn đã bị xóa!');
        }
        else
        {
            $this->session->set_flashdata('error', 'Bạn chưa chọn gợi ý nào!');
        }
        //redirect as to change the url
        redirect($this->config->item('admin_folder').'/guestbook');
    }
}

