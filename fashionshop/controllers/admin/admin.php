<?php
class Admin extends Admin_Controller
{
    //những biến dưới dây được sử dụng trong quá trình tạo mới, xóa, chỉnh sửa tài khoản quản trị viên
    var $admin_id = false;
    var $current_admin = false;

    //Hàm khởi tạo, kiểm tra phân quyền, load và setting những thứ cần thiết
    function __construct()
    {
        parent::__construct();
        $this->auth->check_access('Admin', true);

        //load the admin language file in
        $this->lang->load('admin');

        $this->current_admin = $this->session->userdata('admin');
    }

    //function index được gọi mặc định khi controller admin được gọi
    function index()
    {
        //set title của trang tự động từ thư viện ngôn ngữ
        $data['page_title'] = lang('admins');
        //Lấy danh sách admins từ model
        $data['admins'] = $this->auth->get_admin_list();
        //trả về view tương ứng của trang index, kèm theo dữ liệu đã được set
        $this->view($this->config->item('admin_folder') . '/admins', $data);
    }

    //function delete được sử dụng để xóa admin theo id
    function delete($id)
    {
        //mặc định, không cho phép người quản trị xóa tài khoản của chính họ
        //nhưng nếu người quản trị chủ động trỏ đến đường dẫn này, function này vẫn sẽ hoạt động

        //kiểm tra tài khoản hiện tại có phải tài khoản đang request xóa hay không
        if ($this->current_admin['id'] == $id) {
            //Set message lỗi vào session
            $this->session->set_flashdata('message', lang('error_self_delete'));
            //redirect về lại trang admin
            redirect($this->config->item('admin_folder') . '/admin');
        }

        //thực hiện thao tác xóa
        $this->auth->delete($id);
        //Set message vào session
        $this->session->set_flashdata('message', lang('message_user_deleted'));
        //redirect về lại trang admin
        redirect($this->config->item('admin_folder') . '/admin');
    }

    //function form được sử dụng để tạo mới hoặc edit tài khoản người quản trị
    function form($id = false)
    {
        //gọi form helper
        $this->load->helper('form');
        //gọi thư viện form validation
        $this->load->library('form_validation');
        //set code html chứa nội dung message lỗi
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        //set title của trang tự động từ thư viện ngôn ngữ
        $data['page_title'] = lang('admin_form');

        //mặc định các giá trị sau là empty, tương ứng với việc tạo mới
        $data['id'] = '';
        $data['firstname'] = '';
        $data['lastname'] = '';
        $data['email'] = '';
        $data['username'] = '';
        $data['access'] = '';

        //nếu có truyền id vào trong function -> chỉnh sửa tài khoản có sẵn
        if ($id) {
            //set giá trị cho biến toàn cục
            $this->admin_id = $id;
            //thực hiện lấy object admin từ model
            $admin = $this->auth->get_admin($id);
            //nếu người quản trị không tồn tại
            if (!$admin) {
                // set nội dung message lỗi
                $this->session->set_flashdata('message', lang('admin_not_found'));
                //chuyển về trang admin
                redirect($this->config->item('admin_folder') . '/admin');
            }
            //set dữ liệu là data lấy từ database
            $data['id'] = $admin->id;
            $data['firstname'] = $admin->firstname;
            $data['lastname'] = $admin->lastname;
            $data['email'] = $admin->email;
            $data['username'] = $admin->username;
            $data['access'] = $admin->access;
        }

        //thiết lập luật cho các item input trên màn hình
        $this->form_validation->set_rules('firstname', 'lang:firstname', 'trim|max_length[32]');
        $this->form_validation->set_rules('lastname', 'lang:lastname', 'trim|max_length[32]');
        $this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|max_length[128]');
        $this->form_validation->set_rules('username', 'lang:username', 'trim|required|max_length[128]|callback_check_username');
        $this->form_validation->set_rules('access', 'lang:access', 'trim|required');

        //nếu người dùng mới, hoặc đã nhập đủ 2 trường password và password confirm
        if ($this->input->post('password') != '' || $this->input->post('confirm') != '' || !$id) {
            //thiết lập luật bổ sung
            $this->form_validation->set_rules('password', 'lang:password', 'required|min_length[6]|sha1');
            $this->form_validation->set_rules('confirm', 'lang:confirm_password', 'required|matches[password]');
        }

        //nếu quá trình validation bị lỗi
        if ($this->form_validation->run() == FALSE) {
            // trả về lại view
            $this->view($this->config->item('admin_folder') . '/admin_form', $data);
        } else {
            // set value cho item dành để save
            $save['id'] = $id;
            $save['firstname'] = $this->input->post('firstname');
            $save['lastname'] = $this->input->post('lastname');
            $save['email'] = $this->input->post('email');
            $save['username'] = $this->input->post('username');
            $save['access'] = $this->input->post('access');

            //nếu có thay đổi password
            if ($this->input->post('password') != '' || !$id) {
                $save['password'] = $this->input->post('password');
            }

            //gọi function save từ model
            $this->auth->save($save);

            //set message
            $this->session->set_flashdata('message', lang('message_user_saved'));

            //trở lại danh sách
            redirect($this->config->item('admin_folder') . '/admin');
        }
    }

    //function check username
    function check_username($str)
    {
        // kiểm tra email người dùng nhập đã tồn tại trong database hay chưa
        $email = $this->auth->check_username($str, $this->admin_id);
        // Nếu đã có
        if ($email) {
            // set message thông báo
            $this->form_validation->set_message('check_username', lang('error_username_taken'));
            // trả về FALSE
            return FALSE;
        } else {
            // trả về TRUE
            return TRUE;
        }
    }
}