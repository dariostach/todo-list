<?php
class Tasks extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('tasks_model');
                $this->load->helper('url_helper');
                $this->load->helper('url');
        }

        public function index()
        {
                $data['tasks'] = $this->tasks_model->get_tasks();
                $data['title'] = 'Todo List';

                $this->load->view('templates/header', $data);
                $this->load->view('tasks/index', $data);
                $this->load->view('templates/footer');
        }       
        function delete($id) {
            if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
                $return = array('tipo' => 'ok');
                $this->tasks_model->delete_task($id);                                   
                echo json_encode($return);
            }
        }
        function complete($id) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $return = array('tipo' => 'ok');
                $this->tasks_model->complete_task($id);                                   
                echo json_encode($return);
            }
        }
        function create() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $return = array('tipo' => 'ok');
                $this->tasks_model->set_tasks();
                echo json_encode($return);
            }
        }
}