<?php

class M_sessions extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function addBriefcase() {
        $post = $this->input->post();
        $insert_array = array(
            'cust_id' => $this->session->userdata("aid"),
            'sessions_id' => $post['sessions_id'],
            'note' => $post['briefcase'],
            'reg_briefcase_date' => date("Y-m-d")
        );
        $result_data = $this->db->get_where("sessions_cust_briefcase", array("cust_id" => $this->session->userdata("aid"), 'sessions_id' => $post['sessions_id']))->row();
        if (empty($result_data)) {
            $this->db->insert("sessions_cust_briefcase", $insert_array);
        } else {
            $this->db->update("sessions_cust_briefcase", $insert_array, array("sessions_cust_briefcase_id" => $result_data->sessions_cust_briefcase_id));
        }
        return TRUE;
    }

    function getSessionsAll() {
        $this->db->select('s.*');
        $this->db->from('sessions s');
		 ($this->session->userdata('start_date') != "") ? $where['DATE(s.sessions_date) >='] = date('Y-m-d', strtotime($this->session->userdata('start_date'))) : '';
        ($this->session->userdata('end_date') != "") ? $where['DATE(s.sessions_date) <='] = date('Y-m-d', strtotime($this->session->userdata('end_date'))) : '';
        if (!empty($where)) {
            $this->db->where($where);
        }
        else{
            $where['DATE(sessions_date) >='] = date('Y-m-d', strtotime("-1 day"));
            $this->db->where($where);
        }
        $this->db->order_by("s.sessions_date", "asc");
        $this->db->order_by("s.time_slot", "asc");
        $sessions = $this->db->get();
        if ($sessions->num_rows() > 0) {
            $return_array = array();
            foreach ($sessions->result() as $val) {
                $val->presenter = $this->common->get_presenter($val->presenter_id, $val->sessions_id);
                $val->moderators = $this->getModerators($val->sessions_id);
                $val->groupchatPresenter= $this->getGroupChatDetailsPresenter($val->sessions_id);
                $val->getChatAll= $this->getChatAll($val->sessions_id);
                $val->check_send_json_exist= $this->check_send_json_exist($val->sessions_id);
                $val->get_stream_name =  $this->get_stream_name($val->embed_html_code);

                $return_array[] = $val;
            }
            return $return_array;
        } else {
            return '';
        }
    }
  
    function getSessionsAllDesc() {
        $this->db->select('s.*');
        $this->db->from('sessions s');
        $this->db->where("(sessions_date < now())");
        $this->db->order_by("s.sessions_date", "desc");
        $this->db->order_by("s.time_slot", "desc");
        $sessions = $this->db->get();
        if ($sessions->num_rows() > 0) {
            $return_array = array();
            foreach ($sessions->result() as $val) {
                $val->presenter = $this->common->get_presenter($val->presenter_id, $val->sessions_id);
                $val->moderators = $this->getModerators($val->sessions_id);

                $return_array[] = $val;
            }
            return $return_array;
        } else {
            return '';
        }
    }

    function getArchivedSessions() {
        $this->db->select('s.*');
        $this->db->from('sessions s');
		 ($this->session->userdata('start_date') != "") ? $where['DATE(s.sessions_date) >='] = date('Y-m-d', strtotime($this->session->userdata('start_date'))) : '';
        ($this->session->userdata('end_date') != "") ? $where['DATE(s.sessions_date) <='] = date('Y-m-d', strtotime($this->session->userdata('end_date'))) : '';
        if (!empty($where)) {
            $this->db->where($where);
        }
        else{
            $where['DATE(sessions_date) <='] = date('Y-m-d', strtotime("-1 day"));
            $this->db->where($where);
            $this->db->or_where('s.sessions_id=',25);
        }
        $this->db->order_by("s.sessions_date", "desc");
        $this->db->order_by("s.time_slot", "desc");
        $sessions = $this->db->get();
        if ($sessions->num_rows() > 0) {
            $return_array = array();
            foreach ($sessions->result() as $val) {
                $val->presenter = $this->common->get_presenter($val->presenter_id, $val->sessions_id);
                $val->moderators = $this->getModerators($val->sessions_id);
                $val->groupchatPresenter= $this->getGroupChatDetailsPresenter($val->sessions_id);
                $val->getChatAll= $this->getChatAll($val->sessions_id);
                $val->check_send_json_exist= $this->check_send_json_exist($val->sessions_id);
                $val->get_stream_name =  $this->get_stream_name($val->embed_html_code);

                $return_array[] = $val;
            }
            return $return_array;
        } else {
            return '';
        }
    }

    function getAllSessions() {
        $this->db->select('*');
        $this->db->from('sessions');
        $sessions = $this->db->get();
        if ($sessions->num_rows() > 0) {
            return $sessions->result_array();
        } else {
            return array();
        }
    }
	
	function getSessionsFilter() {
        $this->db->select('*');
        $this->db->from('sessions s');
        $post = $this->input->post();
        if (isset($post['btn_today'])){
            if ($post['btn_today']){
                 $session_filter = array(
                     'start_date' => date('Y-m-d'),
                     'end_date' => date('Y-m-d')
                 );
                 $this->session->set_userdata($session_filter);
                $this->session->set_userdata('session_viewing','Today');
                 ($post['session_type'] != "") ? $where['s.sessions_type_id ='] = trim($post['session_type']) : '';
                 ($post['btn_today'] != "") ? $where['DATE(s.sessions_date) >='] = date('Y-m-d') : '';
                 ($post['btn_today'] != "") ? $where['DATE(s.sessions_date) <='] = date('Y-m-d') : '';
                 if (!empty($where)) {
                     $this->db->where($where);
                 }
                 $this->db->order_by("s.sessions_date", "asc");
                 $this->db->order_by("s.time_slot", "asc");
                 $sessions = $this->db->get();
                 if ($sessions->num_rows() > 0) {
                     $return_array = array();
                     foreach ($sessions->result() as $val) {
                          $val->presenter = $this->common->get_presenter($val->presenter_id, $val->sessions_id);
                          $val->moderators = $this->getModerators($val->sessions_id);
                          $val->check_send_json_exist= $this->check_send_json_exist($val->sessions_id);
                         $return_array[] = $val;
                     }
                     return $return_array;
                 } else {
                     return '';
                 }
             }
         }
         else if (isset($post['btn_tomorrow'])){
             $tomorrow = date("Y-m-d", strtotime("+1 day"));
            if ($post['btn_tomorrow']){
                 $session_filter = array(
                     'start_date' => date('Y-m-d', strtotime("+1 day")),
                     'end_date' => date('Y-m-d', strtotime("+1 day"))
                 );
                 $this->session->set_userdata($session_filter);
                $this->session->set_userdata('session_viewing','Tomorrow');
                 ($post['session_type'] != "") ? $where['s.sessions_type_id ='] = trim($post['session_type']) : '';
                 ($post['btn_tomorrow'] != "") ? $where['DATE(s.sessions_date) >='] = date('Y-m-d', strtotime("+1 day")) : '';
                 ($post['btn_tomorrow'] != "") ? $where['DATE(s.sessions_date) <='] = date('Y-m-d', strtotime("+1 day")) : '';
                 if (!empty($where)) {
                     $this->db->where($where);
                 }
                 $this->db->order_by("s.sessions_date", "asc");
                 $this->db->order_by("s.time_slot", "asc");
                 $sessions = $this->db->get();
                 if ($sessions->num_rows() > 0) {
                     $return_array = array();
                     foreach ($sessions->result() as $val) {
                          $val->presenter = $this->common->get_presenter($val->presenter_id, $val->sessions_id);
                          $val->moderators = $this->getModerators($val->sessions_id);
                          $val->check_send_json_exist= $this->check_send_json_exist($val->sessions_id);
                         $return_array[] = $val;
                     }
                     return $return_array;
                 } else {
                     return '';
                 }
                 
             }
             
         }
         else {
             $session_filter = array(
                 'start_date' => date('Y-m-d', strtotime($post['start_date'])),
                 'end_date' => date('Y-m-d', strtotime($post['end_date']))
             );
        
        $session_filter = array(
            'start_date' => date('Y-m-d', strtotime($post['start_date'])),
            'end_date' => date('Y-m-d', strtotime($post['end_date']))
        );
        $this->session->set_userdata($session_filter);
		
        ($post['session_type'] != "") ? $where['s.sessions_type_id ='] = trim($post['session_type']) : '';

        ($post['start_date'] != "") ? $where['DATE(s.sessions_date) >='] = date('Y-m-d', strtotime($post['start_date'])) : '';

        ($post['end_date'] != "") ? $where['DATE(s.sessions_date) <='] = date('Y-m-d', strtotime($post['end_date'])) : '';

        if (!empty($where)) {
            $this->db->where($where);
        }

        $this->db->order_by("s.sessions_date", "asc");
        $this->db->order_by("s.time_slot", "asc");
        $sessions = $this->db->get();
        if ($sessions->num_rows() > 0) {
            $return_array = array();
            foreach ($sessions->result() as $val) {
                 $val->presenter = $this->common->get_presenter($val->presenter_id, $val->sessions_id);
                 $val->moderators = $this->getModerators($val->sessions_id);
                 $val->check_send_json_exist= $this->check_send_json_exist($val->sessions_id);

                $return_array[] = $val;
            }
            //echo "<pre>"; print_r($return_array);exit("</pre>");
            return $return_array;
        } else {
            return '';
        }
    }
    }

    function getSession_Unique_Identifier_ID() {
        $this->db->order_by("sessions_id", "desc");
        $row_data = $this->db->get("sessions")->row();
        return $row_data->sessions_id + 1;
    }

    function getPresenterDetails() {
        $this->db->select('*');
        $this->db->from('presenter');
        $this->db->order_by('first_name', 'asc');
        $this->db->order_by('last_name', 'asc');
        $presenter = $this->db->get();
        if ($presenter->num_rows() > 0) {
            return $presenter->result();
        } else {
            return '';
        }
    }

    function edit_sessions($sessions_id) {
        $this->db->select('*');
        $this->db->from('sessions');
        $this->db->where("sessions_id", $sessions_id);
        $sessions = $this->db->get();
        if ($sessions->num_rows() > 0) {
            $result_sessions = $sessions->row();
            $result_sessions->sessions_presenter = $this->common->get_session_presenter($sessions_id);
            return $result_sessions;
        } else {
            return '';
        }
    }

    function createSessions() {
        $post = $this->input->post();


        $session_right_bar = "";
        if (isset($post["session_right_bar"])) {
            $session_right_bar = implode(",", $post["session_right_bar"]);
        }

        if (!empty($post['sessions_type'])) {
            $sessions_type_id = implode(",", $post['sessions_type']);
        } else {
            $sessions_type_id = "";
        }
        if (!empty($post['sessions_tracks'])) {
            $sessions_tracks_id = implode(",", $post['sessions_tracks']);
        } else {
            $sessions_tracks_id = "";
        }
		
		if (!empty($post['moderator_id'])) {
            $moderator_id = implode(",", $post['moderator_id']);
        } else {
            $moderator_id = "";
        }
        if (!empty($post['select_presenter_id'])) {
            $presenter_id = implode(",", $post['select_presenter_id']);
        } else {
            $presenter_id = "";
        }

        if(isset($post['one_time_embed_html_code']) && !empty(trim($post['one_time_embed_html_code']))){
            $embed_html_code=(trim($post['one_time_embed_html_code']));
        }else{
            $embed_html_code=(trim($post['embed_html_code']));
        }

        $set = array(
            'presenter_id' => $presenter_id,
			'moderator_id' => $moderator_id,
            'session_title' => trim($post['session_title']),
            'sessions_description' => trim($post['sessions_description']),
            'landing_page_text' => trim($post['landing_page_text']),
            'cco_envent_id' => trim($post['cco_envent_id']),
            'sessions_date' => date("Y-m-d", strtotime($post['sessions_date'])),
            'time_slot' => date("H:i", strtotime($post['time_slot'])),
            'end_time' => date("H:i", strtotime($post['end_time'])),
             'zoom_link' => trim($post['zoom_link']),
             'zoom_number' => trim($post['zoom_number']),
            'zoom_password' => trim($post['zoom_password']),
            'embed_html_code' => $embed_html_code,
            'embed_html_code_presenter' => trim($post['embed_html_code_presenter']),
            'sessions_type_id' => $sessions_type_id,
            'sessions_tracks_id' => $sessions_tracks_id,
            'sessions_type_status' => trim($post['sessions_type_status']),
			'attendee_view_links_status' => (isset($post['attendee_view_links_status'])) ? $post['attendee_view_links_status'] : 1,
            'url_link' => trim($post['url_link']),
            'link_text' => trim($post['link_text']),
            "reg_date" => date("Y-m-d h:i"),
            'right_bar' => $session_right_bar,
            'sponsor_type' => $post['sponsor_type'],
            'sessions_logo_width' => $post['sessions_logo_width'],
            'sessions_logo_height' => $post['sessions_logo_height'],
            'theme_color' => $post['theme_color'],
            'ppt_uploaded' => (isset($post['ppt_uploaded'])) ? $post['ppt_uploaded'] : 0,
            'ppt_link_shared' => (isset($post['ppt_link_shared'])) ? $post['ppt_link_shared'] : 0,
            'session_notes'=>$post['session_notes'],
            'session_end_message'=>$post['session_end_message'],
            'end_image_height'=>$post['end_image_height'],
            'end_image_width'=>$post['end_image_width'],
            'subsequent_session_1'=>(trim($post['subsequent_session_1']) == 'null')?null:trim($post['subsequent_session_1']),
            'subsequent_session_2'=>(trim($post['subsequent_session_2']) == 'null')?null:trim($post['subsequent_session_2']),
            'subsequent_session_popup_text'=>trim($post['subsequent_session_popup_text'])
            
        );
        $this->db->insert("sessions", $set);
        $sessions_id = $this->db->insert_id();
        if ($sessions_id > 0) {



            if ($_FILES['sessions_logo']['name'] != "") {

                $this->load->library('upload');
                $this->upload->initialize($this->set_upload_logo_options());
                $this->upload->do_upload('sessions_logo');
                $file_upload_name = $this->upload->data();
                $this->db->update('sessions', array('sessions_logo' => $file_upload_name['file_name']), array('sessions_id' => $sessions_id));
            }

            if ($_FILES['sessions_addnl_logo']['name'] != "") {

                $this->load->library('upload');
                $this->upload->initialize($this->set_upload_logo_options());
                $this->upload->do_upload('sessions_addnl_logo');
                $file_upload_name = $this->upload->data();
                $this->db->update('sessions', array('sessions_addnl_logo' => $file_upload_name['file_name']), array('sessions_id' => $sessions_id));
            }


            if ($_FILES['sessions_photo']['name'] != "") {
                $_FILES['sessions_photo']['name'] = $_FILES['sessions_photo']['name'];
                $_FILES['sessions_photo']['type'] = $_FILES['sessions_photo']['type'];
                $_FILES['sessions_photo']['tmp_name'] = $_FILES['sessions_photo']['tmp_name'];
                $_FILES['sessions_photo']['error'] = $_FILES['sessions_photo']['error'];
                $_FILES['sessions_photo']['size'] = $_FILES['sessions_photo']['size'];
                $this->load->library('upload');
                $this->upload->initialize($this->set_upload_options());
                $this->upload->do_upload('sessions_photo');
                $file_upload_name = $this->upload->data();
                $this->db->update('sessions', array('sessions_photo' => $file_upload_name['file_name']), array('sessions_id' => $sessions_id));
            }

            if ($_FILES['session_end_image']['name'] != "") {

                $this->load->library('upload');
                $this->upload->initialize($this->set_upload_session_end_image());
                $this->upload->do_upload('session_end_image');
                $file_upload_name = $this->upload->data();
                $this->db->update('sessions', array('session_end_image' => $file_upload_name['file_name']), array('sessions_id' => $sessions_id));
            }

            if (isset($post['select_presenter_id']) && !empty($post['select_presenter_id'])) {
                $array_size_limit = sizeof($post['select_presenter_id']);
                $file_upload_name = array();
                $files = $_FILES;
                $this->load->library('upload');
                for ($i = 0; $i < $array_size_limit; $i++) {
                    $set_array = array(
                        'sessions_id' => $sessions_id,
                        'order_index_no' => $post['order_no'][$i],
                        'select_presenter_id' => $post['select_presenter_id'][$i],
                        'presenter_title' => $post['presenter_title'][$i],
                        'presenter_time_slot' => $post['presenter_time_slot'][$i],
                        'presenter_resource_link' => $post['presenter_resource_link'][$i],
                        'upload_published_name' => $post['upload_published_name'][$i],
                        'link_published_name' => $post['link_published_name'][$i]
                    );
                    $this->db->insert("sessions_add_presenter", $set_array);
                    $sessions_add_presenter_id = $this->db->insert_id();
                    if ($sessions_add_presenter_id > 0) {
                        if ($_FILES['presenter_resource']['name'][$i] != "") {
                            $_FILES['presenter_resource']['name'] = $files['presenter_resource']['name'][$i];
                            $_FILES['presenter_resource']['type'] = $files['presenter_resource']['type'][$i];
                            $_FILES['presenter_resource']['tmp_name'] = $files['presenter_resource']['tmp_name'][$i];
                            $_FILES['presenter_resource']['error'] = $files['presenter_resource']['error'][$i];
                            $_FILES['presenter_resource']['size'] = $files['presenter_resource']['size'][$i];
                            $this->upload->initialize($this->set_upload_presenter_resource());
                            $this->upload->do_upload('presenter_resource');
                            $file_upload_name = $this->upload->data();
                            $this->db->update('sessions_add_presenter', array('presenter_resource' => $file_upload_name['file_name']), array('sessions_add_presenter_id' => $sessions_add_presenter_id));
                        }
                    }
                }
            }
            return "1";
        } else {
            return "2";
        }
    }

    function set_upload_presenter_resource() {
        $this->load->helper('string');
        $randname = random_string('numeric', '8');
        $config = array();
        $config['upload_path'] = './uploads/presenter_resource/';
        $config['allowed_types'] = '*';
        $config['overwrite'] = FALSE;
        $config['file_name'] = "presenter_resource_" . $randname;
        return $config;
    }

    function set_upload_options() {
        $this->load->helper('string');
        $randname = random_string('numeric', '8');
        $config = array();
        $config['upload_path'] = './uploads/sessions/';
        $config['allowed_types'] = 'jpg|png';
        $config['overwrite'] = FALSE;
        $config['file_name'] = "sessions_" . $randname;
        return $config;
    }
    function set_upload_logo_options() {
        $this->load->helper('string');
        $randname = random_string('numeric', '8');
        $config = array();
        $config['upload_path'] = './uploads/sessions_logo/';
        $config['allowed_types'] = 'jpg|png';
        $config['overwrite'] = FALSE;
        $config['file_name'] = "logo_" . $randname;
        return $config;
    }

    function set_upload_session_end_image() {
        $this->load->helper('string');
        $randname = random_string('numeric', '8');
        $config = array();
        $config['upload_path'] = './uploads/session_end/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['overwrite'] = FALSE;
        $config['file_name'] = "session_end_" . $randname;
        return $config;
    }

    function generateRandomString($length = 8) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    function updateSessions() {
        $post = $this->input->post();


        $session_right_bar = "";
        if (isset($post["session_right_bar"])) {
            $session_right_bar = implode(",", $post["session_right_bar"]);
        }


        if (!empty($post['sessions_type'])) {
            $sessions_type_id = implode(",", $post['sessions_type']);
        } else {
            $sessions_type_id = "";
        }
        if (!empty($post['sessions_tracks'])) {
            $sessions_tracks_id = implode(",", $post['sessions_tracks']);
        } else {
            $sessions_tracks_id = "";
        }
		
		   if (!empty($post['moderator_id'])) {
            $moderator_id = implode(",", $post['moderator_id']);
        } else {
            $moderator_id = "";
        }
        if (!empty($post['select_presenter_id'])) {
            $presenter_id = implode(",", $post['select_presenter_id']);
        } else {
            $presenter_id = "";
        }
		
 if (!empty($post['moderator_id'])) {
            $moderator_id = implode(",", $post['moderator_id']);
        } else {
            $moderator_id = "";
        }

        if(isset($post['one_time_embed_html_code']) && !empty(trim($post['one_time_embed_html_code']))){
            $embed_html_code=(trim($post['one_time_embed_html_code']));
        }else{
            $embed_html_code=(trim($post['embed_html_code']));
        }
		
        $set = array(
            'presenter_id' => $presenter_id,
			'moderator_id' => $moderator_id,
            'session_title' => trim($post['session_title']),
            'cco_envent_id' => trim($post['cco_envent_id']),
            'sessions_description' => trim($post['sessions_description']),
            'landing_page_text' => trim($post['landing_page_text']),
            'sessions_date' => date("Y-m-d", strtotime($post['sessions_date'])),
             'zoom_link' => trim($post['zoom_link']),
             'zoom_number' => trim($post['zoom_number']),
            'zoom_password' => trim($post['zoom_password']),
            'time_slot' => date("H:i", strtotime($post['time_slot'])),
            'end_time' => date("H:i", strtotime($post['end_time'])),
            'embed_html_code' => $embed_html_code,
            'embed_html_code_presenter' => trim($post['embed_html_code_presenter']),
            'sessions_type_id' => $sessions_type_id,
            'sessions_tracks_id' => $sessions_tracks_id,
            'sessions_type_status' => trim($post['sessions_type_status']),
            'tool_box_status' => (isset($post['tool_box_status'])) ? $post['tool_box_status'] : 1,
			'attendee_view_links_status' => (isset($post['attendee_view_links_status'])) ? $post['attendee_view_links_status'] : 1,
            'url_link' => trim($post['url_link']),
            'link_text' => trim($post['link_text']),
            'sponsor_type' => $post['sponsor_type'],
            'sessions_logo_width' => $post['sessions_logo_width'],
            'sessions_logo_height' => $post['sessions_logo_height'],
            'right_bar' => $session_right_bar,
            'theme_color' => $post['theme_color'],
            'ppt_uploaded' => (isset($post['ppt_uploaded'])) ? $post['ppt_uploaded'] : 0,
            'ppt_link_shared' => (isset($post['ppt_link_shared'])) ? $post['ppt_link_shared'] : 0,
            'session_notes'=>$post['session_notes'],
            'session_end_message'=>$post['session_end_message'],
            'end_image_height'=>$post['end_image_height'],
            'end_image_width'=>$post['end_image_width'],
            'subsequent_session_1'=>(trim($post['subsequent_session_1']) == 'null')?null:trim($post['subsequent_session_1']),
            'subsequent_session_2'=>(trim($post['subsequent_session_2']) == 'null')?null:trim($post['subsequent_session_2']),
            'subsequent_session_popup_text'=>trim($post['subsequent_session_popup_text'])

        );
        $this->db->update("sessions", $set, array("sessions_id" => $post['sessions_id']));
        $sessions_id = $post['sessions_id'];
        if ($sessions_id > 0) {


            if ($_FILES['sessions_logo']['name'] != "") {
                $this->db->select('sessions_logo');
                $this->db->from('sessions');
                $this->db->where("sessions_id", $post['sessions_id']);
                $session = $this->db->get()->row();
                unlink("./uploads/sessions_logo/".$session->sessions_logo);


                $this->load->library('upload');
                $this->upload->initialize($this->set_upload_logo_options());
                $this->upload->do_upload('sessions_logo');
                $file_upload_name = $this->upload->data();
                $this->db->update('sessions', array('sessions_logo' => $file_upload_name['file_name']), array('sessions_id' => $sessions_id));
            }

            if ($_FILES['sessions_addnl_logo']['name'] != "") {
                $this->db->select('sessions_addnl_logo');
                $this->db->from('sessions');
                $this->db->where("sessions_id", $post['sessions_id']);
                $session = $this->db->get()->row();
                unlink("./uploads/sessions_logo/".$session->sessions_addnl_logo);


                $this->load->library('upload');
                $this->upload->initialize($this->set_upload_logo_options());
                $this->upload->do_upload('sessions_addnl_logo');
                $file_upload_name = $this->upload->data();
                $this->db->update('sessions', array('sessions_addnl_logo' => $file_upload_name['file_name']), array('sessions_id' => $sessions_id));
            }

            if ($_FILES['sessions_photo']['name'] != "") {
                $_FILES['sessions_photo']['name'] = $_FILES['sessions_photo']['name'];
                $_FILES['sessions_photo']['type'] = $_FILES['sessions_photo']['type'];
                $_FILES['sessions_photo']['tmp_name'] = $_FILES['sessions_photo']['tmp_name'];
                $_FILES['sessions_photo']['error'] = $_FILES['sessions_photo']['error'];
                $_FILES['sessions_photo']['size'] = $_FILES['sessions_photo']['size'];
                $this->load->library('upload');
                $this->upload->initialize($this->set_upload_options());
                $this->upload->do_upload('sessions_photo');
                $file_upload_name = $this->upload->data();
                $this->db->update('sessions', array('sessions_photo' => $file_upload_name['file_name']), array('sessions_id' => $sessions_id));
            }

            if ($_FILES['session_end_image']['name'] != "") {

                $this->load->library('upload');
                $this->upload->initialize($this->set_upload_session_end_image());
                $this->upload->do_upload('session_end_image');
                $file_upload_name = $this->upload->data();
                $this->db->update('sessions', array('session_end_image' => $file_upload_name['file_name']), array('sessions_id' => $sessions_id));
            }

            if (isset($post['select_presenter_id']) && !empty($post['select_presenter_id'])) {
                $array_size_limit = sizeof($post['select_presenter_id']);
                $file_upload_name = array();
                $files = $_FILES;
                $this->load->library('upload');
                for ($i = 0; $i < $array_size_limit; $i++) {
                    if ($post['status'][$i] == "update") {
                        $set_array = array(
                            'order_index_no' => $post['order_no'][$i],
                            'select_presenter_id' => $post['select_presenter_id'][$i],
                            'presenter_title' => $post['presenter_title'][$i],
                            'presenter_time_slot' => $post['presenter_time_slot'][$i],
                            'presenter_resource_link' => $post['presenter_resource_link'][$i],
                            'upload_published_name' => $post['upload_published_name'][$i],
                            'link_published_name' => $post['link_published_name'][$i]
                        );
                        $this->db->update("sessions_add_presenter", $set_array, array("sessions_add_presenter_id" => $post['sessions_add_presenter_id'][$i]));
                        $sessions_add_presenter_id = $post['sessions_add_presenter_id'][$i];
                    } else {
                        $set_array = array(
                            'sessions_id' => $sessions_id,
                            'order_index_no' => $post['order_no'][$i],
                            'select_presenter_id' => $post['select_presenter_id'][$i],
                            'presenter_title' => $post['presenter_title'][$i],
                            'presenter_time_slot' => $post['presenter_time_slot'][$i],
                            'presenter_resource_link' => $post['presenter_resource_link'][$i],
                            'upload_published_name' => $post['upload_published_name'][$i],
                            'link_published_name' => $post['link_published_name'][$i]
                        );
                        $this->db->insert("sessions_add_presenter", $set_array);
                        $sessions_add_presenter_id = $this->db->insert_id();
                    }
                    if ($sessions_add_presenter_id > 0) {

                        if ($_FILES['presenter_resource']['name'][$i] != "") {
                            $_FILES['presenter_resource']['name'] = $files['presenter_resource']['name'][$i];
                            $_FILES['presenter_resource']['type'] = $files['presenter_resource']['type'][$i];
                            $_FILES['presenter_resource']['tmp_name'] = $files['presenter_resource']['tmp_name'][$i];
                            $_FILES['presenter_resource']['error'] = $files['presenter_resource']['error'][$i];
                            $_FILES['presenter_resource']['size'] = $files['presenter_resource']['size'][$i];
                            $this->upload->initialize($this->set_upload_presenter_resource());
                            $this->upload->do_upload('presenter_resource');
                            $file_upload_name = $this->upload->data();
                            $this->db->update('sessions_add_presenter', array('presenter_resource' => $file_upload_name['file_name']), array('sessions_add_presenter_id' => $sessions_add_presenter_id));
                        }
                    }
                }
            }
            return "1";
        } else {
            return "2";
        }
    }

    function delete_sessions() {
        $post = $this->input->post();
        $sessions_id = $post["sesionId"];
        $this->db->delete("sessions", array("sessions_id" => $sessions_id));
        $this->db->delete("sessions_poll_question", array("sessions_id" => $sessions_id));
        $this->db->delete("poll_question_option", array("sessions_id" => $sessions_id));
        return "success";
    }

    function add_poll_data() {
        $post = $this->input->post();
        $set = array(
            'sessions_id' => trim($post['sessions_id']),
            'poll_type_id' => $post['poll_type_id'],
            'question' => trim($post['question']),
            'poll_name' => trim($post['poll_name']),
            'slide_number' => trim($post['slide_number']),
            'correct_answer1' => trim($post['correct_answer1']),
            'correct_answer2' => trim($post['correct_answer2']),
            'poll_instruction' => trim($post['poll_instruction']),
            'external_reference' => trim($post['external_reference']),
            'poll_comparisons_id' => 0,
            "create_poll_date" => date("Y-m-d h:i")
        );
        $this->db->insert("sessions_poll_question", $set);
        $insert_id = $this->db->insert_id();
        if ($insert_id > 0) {
            for ($i = 1; $i <= 10; $i++) {
                if ($post['option_' . $i] != "") {
                    $set_array = array(
                        'sessions_poll_question_id' => $insert_id,
                        'sessions_id' => trim($post['sessions_id']),
                        'option' => $post['option_' . $i],
                        "total_vot" => 0
                    );
                    $this->db->insert("poll_question_option", $set_array);
                }
            }
        }
        if ($post['poll_comparisons_with_us'] != "") {
            $this->add_poll_comparisons($post, $insert_id);
        }
        return TRUE;
    }

    function add_poll_comparisons($post, $insert_id) {
        $set = array(
            'sessions_id' => trim($post['sessions_id']),
            'poll_type_id' => $post['poll_comparisons_with_us'],
            'question' => trim($post['question']),
            'poll_name' => trim($post['poll_name']),
			'slide_number' => trim($post['slide_number']),
            'correct_answer1' => trim($post['correct_answer1']),
            'correct_answer2' => trim($post['correct_answer2']),
            'poll_comparisons_id' => $insert_id,
            "create_poll_date" => date("Y-m-d h:i")
        );
        $this->db->insert("sessions_poll_question", $set);
        $insert_new_id = $this->db->insert_id();
        if ($insert_new_id > 0) {
            $this->db->update("sessions_poll_question", array("poll_comparisons_id" => $insert_new_id), array("sessions_poll_question_id" => $insert_id));
            for ($i = 1; $i <= 10; $i++) {
                if ($post['option_' . $i] != "") {
                    $set_array = array(
                        'sessions_poll_question_id' => $insert_new_id,
                        'sessions_id' => trim($post['sessions_id']),
                        'option' => $post['option_' . $i],
                        "total_vot" => 0
                    );
                    $this->db->insert("poll_question_option", $set_array);
                }
            }
        }
    }

    function get_poll_details($sessions_id) {
        $this->db->select('*');
        $this->db->from('sessions_poll_question s');
        $this->db->join('poll_type p', 's.poll_type_id=p.poll_type_id');
        $this->db->where("s.sessions_id", $sessions_id);
        $this->db->order_by('cast(s.slide_number as decimal)', 'ASC');
        $poll_question = $this->db->get();
        if ($poll_question->num_rows() > 0) {
            $poll_question_array = array();
            foreach ($poll_question->result() as $val) {
                $val->option = $this->db->get_where("poll_question_option", array("sessions_poll_question_id" => $val->sessions_poll_question_id))->result();
                $poll_question_array[] = $val;
            }
            return $poll_question_array;
        } else {
            return '';
        }
    }
    ####################
    function getPollPresenter($sessions_id){
        $this->db->select('*');
        $this->db->from('sessions s');
        $this->db->where("sessions_id", $sessions_id);
        $sessions = $this->db->get();
        if ($sessions->num_rows() > 0) {
            $result_sessions = $sessions->row();
            $result_sessions->presenter = $this->common->get_presenter($result_sessions->presenter_id, $result_sessions->sessions_id);
            return $result_sessions;
        } else {
            return '';
        }
    }
    #############################
    function deletePollQuestion($sessions_poll_question_id) {
        $this->db->delete("sessions_poll_question", array("sessions_poll_question_id" => $sessions_poll_question_id));
        $this->db->delete("poll_question_option", array("sessions_poll_question_id" => $sessions_poll_question_id));
        return TRUE;
    }

    function editPollQuestion($sessions_poll_question_id) {
        $this->db->select('*');
        $this->db->from('sessions_poll_question');
        $this->db->where("sessions_poll_question_id", $sessions_poll_question_id);
        $poll_question = $this->db->get();
        if ($poll_question->num_rows() > 0) {
            $poll_question_array = $poll_question->row();
            $poll_question_array->option = $this->db->get_where("poll_question_option", array("sessions_poll_question_id" => $poll_question_array->sessions_poll_question_id))->result();
            if ($poll_question_array->poll_comparisons_id != 0 || $poll_question_array->poll_comparisons_id != '' )
                $poll_question_array->comparison_with = $this->db->get_where("sessions_poll_question", array("sessions_poll_question_id" => $poll_question_array->poll_comparisons_id))->result();
            $poll_question_array->all_other_surveys = $this->db->get_where("sessions_poll_question", array("sessions_id" => $poll_question_array->sessions_id, "sessions_poll_question_id !=" => $poll_question_array->sessions_poll_question_id))->result();
            return $poll_question_array;
        } else {
            return '';
        }
    }

    
    function update_poll_instruction($sesion_id){
        $post = $this->input->post();
        $set = array(
            'poll_instruction' => trim($post['poll_instruction']),
            
        );
        $this->db->update("sessions_poll_question", $set, array("sessions_poll_question_id" => $sesion_id));
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function update_poll_data() {
        $post = $this->input->post();
        $set = array(
            'question' => trim($post['question']),
            'question' => trim($post['question']),
            'poll_name' => trim($post['poll_name']),
            'slide_number' => trim($post['slide_number']),
            'correct_answer1' => trim($post['correct_answer1']),
            'correct_answer2' => trim($post['correct_answer2']),
            'poll_instruction' => trim($post['poll_instruction']),
            'external_reference' => trim($post['external_reference']),
            'poll_type_id' => $post['poll_type_id'],
            'poll_comparisons_id' => (isset($post['poll_comparisons_id']))?$post['poll_comparisons_id']:0
        );
        $this->db->update("sessions_poll_question", $set, array("sessions_poll_question_id" => $post['sessions_poll_question_id']));
        $option_result = $this->db->get_where("poll_question_option", array("sessions_poll_question_id" => $post['sessions_poll_question_id']))->result();
        if (isset($option_result) && !empty($option_result)) {
            foreach ($option_result as $key => $val) {
                $key++;
                if ($post['option_' . $key] != "") {
                    $set_array = array(
                        'option' => $post['option_' . $key],
                    );
                    $this->db->update("poll_question_option", $set_array, array("poll_question_option_id" => $val->poll_question_option_id));
                } else {
                    $this->db->delete("poll_question_option", array("poll_question_option_id" => $val->poll_question_option_id));
                }
            }

            $total = 10;
            $edit = sizeof($option_result);
            $edit = $edit + 1;
            for ($i = $edit; $i <= $total; $i++) {
                if ($post['option_' . $i] != "") {
                    $set_array = array(
                        'option' => $post['option_' . $i],
                    );
                    $set_array_int = array(
                        'sessions_poll_question_id' => $post['sessions_poll_question_id'],
                        'sessions_id' => trim($post['sessions_id']),
                        'option' => $post['option_' . $i],
                        "total_vot" => 0
                    );
                    $this->db->insert("poll_question_option", $set_array_int);
                }
            }
        }
        return TRUE;
    }

    
    function get_question_list() {
        $post = $this->input->post();
        $this->db->select('*');
        $this->db->from('sessions_cust_question s');
        $this->db->join('customer_master c', 's.cust_id=c.cust_id');
        $this->db->where(array("s.sessions_id" => $post['sessions_id'], 'hide_status'=>'0'));
        //  $this->db->order_by("s.sessions_cust_question_id", "DESC");
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return '';
        }
    }

    function addQuestionAnswer() {
        $post = $this->input->post();
        $set = array(
            'answer' => trim($post['q_answer']),
            'answer_by_id' => $this->session->userdata("aid"),
            "answer_status" => 1
        );
        $this->db->update("sessions_cust_question", $set, array("sessions_cust_question_id" => $post['sessions_cust_question_id']));
        return TRUE;
    }

    function getSessionsReportData($sessions_id) {
        $post = $this->input->post();
        $this->db->select('*');
        $this->db->from('sessions_cust_question s');
        $this->db->join('sessions se', 'se.sessions_id=s.sessions_id');
        $this->db->join('presenter p', 'p.presenter_id=se.presenter_id');
        $this->db->join('customer_master c', 'c.cust_id=s.cust_id');
        $this->db->where(array("s.sessions_id" => $sessions_id));
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return '';
        }
    }

    function getSessionQuestionReportData($sessions_id) {
        $post = $this->input->post();
        $this->db->select("question");
        $this->db->from('sessions_cust_question');
        $this->db->where('sessions_id',$sessions_id);
        return $this->db->get();
    }

    function getSessionQuestion($sessions_id) {
        $post = $this->input->post();
        $this->db->select("CONCAT(first_name, ' ', last_name) AS name");
        $this->db->select('question');
        $this->db->from('sessions_cust_question s');
        $this->db->join('customer_master cm','cm.cust_id=s.cust_id');
        $this->db->where('sessions_id',$sessions_id);
        $get_question= $this->db->get();
            if ($get_question->num_rows() > 0) {
                return $get_question;
            
        }else{
            $result = '';
        }
        
    }

    function get_poll_type() {
        $this->db->select('*');
        $this->db->from('poll_type');
        $poll_type = $this->db->get();
        if ($poll_type->num_rows() > 0) {
            return $poll_type->result();
        } else {
            return '';
        }
    }

    function view_result($sessions_poll_question_id) {
        $this->db->select('*');
        $this->db->from('sessions_poll_question s');
        $this->db->join('poll_type p', 's.poll_type_id=p.poll_type_id');
        $this->db->where(array("s.sessions_poll_question_id" => $sessions_poll_question_id));
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $poll_question_array = $result->row();
            if ($poll_question_array->poll_comparisons_id == 0) {
                $poll_question_array->option = $this->db->get_where("poll_question_option", array("sessions_poll_question_id" => $poll_question_array->sessions_poll_question_id))->result();
                $poll_question_array->max_value = $this->get_maxvalue_option($poll_question_array->sessions_poll_question_id);
                return $poll_question_array;
            } else {
                $result_compar_poll = $this->db->get_where("sessions_poll_question", array("sessions_poll_question_id" => $poll_question_array->poll_comparisons_id))->row();
                if ($result_compar_poll->status == 0) {
                    $poll_question_array->option = $this->db->get_where("poll_question_option", array("sessions_poll_question_id" => $poll_question_array->sessions_poll_question_id))->result();
                    $poll_question_array->max_value = $this->get_maxvalue_option($poll_question_array->sessions_poll_question_id);
                    return $poll_question_array;
                } else {
                    $poll_question_array->option = $this->getOption($poll_question_array->sessions_poll_question_id, $poll_question_array->poll_comparisons_id);
                    $poll_question_array->max_value = $this->get_maxvalue_option($poll_question_array->sessions_poll_question_id);
                    if (!empty($result_compar_poll)) {
                        //  $poll_question_array->compere_poll_type = $this->db->get_where("poll_type", array("poll_type_id" => $result_compar_poll->poll_type_id))->row()->poll_type;
                        //  $poll_question_array->compere_option = $this->db->get_where("poll_question_option", array("sessions_poll_question_id" => $result_compar_poll->sessions_poll_question_id))->result();
                        $poll_question_array->compere_max_value = $this->get_maxvalue_option($result_compar_poll->sessions_poll_question_id);
                    }
                    return $poll_question_array;
                }
            }
        } else {
            return '';
        }
    }

    function getOption($sessions_poll_question_id, $poll_comparisons_id) {

        $this->db->select('*');
        $this->db->from('poll_question_option');
        $this->db->where("sessions_poll_question_id", $sessions_poll_question_id);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $result_compar_poll = $this->db->get_where("sessions_poll_question", array("sessions_poll_question_id" => $poll_comparisons_id))->row();
            $result_array = array();
            foreach ($result->result() as $val) {
                $val->compere_option = $this->db->get_where("poll_question_option", array("sessions_poll_question_id" => $result_compar_poll->sessions_poll_question_id, "option" => $val->option))->row()->total_vot;
                $result_array[] = $val;
            }
            return $result_array;
        } else {
            return '';
        }
    }

    function view_session($sessions_id) {
        $this->db->select('*');
        $this->db->from('sessions s');
        $this->db->where("sessions_id", $sessions_id);
        $sessions = $this->db->get();
        if ($sessions->num_rows() > 0) {
            $result_sessions = $sessions->row();
            $result_sessions->presenter = $this->common->get_presenter($result_sessions->presenter_id, $result_sessions->sessions_id);
            return $result_sessions;
        } else {
            return '';
        }
    }

    function get_poll_vot_section() {
        $post = $this->input->post();
        $this->db->select('*');
        $this->db->from('sessions_poll_question');
        $this->db->where(array("sessions_id" => $post['sessions_id']));
        $where = '(status = 1 or status = 2)';
        $this->db->where($where);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $poll_question_array = $result->row();
            if ($poll_question_array->status == 1) {
                $poll_question_array->poll_status = 1;
                $poll_question_array->exist_status = 1;
                $poll_question_array->select_option_id = 0;
                $poll_question_array->option = $this->db->get_where("poll_question_option", array("sessions_poll_question_id" => $poll_question_array->sessions_poll_question_id))->result();
                return $poll_question_array;
            } else if ($poll_question_array->status == 2) {
                if ($poll_question_array->poll_comparisons_id == 0) {
                    $poll_question_array->poll_status = 2;
                    $poll_question_array->option = $this->db->get_where("poll_question_option", array("sessions_poll_question_id" => $poll_question_array->sessions_poll_question_id))->result();
                    $poll_question_array->max_value = $this->get_maxvalue_option($poll_question_array->sessions_poll_question_id);
                    return $poll_question_array;
                } else {
                    $result_compar_poll = $this->db->get_where("sessions_poll_question", array("sessions_poll_question_id" => $poll_question_array->poll_comparisons_id))->row();
                    if ($result_compar_poll->status == 0) {
                        $poll_question_array->poll_status = 2;
                        $poll_question_array->option = $this->db->get_where("poll_question_option", array("sessions_poll_question_id" => $poll_question_array->sessions_poll_question_id))->result();
                        $poll_question_array->max_value = $this->get_maxvalue_option($poll_question_array->sessions_poll_question_id);
                        return $poll_question_array;
                    } else {
                        $poll_question_array->option = $this->getOption($poll_question_array->sessions_poll_question_id, $poll_question_array->poll_comparisons_id);
                        $poll_question_array->poll_status = 2;
                        $poll_question_array->max_value = $this->get_maxvalue_option($poll_question_array->sessions_poll_question_id);
                        if (!empty($result_compar_poll)) {
                            //  $poll_question_array->compere_poll_type = $this->db->get_where("poll_type", array("poll_type_id" => $result_compar_poll->poll_type_id))->row()->poll_type;
                            //  $poll_question_array->compere_option = $this->db->get_where("poll_question_option", array("sessions_poll_question_id" => $result_compar_poll->sessions_poll_question_id))->result();
                            $poll_question_array->compere_max_value = $this->get_maxvalue_option($result_compar_poll->sessions_poll_question_id);
                        }
                        return $poll_question_array;
                    }
                }
            }
        } else {
            return '';
        }
    }

    function get_maxvalue_option($sessions_poll_question_id) {
        $this->db->select('MAX(total_vot) as max_total_vot');
        $this->db->from('poll_question_option');
        $this->db->where("sessions_poll_question_id", $sessions_poll_question_id);
        $sessions = $this->db->get();
        if ($sessions->num_rows() > 0) {
            return $sessions->row()->max_total_vot;
        } else {
            return '';
        }
    }

    function get_poll_vot_section_close_poll() {
        $post = $this->input->post();
        $this->db->select('*');
        $this->db->from('sessions_poll_question');
        $this->db->where(array("sessions_id" => $post['sessions_id']));
        $where = '(status = 4)';
        $this->db->where($where);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $poll_question_array = $result->row();
            if ($poll_question_array->status == 1) {
                $poll_question_array->poll_status = 1;
                $poll_question_array->exist_status = 1;
                $poll_question_array->select_option_id = 0;
                $poll_question_array->option = $this->db->get_where("poll_question_option", array("sessions_poll_question_id" => $poll_question_array->sessions_poll_question_id))->result();
                return $poll_question_array;
            } else if ($poll_question_array->status == 2) {
                $poll_question_array->poll_status = 2;
                $poll_question_array->option = $this->db->get_where("poll_question_option", array("sessions_poll_question_id" => $poll_question_array->sessions_poll_question_id))->result();
                return $poll_question_array;
            } else if ($poll_question_array->status == 4) {
                $poll_question_array->poll_status = 4;
                $poll_question_array->option = $this->db->get_where("poll_question_option", array("sessions_poll_question_id" => $poll_question_array->sessions_poll_question_id))->result();
                return $poll_question_array;
            }
        } else {
            return '';
        }
    }

    function get_favorite_question_list() {
//        $post = $this->input->post();
//        $this->db->select('*');
//        $this->db->from('tbl_favorite_question_admin fq');
//        $this->db->join('sessions_cust_question s', 's.sessions_cust_question_id = fq.sessions_cust_question_id');
//        $this->db->where(array("fq.sessions_id" => $post['sessions_id'], 'fq.cust_id' => $this->session->userdata("aid"), 'fq.tbl_favorite_question_admin_id >' => $post['list_last_id'], 'fq.hide_status' => 0));
//        $result = $this->db->get();
//        if ($result->num_rows() > 0) {
//            return $result->result();
//        } else {
//            return '';
//        }

        $post = $this->input->post();
        $this->db->select('*');
        $this->db->from('tbl_favorite_question fq');
        $this->db->join('sessions_cust_question s', 's.sessions_cust_question_id = fq.sessions_cust_question_id');
        $this->db->join('customer_master c', 's.cust_id=c.cust_id');
        $this->db->where(array("fq.sessions_id" => $post['sessions_id'], 'fq.hide_status' => 0));
        $this->db->group_by('fq.tbl_favorite_question_id');
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return '';
        }
    }

    function likeQuestion() {
        $post = $this->input->post();
        $insert_array = array(
            'cust_id' => $this->session->userdata("aid"),
            'sessions_id' => $post['sessions_id'],
            'sessions_cust_question_id' => $post['sessions_cust_question_id']
        );
        $favorite_question_row = $this->db->get_where('tbl_favorite_question_admin', $insert_array)->row();
        if (!empty($favorite_question_row)) {
            $this->db->delete("tbl_favorite_question_admin", $insert_array);
        } else {
            $this->db->insert("tbl_favorite_question_admin", $insert_array);
        }
        return TRUE;
    }

    function get_resource($sessions_id) {
        $this->db->select('*');
        $this->db->from('session_resource');
        $this->db->where('sessions_id', $sessions_id);
        $session_resource = $this->db->get();
        if ($session_resource->num_rows() > 0) {
            return $session_resource->result();
        } else {
            return '';
        }
    }

    function add_resource($post) {
        $data = array(
            'link_published_name' => $post['link_published_name'],
            'resource_link' => $post['resource_link'],
            'upload_published_name' => $post['upload_published_name'],
            'sessions_id' => $post['sessions_id']
        );
        $this->db->insert('session_resource', $data);
        $id = $this->db->insert_id();
        if ($id > 0) {
            if ($_FILES['resource_file']['name'] != "") {
                $_FILES['resource_file']['name'] = $_FILES['resource_file']['name'];
                $_FILES['resource_file']['type'] = $_FILES['resource_file']['type'];
                $_FILES['resource_file']['tmp_name'] = $_FILES['resource_file']['tmp_name'];
                $_FILES['resource_file']['error'] = $_FILES['resource_file']['error'];
                $_FILES['resource_file']['size'] = $_FILES['resource_file']['size'];
                $this->load->library('upload');
                $this->upload->initialize($this->set_upload_options_resource());
                $this->upload->do_upload('resource_file');
                $file_upload_name = $this->upload->data();
                $this->db->update('session_resource', array('resource_file' => $file_upload_name['file_name'], 'file_name' =>   $file_upload_name['client_name']), array('session_resource_id' => $id));
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function set_upload_options_resource() {
        $this->load->helper('string');
        $randname = random_string('numeric', '8');
        $config = array();
        $config['upload_path'] = './uploads/resource_sessions/';
        $config['allowed_types'] = '*';
        $config['overwrite'] = FALSE;
        $config['file_name'] = "resource_sessions_" . $randname;
        return $config;
    }

    function get_session_resource($sessions_id) {
        $this->db->select('*');
        $this->db->from('session_resource');
        $this->db->where('sessions_id', $sessions_id);
        $session_resource = $this->db->get();
        if ($session_resource->num_rows() > 0) {
            return $session_resource->result();
        } else {
            return '';
        }
    }

    function importSessionsPoll() {
        $this->load->library('csvimport');
        if ($_FILES['sessions_poll_file']['error'] != 4) {
            $pathMain = FCPATH . "/uploads/csv/";
            $filename = $this->generateRandomString() . '_' . $_FILES['sessions_poll_file']['name'];
            $result = $this->common->do_upload('sessions_poll_file', $pathMain, $filename);
            $file_path = $result['upload_data']['full_path'];
            if ($this->csvimport->get_array($file_path)) {
                $csv_array = $this->csvimport->get_array($file_path);
                if (!empty($csv_array)) {
                    foreach ($csv_array as $val) {
                        $poll_type_id=$val['poll_type_id'];
                        if (trim(strtolower($poll_type_id)) == "presurvey"){
                            $poll_type="1";
                        }
                        elseif (trim(strtolower($poll_type_id)) =="poll" ){
                            $poll_type="2";
                        }
                        elseif (trim(strtolower($poll_type_id)) =='assessment'){
                            $poll_type="3";
                        }else{
                            $poll_type=$poll_type_id;
                        }

                        if ($val['question'] != "" && $val['poll_type_id'] != "") {
                            $post = $this->input->post();
                            $set = array(
                                'sessions_id' => trim($post['sessions_id']),
                                'poll_type_id' => $poll_type,
                                'poll_name' => trim($val['poll_name']),
                                'question' => trim($val['question']),
                                'slide_number'=>$val['slide_number'],
                                'poll_instruction'=>trim($val['poll_instruction']),
                                'poll_comparisons_id' => 0,
                                "create_poll_date" => date("Y-m-d h:i")
                            );
                            $this->db->insert("sessions_poll_question", $set);
                            $insert_id = $this->db->insert_id();
                            if ($insert_id > 0) {
                                for ($i = 1; $i <= 10; $i++) {
                                    if ($val['option_' . $i] != "") {
                                        $set_array = array(
                                            'sessions_poll_question_id' => $insert_id,
                                            'sessions_id' => trim($post['sessions_id']),
                                            'option' => $val['option_' . $i],
                                            "total_vot" => 0
                                        );
                                        $this->db->insert("poll_question_option", $set_array);
                                    }
                                }
                            }
                        }
                    }
                }
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    function get_music_setting() {
        $query = $this->db->get_where('music_setting');
        return $query->row();
    }

    function getSessionTypes() {
        $this->db->select('*');
        $this->db->from('sessions_type');
        $sessions_type = $this->db->get();
        if ($sessions_type->num_rows() > 0) {
            return $sessions_type->result();
        } else {
            return '';
        }
    }

    function getSessionTracks() {
        $this->db->select('*');
        $this->db->from('sessions_tracks');
        $sessions_tracks = $this->db->get();
        if ($sessions_tracks->num_rows() > 0) {
            return $sessions_tracks->result();
        } else {
            return '';
        }
    }

    function send_json($sessions_id) {
        $this->db->select('*');
        $this->db->from('sessions');
        $this->db->where("sessions_id", $sessions_id);
        $sessions = $this->db->get();
        if ($sessions->num_rows() > 0) {
            $result_sessions = $sessions->row();
            $this->db->select('*');
            $this->db->from('login_sessions_history v');
            $this->db->join('customer_master c', 'c.cust_id=v.cust_id');
            $this->db->where("v.sessions_id", $sessions_id);
            $sessions_history = $this->db->get();
            $sessions_history_login = array();
            if ($sessions_history->num_rows() > 0) {
                foreach ($sessions_history->result() as $val) {
                    $start_date_time = strtotime($val->start_date_time);
                    $end_date_time = strtotime($val->end_date_time);
                    if ($end_date_time != "") {
                        if ($end_date_time >= $start_date_time) {
                            $total_time = $end_date_time - $start_date_time;
                        } else {
                            $total_time = $start_date_time - $end_date_time;
                        }
                    } else {
                        $end_date_time = 0;
                        $total_time = 0;
                    }
                    $private_notes = "";
                    $this->db->select('note');
                    $this->db->from('sessions_cust_briefcase');
                    $this->db->where(array("cust_id" => $val->cust_id, "sessions_id"=>$sessions_id));
                    $sessions_cust_briefcase = $this->db->get();
                    if ($sessions_cust_briefcase->num_rows() > 0) {
                        foreach ($sessions_cust_briefcase->result() as $note)
                            $private_notes[] = $note->note;
//                        $private_notes = $sessions_cust_briefcase->result()->note;
                    }
                    $sessions_history_login[] = array(
                        'uuid' => $val->cust_id,
                        'access' => 50,
                        'created_time' => $start_date_time,
                        'last_connected' => $end_date_time,
                        'total_time' => $total_time,
                        //'total_time' => $this->getTimeSpentOnSession($sessions_id, $val->cust_id),
                        'meta' => array("notes" => $private_notes, "personal_slide_notes" => array()),
                        'alertness' => array("checks_returned" => "", "understood" => ""),
                        'browser_sessions' => array("0" => array("uuid" => $val->cust_id, "launched_time" => $start_date_time, "last_connected" => $end_date_time, "user_agent" => $val->operating_system . ' - ' . $val->computer_type)),
                        'identity' => array("uuid" => $val->cust_id, 'identifier' => $val->identifier_id, 'name' => $val->first_name . ' ' . $val->last_name, 'email' => $val->email, 'profile_org_name' => $val->company_name, 'profile_org_title' => $val->company_name, 'profile_org_website' => "", 'profile_bio' => $val->topic, 'profile_twitter' => $val->twitter_id, 'profile_linkedin' => "", 'profile_country' => $val->country, 'profile_picture_url' => "", 'profile_last_updated' => ""),
                        'state_changes' => array("0" => array("timestamp" => 1592865240, "state" => 0))
                    );
                }
            }

            $this->db->select('*');
            $this->db->from('sessions_poll_question s');
            $this->db->join('poll_type p', 's.poll_type_id=p.poll_type_id');
            $this->db->where("s.sessions_id", $sessions_id);
            $sessions_poll_question = $this->db->get();
            $polls = array();

            if ($sessions_poll_question->num_rows() > 0) {
                $presurvey = 0;
                $poll = 0;
                $assessment = 0;
                foreach ($sessions_poll_question->result() as $sessions_poll_question) {
                    $options = array();
                    $this->db->select('*');
                    $this->db->from('poll_question_option');
                    $this->db->where("sessions_poll_question_id", $sessions_poll_question->sessions_poll_question_id);
                    $poll_question_option = $this->db->get();
                    if ($poll_question_option->num_rows() > 0) {
                        foreach ($poll_question_option->result() as $val) {
                            $votes = array();
                            $this->db->select('*');
                            $this->db->from('tbl_poll_voting');
                            $this->db->where("poll_question_option_id", $val->poll_question_option_id);
                            $tbl_poll_voting = $this->db->get();
                            if ($tbl_poll_voting->num_rows() > 0) {
                                foreach ($tbl_poll_voting->result() as $tbl_poll_voting) {
                                    $votes[] = (int) $tbl_poll_voting->cust_id;
                                }
                            }
                            $options[] = array(
                                'option_id' => (int) $val->poll_question_option_id,
                                'text' => $val->option,
                                'total_votes' => $val->total_vot,
                                'votes' => $votes
                            );

                            $total_votes = 0;
                            $this->db->select('*');
                            $this->db->from('tbl_poll_voting');
                            $this->db->where("sessions_poll_question_id", $val->sessions_poll_question_id);
                            $tbl_poll_voting_2 = $this->db->get();
                            if ($tbl_poll_voting_2->num_rows() > 0) {
                                $total_votes = $tbl_poll_voting_2->num_rows();
                            }
                        }
                    }
                    if ($sessions_poll_question->poll_type_id == 1) {
                        $presurvey = $presurvey + 1;
                        $polls[] = array(
                            'uuid' => '',
                            'status' => 4000,
                            'external_reference' => $sessions_poll_question->external_reference,
                            'poll_id' => (int) $sessions_poll_question->sessions_poll_question_id,
                            'text' => $sessions_poll_question->question,
                            'options' => $options,
                            'total_votes' => $total_votes,
                            'response_type' => 0,
                            'text_responses' => array()
                        );
                    } else if ($sessions_poll_question->poll_type_id == 2) {
                        $poll = $poll + 1;
                        $polls[] = array(
                            'uuid' => '',
                            'text' => $sessions_poll_question->question,
                            'status' => 4000,
                            'external_reference' => $sessions_poll_question->external_reference,
                            'poll_id' => (int) $sessions_poll_question->sessions_poll_question_id,
                            'options' => $options,
                            'total_votes' => $total_votes,
                            'response_type' => 0,
                            'text_responses' => array()
                        );
                    } else if ($sessions_poll_question->poll_type_id == 3) {
                        $assessment = $assessment + 1;
                        $polls[] = array(
                            'uuid' => '',
                            'status' => 4000,
                            'external_reference' => $sessions_poll_question->external_reference,
                            'poll_id' => (int) $sessions_poll_question->sessions_poll_question_id,
                            'text' => $sessions_poll_question->question,
                            'options' => $options,
                            'total_votes' => $total_votes,
                            'response_type' => 0,
                            'text_responses' => array()
                        );
                    }
                }
            }


            $this->db->select('*');
            $this->db->from('sessions_cust_question');
            $this->db->where("sessions_id", $sessions_id);
            $sessions_cust_question = $this->db->get();
            $questions = array();
            if ($sessions_cust_question->num_rows() > 0) {
                foreach ($sessions_cust_question->result() as $key => $val) {
                    $questions[] = array(
                        'uuid'=>$val->cust_id,
                        'index' => (int) $key,
                        'login' => (int) $val->cust_id,
                        'body' => $val->question,
                        'timestamp' => strtotime($val->reg_question_date),
                        'upvotes'=>array()
//                        'question' => $val->question,
//                        'reply_login_id' => ($val->answer_by_id != "") ? $val->answer_by_id : "",
//                        'reply' => ($val->answer != "") ? $val->answer : ""
                    );
                }
            }
            $charting[] = array(
                'online' => 0,
                'timestamp' => 0,
                'total_logins' => 0
            );

            $this->db->select('*');
            $this->db->from('sessions_group_chat_msg');
            $this->db->where("sessions_id", $sessions_id);
            $sessions_group_chat_msg = $this->db->get();
            $messages = array();
            if ($sessions_group_chat_msg->num_rows() > 0) {
                foreach ($sessions_group_chat_msg->result() as $key => $val) {
                    $messages[] = array(
                        'uuid' => $val->user_id,
                        'login' => $val->user_id,
                        'timestamp' => strtotime($val->message_date),
                        'message' => $val->message,
                        'status' => 0,
                        'is_positive' => FALSE,
                        'deleted_reason' => 0
                    );
                }
            }

            $this->db->select('*');
            $this->db->from('session_resource');
            $this->db->where("sessions_id", $sessions_id);
            $session_resource = $this->db->get();
            $files = array();
            $hyperlinks = array();
            if ($session_resource->num_rows() > 0) {
                foreach ($session_resource->result() as $key => $val) {
                    $files[] = array(
                        'uuid' => "",
                        'name' => $val->upload_published_name,
                        'about' => "",
                        'size' => 1000,
                        'clicks' =>array(array('login'=>"",'player_timestamp'=>"",'eos_timestamp'=>""))
                    );
                    $hyperlinks[] = array(
                        'uuid' => "",
                        'name' => $val->link_published_name,
                        'url' => $val->resource_link,
                        'clicks' =>array(array('login'=>"",'player_timestamp'=>"",'eos_timestamp'=>""))
                    );
                }
            }

            $create_array = array(
                'actual_end_time' => strtotime($result_sessions->sessions_date . ' ' . $result_sessions->end_time),
                'cssid' => $result_sessions->cco_envent_id,
                'end_time' => strtotime($result_sessions->sessions_date . ' ' . $result_sessions->end_time),
                'name' => $result_sessions->session_title,
                'reference' => $result_sessions->sessions_id,
                'session_id' => (int) $result_sessions->sessions_id,
                'start_time' => strtotime($result_sessions->sessions_date . ' ' . $result_sessions->time_slot),
                'logins' => $sessions_history_login,
                'alertness' => array('count' => 0, 'checks' => array(), 'template' => array('alertness_template_id' => 1, 'name' => "", 'feature_name' => "", 'briefing_preface' => "", 'briefing_text' => "", 'briefing_accept_button' => "", 'briefing_optout_enabled' => "", 'prompt_title' => "", 'prompt_text' => "", 'prompt_audio_file' => "", 'prompt_duration' => "", 'show_failure_notifications' => "", 'aai_variance' => "", 'aai_starting_boundary' => "", 'aai_ending_boundary' => "", 'aai_setup_delay' => "")),
                'chat' => array('enabled' => true,'messages' => $messages),
                'hostschat' => array('messages' => $messages),
                'jpc' => array('conversations' => array()),
                'presentation' => array('decks' => array(array("uuid"=>"","name"=>"","thumbnail_url"=>'',"slides"=>array("image_url"=>"","index"=>"","notes"=>'','title'=>"","thumbnail_url"=>"","uuid"=>""))), 'slide_events' => array(array("slide_uuid"=>"","timestamp"=>""))),
                'polling' => array("enabled" => true, "polls" => $polls),
                'questions' => array("enabled"=>true,'submitted'=>$questions),
                'resources'=>array("files"=>$files,'hyperlinks'=>$hyperlinks),
                'charting' => $charting
            );

            $json_array = array("data" => json_encode($create_array), "session_reference" => (int) $result_sessions->sessions_id, "session_id" => (int) $result_sessions->sessions_id, "source" => "gravity");

            $data_to_post = "data=" . json_encode($create_array) . "&session_reference=" . (int) $result_sessions->sessions_id . "&session_id=" . (int) $result_sessions->sessions_id . "&source=gravity"; //if http_build_query causes any problem with JSON data, send this parameter directly in post.

            $url = "https://practicingclinicians.com/testing/digitell/digitell-session-data-v2.php";
            $headers = array(
                'Content-Type:application/json',
                'Accept: application/json'
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($json_array));
            $result = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($result);
            echo "<pre>";
            print_r($result);
//            die;
            if ($result == 1) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    function view_json($sessions_id) {
        $this->db->select('*');
        $this->db->from('sessions');
        $this->db->where("sessions_id", $sessions_id);
        $sessions = $this->db->get();
        if ($sessions->num_rows() > 0) {
            $result_sessions = $sessions->row();
            $this->db->select('*');
            $this->db->from('login_sessions_history v');
            $this->db->join('customer_master c', 'c.cust_id=v.cust_id');
            $this->db->where("v.sessions_id", $sessions_id);
            $sessions_history = $this->db->get();
            $sessions_history_login = array();
            if ($sessions_history->num_rows() > 0) {
                foreach ($sessions_history->result() as $val) {
                    $start_date_time = strtotime($val->start_date_time);
                    $end_date_time = strtotime($val->end_date_time);
                    if ($end_date_time != "") {
                        if ($end_date_time >= $start_date_time) {
                            $total_time = $end_date_time - $start_date_time;
                        } else {
                            $total_time = $start_date_time - $end_date_time;
                        }
                    } else {
                        $end_date_time = 0;
                        $total_time = 0;
                    }

                    $private_notes = "";
                    $this->db->select('*');
                    $this->db->from('sessions_cust_briefcase');
                    $this->db->where(array("cust_id" => $val->cust_id, "sessions_id"=>$sessions_id));
                    $sessions_cust_briefcase = $this->db->get();
                    if ($sessions_cust_briefcase->num_rows() > 0) {
                        foreach ($sessions_cust_briefcase->result() as $note)
                            $private_notes[] = $note->note;
                        //$private_notes = $sessions_cust_briefcase->result()->note;
                    }

                    $sessions_history_login[] = array(
                        'uuid' => $val->cust_id,
                        'access' => 50,
                        'created_time' => $start_date_time,
                        'last_connected' => $end_date_time,
                        'total_time' => $total_time,
                        //'total_time' => $this->getTimeSpentOnSession($sessions_id, $val->cust_id),
                        'meta' => array("notes" => $private_notes, "personal_slide_notes" => array()),
                        'alertness' => array("checks_returned" => "", "understood" => ""),
                        'browser_sessions' => array("0" => array("uuid" => $val->cust_id, "launched_time" => $start_date_time, "last_connected" => $end_date_time, "user_agent" => $val->operating_system . ' - ' . $val->computer_type)),
                        'identity' => array("uuid" => $val->cust_id, 'identifier' => $val->identifier_id, 'name' => $val->first_name . ' ' . $val->last_name, 'email' => $val->email, 'profile_org_name' => $val->company_name, 'profile_org_title' => $val->company_name, 'profile_org_website' => "", 'profile_bio' => $val->topic, 'profile_twitter' => $val->twitter_id, 'profile_linkedin' => "", 'profile_country' => $val->country, 'profile_picture_url' => "", 'profile_last_updated' => ""),
                        'state_changes' => array("0" => array("timestamp" => 1592865240, "state" => 0))
                    );
                }
            }

            $this->db->select('*');
            $this->db->from('sessions_poll_question s');
            $this->db->join('poll_type p', 's.poll_type_id=p.poll_type_id');
            $this->db->where("s.sessions_id", $sessions_id);
            $sessions_poll_question = $this->db->get();
            $polls = array();

            if ($sessions_poll_question->num_rows() > 0) {
                $presurvey = 0;
                $poll = 0;
                $assessment = 0;
                foreach ($sessions_poll_question->result() as $sessions_poll_question) {
                    $options = array();
                    $this->db->select('*');
                    $this->db->from('poll_question_option');
                    $this->db->where("sessions_poll_question_id", $sessions_poll_question->sessions_poll_question_id);
                    $poll_question_option = $this->db->get();
                    if ($poll_question_option->num_rows() > 0) {
                        foreach ($poll_question_option->result() as $val) {
                            $votes = array();
                            $this->db->select('*');
                            $this->db->from('tbl_poll_voting');
                            $this->db->where("poll_question_option_id", $val->poll_question_option_id);
                            $tbl_poll_voting = $this->db->get();
                            if ($tbl_poll_voting->num_rows() > 0) {
                                foreach ($tbl_poll_voting->result() as $tbl_poll_voting) {
                                    $votes[] = (int) $tbl_poll_voting->cust_id;
                                }
                            }
                            $options[] = array(
                                'option_id' => (int) $val->poll_question_option_id,
                                'text' => $val->option,
                                'total_votes' => $val->total_vot,
                                'votes' => $votes
                            );

                            $total_votes = 0;
                            $this->db->select('*');
                            $this->db->from('tbl_poll_voting');
                            $this->db->where("sessions_poll_question_id", $val->sessions_poll_question_id);
                            $tbl_poll_voting_2 = $this->db->get();
                            if ($tbl_poll_voting_2->num_rows() > 0) {
                                $total_votes = $tbl_poll_voting_2->num_rows();
                            }
                        }
                    }
                    if ($sessions_poll_question->poll_type_id == 1) {
                        $presurvey = $presurvey + 1;
                        $polls[] = array(
                            'uuid' => '',
                            'status' => 4000,
                            'external_reference' => $sessions_poll_question->external_reference,
                            'poll_id' => (int) $sessions_poll_question->sessions_poll_question_id,
                            'text' => $sessions_poll_question->question,
                            'options' => $options,
                            'total_votes' => $total_votes,
                            'response_type' => 0,
                            'text_responses' => array()
                        );
                    } else if ($sessions_poll_question->poll_type_id == 2) {
                        $poll = $poll + 1;
                        $polls[] = array(
                            'uuid' => '',
                            'text' => $sessions_poll_question->question,
                            'status' => 4000,
                            'external_reference' => $sessions_poll_question->external_reference,
                            'poll_id' => (int) $sessions_poll_question->sessions_poll_question_id,
                            'options' => $options,
                            'total_votes' => $total_votes,
                            'response_type' => 0,
                            'text_responses' => array()
                        );
                    } else if ($sessions_poll_question->poll_type_id == 3) {
                        $assessment = $assessment + 1;
                        $polls[] = array(
                            'uuid' => '',
                            'status' => 4000,
                            'external_reference' => $sessions_poll_question->external_reference,
                            'poll_id' => (int) $sessions_poll_question->sessions_poll_question_id,
                            'text' => $sessions_poll_question->question,
                            'options' => $options,
                            'total_votes' => $total_votes,
                            'response_type' => 0,
                            'text_responses' => array()
                        );
                    }
                }
            }


            $this->db->select('*');
            $this->db->from('sessions_cust_question');
            $this->db->where("sessions_id", $sessions_id);
            $sessions_cust_question = $this->db->get();
            $questions = array();
            if ($sessions_cust_question->num_rows() > 0) {
                foreach ($sessions_cust_question->result() as $key => $val) {
                    $questions[] = array(
                        'uuid'=>$val->cust_id,
                        'index' => (int) $key,
                        'login' => (int) $val->cust_id,
                        'body' => $val->question,
                        'timestamp' => strtotime($val->reg_question_date),
                        'upvotes'=>array()
//                        'question' => $val->question,
//                        'reply_login_id' => ($val->answer_by_id != "") ? $val->answer_by_id : "",
//                        'reply' => ($val->answer != "") ? $val->answer : ""
                    );
                }
            }
            $charting[] = array(
                'online' => 0,
                'timestamp' => 0,
                'total_logins' => 0
            );

            $this->db->select('*');
            $this->db->from('sessions_group_chat_msg');
            $this->db->where("sessions_id", $sessions_id);
            $sessions_group_chat_msg = $this->db->get();
            $messages = array();
            if ($sessions_group_chat_msg->num_rows() > 0) {
                foreach ($sessions_group_chat_msg->result() as $key => $val) {
                    $messages[] = array(
                        'uuid' => $val->user_id,
                        'login' => $val->user_id,
                        'timestamp' => strtotime($val->message_date),
                        'message' => $val->message,
                        'status' => 0,
                        'is_positive' => FALSE,
                        'deleted_reason' => 0
                    );
                }
            }

            $this->db->select('*');
            $this->db->from('session_resource');
            $this->db->where("sessions_id", $sessions_id);
            $session_resource = $this->db->get();
            $files = array();
            $hyperlinks = array();
            if ($session_resource->num_rows() > 0) {
                foreach ($session_resource->result() as $key => $val) {
                    $files[] = array(
                        'uuid' => "",
                        'name' => $val->upload_published_name,
                        'about' => "",
                        'size' => 1000,
                        'clicks' =>array(array('login'=>"",'player_timestamp'=>"",'eos_timestamp'=>""))
                    );
                    $hyperlinks[] = array(
                        'uuid' => "",
                        'name' => $val->link_published_name,
                        'url' => $val->resource_link,
                        'clicks' =>array(array('login'=>"",'player_timestamp'=>"",'eos_timestamp'=>""))
                    );
                }
            }



            $create_array = array(
                'actual_end_time' => strtotime($result_sessions->sessions_date . ' ' . $result_sessions->end_time),
                'cssid' => $result_sessions->cco_envent_id,
                'end_time' => strtotime($result_sessions->sessions_date . ' ' . $result_sessions->end_time),
                'name' => $result_sessions->session_title,
                'reference' => $result_sessions->sessions_id,
                'session_id' => (int) $result_sessions->sessions_id,
                'start_time' => strtotime($result_sessions->sessions_date . ' ' . $result_sessions->time_slot),
                'logins' => $sessions_history_login,
                'alertness' => array('count' => 0, 'checks' => array(), 'template' => array('alertness_template_id' => 1, 'name' => "", 'feature_name' => "", 'briefing_preface' => "", 'briefing_text' => "", 'briefing_accept_button' => "", 'briefing_optout_enabled' => "", 'prompt_title' => "", 'prompt_text' => "", 'prompt_audio_file' => "", 'prompt_duration' => "", 'show_failure_notifications' => "", 'aai_variance' => "", 'aai_starting_boundary' => "", 'aai_ending_boundary' => "", 'aai_setup_delay' => "")),
                'chat' => array('enabled' => true,'messages' => $messages),
                'hostschat' => array('messages' => $messages),
                'jpc' => array('conversations' => array()),
                'presentation' => array('decks' => array(array("uuid"=>"","name"=>"","thumbnail_url"=>'',"slides"=>array("image_url"=>"","index"=>"","notes"=>"",'title'=>"","thumbnail_url"=>"","uuid"=>""))), 'slide_events' => array(array("slide_uuid"=>"","timestamp"=>""))),
                'polling' => array("enabled" => true, "polls" => $polls),
                'questions' => array("enabled"=>true,'submitted'=>$questions),
                'resources'=>array("files"=>$files,'hyperlinks'=>$hyperlinks),
                'charting' => $charting
            );

            $json_array = array("data" => json_encode($create_array), "session_reference" => (int) $result_sessions->sessions_id, "session_id" => (int) $result_sessions->sessions_id, "source" => "gravity");

            $data_to_post = "data=" . json_encode($create_array) . "&session_reference=" . (int) $result_sessions->sessions_id . "&session_id=" . (int) $result_sessions->sessions_id . "&source=gravity"; //if http_build_query causes any problem with JSON data, send this parameter directly in post.

            echo json_encode($create_array);
            return true;
        } else {
            return FALSE;
        }
    }
	
	 function get_flash_report($sessions_id) {
        $this->db->select('*');
        $this->db->from('login_sessions_history l');
        $this->db->join('sessions s', 'l.sessions_id=s.sessions_id');
        $this->db->join('customer_master c', 'c.cust_id=l.cust_id');
        $this->db->where("l.sessions_id", $sessions_id);
        $sessions_history = $this->db->get();
        if ($sessions_history->num_rows() > 0) {
            $return_array = array();
            foreach ($sessions_history->result() as $value) {

                $this->db->select('*');
                $this->db->from('sessions_group_chat_msg');
                $this->db->where(array("sessions_id" => $sessions_id, 'user_id' => $value->cust_id));
                $sessions_group_chat_msg = $this->db->get();
                $messages = 0;
                if ($sessions_group_chat_msg->num_rows() > 0) {
                    $messages = $sessions_group_chat_msg->num_rows();
                }

                $polls = 0;
                $this->db->select('*');
                $this->db->from('tbl_poll_voting');
                $this->db->where(array("sessions_id" => $sessions_id, "cust_id" => $value->cust_id));
                $tbl_poll_voting = $this->db->get();
                if ($tbl_poll_voting->num_rows() > 0) {
                    $polls = $tbl_poll_voting->num_rows();
                }

                $this->db->select('*');
                $this->db->from('sessions_cust_question');
                $this->db->where(array("sessions_id" => $sessions_id, "cust_id" => $value->cust_id));
                $sessions_cust_question = $this->db->get();
                $questions = 0;
                if ($sessions_cust_question->num_rows() > 0) {
                    $questions = $sessions_cust_question->num_rows();
                }

                $value->total_time_new = $this->getTimeSpentOnSession($sessions_id, $value->cust_id);

                $value->total_chat = $messages;
                $value->total_questions = $questions;
                $value->total_polls = $polls;
                $return_array[] = $value;
            }
            return $sessions_history->result();
        } else {
            return "";
        }
    }

    function get_poll($sessions_id) {
        $this->db->select('*');
        $this->db->from('sessions_poll_question s');
        $this->db->join('poll_type p', 's.poll_type_id=p.poll_type_id');
        $this->db->where("s.sessions_id", $sessions_id);
        $sessions_poll_question = $this->db->get();
        $polls = array();
        if ($sessions_poll_question->num_rows() > 0) {
            $presurvey = 0;
            $poll = 0;
            $assessment = 0;
            foreach ($sessions_poll_question->result() as $sessions_poll_question) {
                if ($sessions_poll_question->poll_type_id == 1) {
                    $presurvey = $presurvey + 1;
                    $polls[] = array(
                        'poll_id' => (int) $sessions_poll_question->sessions_poll_question_id,
                        'text' => $sessions_poll_question->poll_type . " " . $presurvey . " : " . $sessions_poll_question->question,
                    );
                } else if ($sessions_poll_question->poll_type_id == 2) {
                    $poll = $poll + 1;
                    $polls[] = array(
                        'poll_id' => (int) $sessions_poll_question->sessions_poll_question_id,
                        'text' => $sessions_poll_question->poll_type . " " . $poll . " : " . $sessions_poll_question->question,
                    );
                } else if ($sessions_poll_question->poll_type_id == 3) {
                    $assessment = $assessment + 1;
                    $polls[] = array(
                        'poll_id' => (int) $sessions_poll_question->sessions_poll_question_id,
                        'text' => $sessions_poll_question->poll_type . " " . $assessment . " : " . $sessions_poll_question->question,
                    );
                }
            }
        }
        return $polls;
    }

    function get_polling_report($sessions_id, $poll_list) {
        $this->db->select('*');
        $this->db->from('login_sessions_history l');
        $this->db->join('customer_master c', 'c.cust_id=l.cust_id');
        $this->db->where("l.sessions_id", $sessions_id);
        $sessions_history = $this->db->get();
        if ($sessions_history->num_rows() > 0) {
            $return_array = array();
            foreach ($sessions_history->result() as $value) {
                if (!empty($poll_list)) {
                    foreach ($poll_list as $val) {
                        $value->polling_answer[] = $this->get_polling_answer($val['poll_id'], $value->cust_id);
                    }
                }
                $return_array[] = $value;
            }
            return $return_array;
        } else {
            return "";
        }
    }

    function get_polling_answer($poll_id, $cust_id) {
        $this->db->select('*');
        $this->db->from('tbl_poll_voting');
        $this->db->where(array("sessions_poll_question_id" => $poll_id, "cust_id" => $cust_id));
        $tbl_poll_voting = $this->db->get();
        if ($tbl_poll_voting->num_rows() > 0) {
            $tbl_poll_voting = $tbl_poll_voting->row();
            $option = $this->db->get_where("poll_question_option", array("poll_question_option_id" => $tbl_poll_voting->poll_question_option_id))->row()->option;
            return $option;
        } else {
            return "";
        }
    }


    private function getTimeSpentOnSession($session_id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('total_time_on_session');
        $this->db->where(array('session_id'=>$session_id, 'user_id'=>$user_id));

        $response = $this->db->get();
        if ($response->num_rows() > 0)
        {
            return $response->result_array()[0]['total_time'];
        }else{
            return 0;
        }

        return;
    }

    private function getModerators($session_id)
    {
        $moderators = array();
        $moderators_id = array();

        $this->db->select('moderator_id');
        $this->db->from('sessions');
        $this->db->where(array('sessions_id'=>$session_id));

        $response = $this->db->get();
        if ($response->num_rows() > 0)
        {
            foreach ($response->result_array() as $row)
            {
                $moderators_id = explode(',', $row['moderator_id']);
            }

            foreach ($moderators_id as $moderator_id)
            {
                $this->db->select('first_name, last_name');
                $this->db->from('presenter');
                $this->db->where(array('presenter_id'=>$moderator_id));

                $response = $this->db->get();
                if ($response->num_rows() > 0)
                {
                    foreach ($response->result_array() as $row)
                    {
                        $moderators[] = $row['first_name'].' '.$row['last_name'];
                    }
                }
            }

            return $moderators;
        }else{
            return 0;
        }

        return;
    }

    function getGroupChatDetailsPresenter($session_id) {

        $presenters = array();
        $groupChatPresenters = array();


        $this->db->select('*');
        $this->db->from('sessions_group_chat');
        $this->db->where('sessions_id',$session_id);
        $groupChat = $this->db->get();
        if ($groupChat->num_rows() > 0) {
            foreach ($groupChat->result_array() as $row)
            {
                $groupChatPresenters = explode(',', $row['presenter_id']);
            }

             foreach ($groupChatPresenters as $presenter_id)
            {
                $this->db->select('first_name, last_name');
                $this->db->from('presenter');
                $this->db->where(array('presenter_id'=>$presenter_id));

                $response = $this->db->get();
                if ($response->num_rows() > 0)
                {
                    foreach ($response->result_array() as $row)
                    {
                        $presenters[] = $row['first_name'].' '.$row['last_name'];
                    }
                }
            }
            
            return $presenters;
        } else {
            return '';
        }
    }


    function getChatAll($session){
        $this->db->select('*');
        $this->db->from('sessions_group_chat');
        $this->db->where('sessions_id',$session);
        $this->db->order_by("group_chat_date", "desc");
        $presenter = $this->db->get();
        if ($presenter->num_rows() > 0) {
            return $presenter->result();
        } else {
            return '';
        }
    }

    private function fixZeroTotalTime($start)
    {

    }

    function delete_all_session_photos($session_id) {

        $set = array(
            'sessions_logo'=>null,
            'sessions_addnl_logo'=>null,
            'sessions_photo'=>null,
        );
      $result= $this->db->update("sessions", $set, array("sessions_id" => $session_id));
       if ($result){
           return true;
       }else
       return false;
    }

    function delete_session_photo($session_id,$session_table) {
        $set = array(
            $session_table=>null,
        );
      $result= $this->db->update("sessions", $set, array("sessions_id" => $session_id));
       if ($result){
                $res=$result;
       }else {
           $res = false;
       }

       return $res;
    }

    function update_json_status($session_id){
        $set=array(
            'send_json_status'=>'1',
        );
        $this->db->update('sessions',$set,  array("sessions_id" =>$session_id));
    }

    // this will check if the json already sent
    function check_send_json_exist($session_id){
        $this->db->select('send_json_status');
        $this->db->from('sessions');
        $this->db->where('sessions_id',$session_id);
        $qstr=$this->db->get();
        if ($qstr->num_rows() > 0) {
              return $qstr->result();
            } 
              return false;
    }

    function getAskRepReport($session_id) {

        $this->db->select("r.date_time,r.session_id,first_name,last_name,r.rep_type,");
        $this->db->from('ask_a_rep r') ;
        $this->db->join('customer_master cm', 'r.user_id = cm.cust_id');
        $this->db->where('session_id',$session_id);
        $result = $this->db->get();
        if($result){
            return $result;
        }else{
            return '';
        }
    }

    // Delete each session end image
    function delete_session_end_image($session_id) {
        $set = array(
            'session_end_image'=>null,
        );
        $result= $this->db->update("sessions", $set, array("sessions_id" => $session_id));
        if ($result){
            $res=$result;
        }else {
            $res = false;
        }

        return $res;
    }


//        this will get the stream names from database
    function getMillicast_Stream_Name(){

        $this->db->select('*');
        $this->db->from('tbl_millicast_stream_names');
        $qstr=$this->db->get();
//            print_r($qstr->result());
        if ($qstr->num_rows() > 0) {
            return $qstr->result();
        }
        return '';
    }

    function saveStreamName($post){
        $stream_name = $post['stream_name'];
        $stream_link = $post['stream_link'];
        $result = $this->db->insert('tbl_millicast_stream_names',array('name'=>$stream_name, 'link'=>$stream_link));
        if($result) {
            return $result;
        }else{
            return '';
        }
    }

    function deleteStreamName($stream_id){
        $this->db->select('*');
        $this->db->from('tbl_millicast_stream_names');
        $this->db->where('id',$stream_id);
        $result = $this->db->delete();

        if($result){
            return $result;

        }else{
            return '';
        }
    }

    function get_stream_name($stream_link){
        if($stream_link)
        {
            $this->db->select('name');
            $this->db->from('tbl_millicast_stream_names');
            $this->db->where('link',$stream_link);
            $result = $this->db->get();

            if($result){
                return $result->result();
            }else{
                return '';
            }
        }else{
            return '' ;
        }

    }

    function moderatorCheckedList(){
        $moderatorList = $this->db->select('*')
            ->get('moderator_checked_list');
        $mod_array = array();
        if($moderatorList->num_rows() > 0){
//            print_r($moderatorList->result());
            foreach ($moderatorList->result() as $res){
                array_push ($mod_array, $res->presenter_id);
            }
            return $mod_array;

        }else{
            return '';
        }
    }

    function addSelectedModerator(){
        $post = $this->input->post();
        if(isset($post['selected_moderator']) && !empty($post['selected_moderator'])) {
            foreach ($post['selected_moderator'] as $list) {
                if ($this->checkSelectedModerator($list)) {
                    $this->db->insert('moderator_checked_list', array('presenter_id' => $list));
                }
            }
            $this->db->where_not_in('presenter_id', $post['selected_moderator']);
            $this->db->delete('moderator_checked_list');


        }else{
            $this->db->truncate('moderator_checked_list');
        }

        if($this->db->affected_rows() > 0){
            return array('status'=>'success');
        }else{
            return array('status'=>'error');
        }
    }

    function checkSelectedModerator($list){
        $result = $this->db->select('*')
            ->where('presenter_id', $list)
            ->get('moderator_checked_list');

        if($result->num_rows()>0){
            return false;
        }
        else{
            return true;
        }
    }

    function getSelectedModerators(){
        $checkedModerators = $this->db->select('*')
            ->join('presenter p','moderator_checked_list.presenter_id = p.presenter_id')
            ->get('moderator_checked_list');
        if($checkedModerators->num_rows() > 0){
            return $checkedModerators->result();
        }else{
            return '';
        }
    }

    function getPresenters() {
        $this->db->select('*');
        $this->db->from('presenter');
        $this->db->order_by('first_name', 'asc');
        $this->db->order_by('last_name', 'asc');
        $presenter = $this->db->get();

        if ($presenter->num_rows() > 0) {
            return $presenter->result();
        } else {
            return '';
        }
    }

    function get_all_resource_logs($session_id){
        $logs_result = $this->db->select('logs.*, CONCAT(cm.first_name, " ",cm.last_name) as attendee')
            ->join('customer_master cm', 'logs.user_id=cm.cust_id', 'left')
            ->where('session_id', $session_id)
            ->get('logs');

        if($logs_result->num_rows()>0){
            return $logs_result->result();
        }else{
            return '';
        }
    }

    function get_all_resource_logs_array($session_id){
        $logs_result = $this->db->select('logs.session_id, logs.file_name, logs.date_time, CONCAT(cm.first_name, " ",cm.last_name) as attendee')
            ->join('customer_master cm', 'logs.user_id=cm.cust_id', 'left')
            ->where('session_id', $session_id)
            ->get('logs');

        if($logs_result->num_rows()>0){
            return $logs_result;
        }else{
            return '';
        }
    }

    function get_unique_downloads($session_id){
        $logs_result = $this->db->select('logs.*, CONCAT(cm.first_name, " ",cm.last_name) as attendee')
            ->join('customer_master cm', 'logs.user_id=cm.cust_id', 'left')
            ->where('session_id', $session_id)
            ->group_by('logs.user_id')
            ->get('logs');

        if($logs_result->num_rows()>0){
            return $logs_result->result();
        }else{
            return '';
        }
    }
//


}
