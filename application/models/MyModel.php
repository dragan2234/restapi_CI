<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyModel extends CI_Model {
            function __construct() {
        parent::__construct();
        $this->load->helper('json_output');
    }

    var $client_service = "frontend-client";
    var $auth_key       = "fsdprojekat";

    public function check_auth_client(){
        $client_service = $this->input->get_request_header('Client-Service', TRUE);
        $auth_key  = $this->input->get_request_header('Auth-Key', TRUE);
        if($client_service == $this->client_service && $auth_key == $this->auth_key){
            return true;
        } else {
            return json_output(401,array('status' => 401,'message' => 'Unauthorized.'));
        }
    }

    public function login($username,$password)
    {
        $q  = $this->db->select('password,id')->from('users')->where('username',$username)->get()->row();
        if($q == ""){
            return array('status' => 204,'message' => 'Username not found.');
        } else {
            $id              = $q->id;
            if ($password==$q->password) {
               $token = substr( rand(), 0, 7);
               $this->db->insert('users_authentication',array('users_id' => $id,'token' => $token));
                  return array('status' => 200,'message' => 'Successfully login.','id' => $id, 'token' => $token);
            } else {
               return array('status' => 204,'message' => 'Wrong password.');
            }
        }
    }

    public function logout()
    {
        $users_id  = $this->input->get_request_header('User-ID', TRUE);
        $token     = $this->input->get_request_header('Authorization', TRUE);
        $this->db->where('users_id',$users_id)->where('token',$token)->delete('users_authentication');
        return array('status' => 200,'message' => 'Successfully logout.');
    }

    public function auth()
    {
        $users_id  = $this->input->get_request_header('User-ID', TRUE);
        $token     = $this->input->get_request_header('Authorization', TRUE);
        $q  = $this->db->select()->from('users_authentication')->where('users_id',$users_id)->where('token',$token)->get()->row();
        if($q == ""){
            return json_output(401,array('status' => 401,'message' => 'Unauthorized.'));
        } else {
                return array('status' => 200,'message' => 'Authorized.');

        }
    }

    public function register($data) {
        $this->db->insert('users', $data);
        return array('status' => 201,'message' => 'Successfull registration.');

    }

    public function book_all_data()
    {
        return $this->db->select('id,naziv,autor,godina,jezik,originalni_jezik')->from('knjige')->order_by('id','desc')->get()->result();
    }


    public function book_create_data($data)
    {
        $this->db->insert('knjige',$data);
        return array('status' => 201,'message' => 'Data has been created.');
    }

    public function book_update_data($id,$data)
    {
        $this->db->where('id',$id)->update('knjige',$data);
        return array('status' => 200,'message' => 'Data has been updated.');
    }

    public function book_delete_data($id)
    {
        $this->db->where('id',$id)->delete('knjige');
        return array('status' => 200,'message' => 'Data has been deleted.');
    }

    public function book_search_data(){
        $search = $this->input->get('search');
        return $this->db->select('id,naziv,autor,godina,jezik,originalni_jezik')->from('knjige')->like('naziv',$search)->order_by('id','desc')->get()->result();
    }
}
