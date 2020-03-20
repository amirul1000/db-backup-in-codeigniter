<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Author: Amirul Momenin
 * Description: Login model class
 */
class Login_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function validate()
    {
        // grab user input
        $email = $this->security->xss_clean(trim($this->input->post('email')));
        $password = $this->security->xss_clean(md5(trim($this->input->post('password'))));
		$digit_code = trim($this->input->post('digit_code'));

        // Prep the query
        $this->db->where('email', $email);
        $this->db->where('password', $password);
		$this->db->where('digit_code', $digit_code);

        // Run the query
        $result = $this->db->get('users')->result_array();
		
        // Let's check if there are any results
        if (count($result) == 1) {
            // If there is a user, then create session data
            $data = array(
                'id' => $result[0]['id'],
                'email' => $result[0]['email'],
                'first_name' => $result[0]['first_name'],
                'last_name' => $result[0]['last_name'],
				'user_type' => $result[0]['user_type'],
                'file_picture' => $result[0]['file_picture'],
                'validated' => true
            );
            $this->session->set_userdata($data);
            return true;
        }
        // If the previous process did not validate
        // then return false.
        return false;
    }
}
?>