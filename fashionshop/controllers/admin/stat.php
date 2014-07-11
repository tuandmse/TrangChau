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
        if(!$date){
            header('Content-Type: application/json');
            echo json_encode(array('status' => 'no result'));
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('year' => date('Y',strtotime($date[0]->ordered_on)),
                'day' => date('d',strtotime($date[0]->ordered_on)),
                'month' => date('m',strtotime($date[0]->ordered_on))
            ));
        }
    }

    function get_stat_for_a_month(){
        $pid = $this->input->post('pro');
        $i_year = $this->input->post('year');
        $i_month = $this->input->post('month');
        $result = $this->Stat_model->get_stat_for_a_month($pid, $i_year, $i_month);
        if($i_month == 0){
            $num_of_day = 0;
        } else {
            $num_of_day = cal_days_in_month(CAL_GREGORIAN, $i_month, $i_year);
        }
        $result_array = [];
        for($i = 1; $i <= $num_of_day; $i++){
            $fla = 0;
            for($j = 0; $j < count($result); $j++){
                if($result[$j]->day == $i){
                    array_push($result_array, $result[$j]->quantity + 0);
                    $fla = 1;
                }
            }
            if($fla == 0){
                array_push($result_array, 0);
            }
        }
        header('Content-Type: application/json');
        echo json_encode($result_array);
    }
}