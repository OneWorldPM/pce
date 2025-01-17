<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->common->set_timezone();
        $this->load->model('user/m_login', 'objlogin');
        $this->load->model('user/m_sessions', 'objsessions');
    }

    public function index() {
        $this->load->view('header');
        $this->load->view('login');
        $this->load->view('footer');
    }

    public function authentication() {
        $username = $this->input->post('email');
        $password = $this->input->post('password');

        if (strlen(trim(preg_replace('/\xb2\xa0/', '', $username))) == 0 || strlen(trim(preg_replace('/\xb2\xa0/', '', $password))) == 0) {
            $this->session->set_flashdata('msg', '<div class="col-md-12 text-red" style="padding: 0 0 10px 0;">Please enter Username or Password</div><br>');
            redirect('login');
        } else {
            $arr = array(
                'email' => $username,
                'password' => base64_encode($password)
            );
            $data = $this->objlogin->user_login($username,base64_encode($password));
            if ($data) {
                $token = $this->objlogin->update_user_token($data['cust_id']);
                $session = array(
                    'cid' => $data['cust_id'],
                    'cname' => $data['first_name'],
                    'fullname' => $data['first_name'] . ' ' . $data['last_name'],
                    'email' => $data['email'],
                    'token' => $token,
                    'userType' => 'user'
                );
                $this->session->set_userdata($session);
                redirect('sessions');
            } else {
                $this->session->set_flashdata('msg', '<div class="col-md-12 text-red" style="padding: 0 0 10px 0;">Username or Password is Wrong.</div><br>');
                redirect('login');
            }
        }
    }

    function register_login($cust_id) {
        $data = $this->objlogin->register_login($cust_id);
        if ($data) {
            $token = $this->objlogin->update_user_token($data['cust_id']);
            $session = array(
                'cid' => $data['cust_id'],
                'cname' => $data['first_name'],
                'fullname' => $data['first_name'] . ' ' . $data['last_name'],
                'email' => $data['email'],
                'token' => $token,
                'userType' => 'user'
            );
            $this->session->set_userdata($session);
            redirect('home');
        } else {
            redirect('login');
        }
    }

    function logout() {
        $this->session->unset_userdata('cid');
        $this->session->unset_userdata('cname');
        $this->session->unset_userdata('fullname');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('token');
        $this->session->unset_userdata('userType');
        header('location:' . base_url() . 'login');
    }

    function cco_authentication() {
        $token = $this->input->get('token');
        $response_array = json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $token)[1]))));

        if (isset($response_array) && !empty($response_array)) {
            $or_where = '(email = "' . $response_array->identity->email . '")';
            $this->db->where($or_where);
            $customer = $this->db->get('customer_master');
            if ($customer->num_rows() > 0) {
                $user_details = $customer->row();
                $set_update_array = array(
                    'first_name' => $response_array->identity->name,
                    'last_name' => $user_details->last_name,
                    'email' => $response_array->identity->email,
                    'specialty' => $user_details->specialty,
                    'degree' => $user_details->degree,
                    'country' => $user_details->country,
                    'zipcode' => $user_details->zipcode,
                    'identifier_id' => $response_array->identity->identifier,
                    'customer_session' => $response_array->session,
                    'iat' => $response_array->iat,
                    'aud' => json_encode($response_array->aud),
                    'exp' => $response_array->exp,
                    'jti' => $response_array->jti
                );
                $this->db->update("customer_master", $set_update_array, array("cust_id" => $user_details->cust_id));
                $token = $this->objlogin->update_user_token($user_details->cust_id);
                $session = array(
                    'cid' => $user_details->cust_id,
                    'cname' => $user_details->first_name,
                    'fullname' => $user_details->first_name . " " . $user_details->last_name,
                    'email' => $user_details->email,
                    'token' => $token,
                    'userType' => 'user'
                );
                $this->session->set_userdata($session);
                $sessions = $this->db->get_where('sessions', array('sessions_id' => $response_array->session));
                if ($sessions->num_rows() > 0) {
                    $where_to = $this->objsessions->findNextOpenSession($response_array->session);
                    if ($where_to)
                        redirect('sessions/attend/' . $where_to);
                    else
                        redirect('sessions');
                } else {
                    redirect('sessions');
                }
            } else {
                $this->db->order_by("cust_id", "desc");
                $row_data = $this->db->get("customer_master")->row();
                if (!empty($row_data)) {
                    $reg_id = $row_data->cust_id;
                    $register_id = date("Y") . '-20' . $reg_id;
                } else {
                    $register_id = date("Y") . '-200';
                }
                $set = array(
                    "register_id" => $register_id,
                    'first_name' => $response_array->identity->name,
                    'last_name' => "",
                    'email' => $response_array->identity->email,
                    'password' => base64_encode(123),
                    'specialty' => "",
                    'degree' => "",
                    'country' => "",
                    'zipcode' => "",
                    'identifier_id' => $response_array->identity->identifier,
                    'customer_session' => $response_array->session,
                    'iat' => $response_array->iat,
                    'exp' => $response_array->exp,
                    'aud' => json_encode($response_array->aud),
                    'jti' => $response_array->jti,
                    'address' => "",
                    'city' => "",
                    'state' => "",
                    'register_date' => date("Y-m-d h:i")
                );
                $this->db->insert("customer_master", $set);
                $cust_id = $this->db->insert_id();
                $user_details = $this->db->get_where("customer_master", array("cust_id" => $cust_id))->row();
                if (!empty($user_details)) {
                    $token = $this->objlogin->update_user_token($user_details->cust_id);
                    $session = array(
                        'cid' => $user_details->cust_id,
                        'cname' => $user_details->first_name,
                        'fullname' => $user_details->first_name . " " . $user_details->last_name,
                        'email' => $user_details->email,
                        'token' => $token,
                        'userType' => 'user'
                    );
                    $this->session->set_userdata($session);
                    $sessions = $this->db->get_where('sessions', array('sessions_id' => $response_array->session));
                    if ($sessions->num_rows() > 0) {
                        $where_to = $this->objsessions->findNextOpenSession($response_array->session);
                        if ($where_to)
                            redirect('sessions/attend/' . $where_to);
                        else
                            redirect('sessions');
                    } else {
                        redirect('sessions');
                    }
                }
            }
        }
    }

}
