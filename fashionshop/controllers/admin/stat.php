<?php

class Stat extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Stat_model');
        $this->load->helper(array('formatting'));
    }

    function get_first_date(){
        $pid = $this->input->post('pro');
        $date = $this->Stat_model->get_first_date_in_order($pid);
        header('Content-Type: application/json');
        echo json_encode(array('year' => date('Y',strtotime($date[0]->ordered_on)),
            'day' => date('d',strtotime($date[0]->ordered_on)),
            'month' => date('m',strtotime($date[0]->ordered_on))
        ));
    }
}