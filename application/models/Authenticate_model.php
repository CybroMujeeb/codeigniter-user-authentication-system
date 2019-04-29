<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class authenticate_model extends CI_Model {

    //inserting data into db ()
    public function user_register($data = array(), $table = null)
    {
        if($table)
        {
            $this->db->insert($table, $data);
            return $this->db->insert_id();
        }

        $db_data = array(
                    'user_email'        => $data['email_address'],
                    'user_fullname'     => $data['full_name'],
                    'user_phone'        => $data['phone_number'],
                    'user_password'     => password_hash($data['password'], PASSWORD_DEFAULT)
                );
       $this->db->insert('registration', $db_data);
       return $this->db->insert_id();
    }

    // function to authenticate the user
    public function auth($params)
    {
        $user_details   = $this->db->select('user_id, user_email, user_fullname, user_phone, user_password, user_reg_time')->where('user_email', $params['email_address'])->get('registration')->row_array();
        if(empty($user_details))
        {
            return array('error' => true, 'message' => 'Unregistered email id');
        }

        //password verification
        if($user_details['user_password'])
        {
            if(password_verify($params['password'], $user_details['user_password']))
            {  
                $user_details['error']              = false;
                return $user_details;
            }

            return array('error' => true, 'message' => 'Password missmatch');
        }

        return array('error' => true, 'message' => 'Uncaugt error occured');
    }

}