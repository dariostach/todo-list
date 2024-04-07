<?php
class Tasks_model extends CI_Model {
        public $table_name = 'tasks';
        public function __construct()
        {
                $this->load->database();
        }
        public function get_tasks()
        {                
            $this->db->from($this->table_name);
            $this->db->order_by("created_at", "desc");
            $query = $this->db->get();             
            return $query->result_array();
        }
        public function set_tasks()
        {
            $this->load->helper('url');
            $data = array(
                'title' => $this->input->post('title'),
                'deadline' => $this->input->post('deadline'),
                'text' => $this->input->post('text')
            );

            return $this->db->insert($this->table_name, $data);
        }
        public function delete_task($id){
            $this->db->delete($this->table_name, array('id' => $id));
        }
        public function complete_task($id){
            $this->db->set('completed', 1);
            $this->db->where('id', $id);
            $this->db->update($this->table_name);
        }
}