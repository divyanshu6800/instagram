<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class User extends CI_finecontrol{
function __construct()
{
	parent::__construct();
	$this->load->model("login_model");
	$this->load->model("admin/base_model");
	$this->load->library('user_agent');
	$this->load->library("upload");
}

public function register(){
    $this->load->helper(array('form', 'url'));
  	$this->load->library('form_validation');
  	$this->load->helper('security');
  	if($this->input->post())
  	{
  	$this->form_validation->set_rules('name', 'Name', 'required|xss_clean|trim');
  	$this->form_validation->set_rules('username', 'Username', 'required|xss_clean|trim|is_unique[tbl_users.username]|is_unique[tbl_users.phone]|is_unique[tbl_users.email]');
  	$this->form_validation->set_rules('phone', 'Phone', 'required|xss_clean|trim|is_unique[tbl_users.username]|is_unique[tbl_users.phone]|is_unique[tbl_users.email]');
  	$this->form_validation->set_rules('email', 'Email', 'required|xss_clean|trim|is_unique[tbl_users.username]|is_unique[tbl_users.phone]|is_unique[tbl_users.email]');
  	$this->form_validation->set_rules('password', 'Password', 'required|xss_clean|trim');

  		if($this->form_validation->run()== TRUE)
  		{
         $name=$this->input->post('name');
         $username=$this->input->post('username');
         $phone=$this->input->post('phone');
         $email=$this->input->post('email');
         $password=md5($this->input->post('password'));
         $ip = $this->input->ip_address();
				 $followers = [];
				 $following = [];
				 $friend_requests = [];
         date_default_timezone_set("Asia/Calcutta");
         $cur_date=time();
         $register_user = array('name' => $name, 'phone' => $phone, 'username' => $username, 'email' => $email, 'followers' => serialize($followers), 'following' => serialize($following), 'friend_requests' => serialize($friend_requests), 'password' => $password, 'date' => $cur_date, 'ip' => $ip);
         $insert_data = $this->base_model->insert_table("tbl_users", $register_user, 1);
         if($insert_data != 0){
					 $this->session->set_userdata('user_data', 1);
					 $this->session->set_userdata('user_id', $insert_data);
					 $this->session->set_userdata('username', $username);
           $this->session->set_flashdata('smessage', 'Registered Successfully! <a href="'.base_url().'User/profile">Complete Profile</a>');
           redirect('Home/feed');
         }else{
           $this->session->set_flashdata('emessage', 'Some error occurred');
           redirect($_SERVER['HTTP_REFERER']);
         }
      } else {
          $this->session->set_flashdata('emessage', validation_errors());
          redirect($_SERVER['HTTP_REFERER']);
      }
  } else {
      $this->session->set_flashdata('emessage', 'Please insert some data, No data available');
      redirect($_SERVER['HTTP_REFERER']);
  }
}

public function login(){
	  $this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->helper('security');
		if($this->input->post())
		{
		$this->form_validation->set_rules('email', 'required|email', 'xss_clean|trim');
		$this->form_validation->set_rules('password', 'required|password', 'xss_clean|trim');


			if($this->form_validation->run()== TRUE)
			{
	       $email=$this->input->post('email');
	       $password=$this->input->post('password');
				 $user_data = $this->db->get_where('tbl_users', array('email' => $email))->result();
				 if(empty($user_data)){
					 $user_data = $this->db->get_where('tbl_users', array('phone' => $email))->result();
				 }
				 if(empty($user_data)){
					 $user_data = $this->db->get_where('tbl_users', array('username' => $email))->result();
				 }
				 if(!empty($user_data)){
					 if($user_data[0]->password==md5($password)){
					 $this->session->set_userdata('user_data', 1);
					 $this->session->set_userdata('user_id', $user_data[0]->id);
					 $this->session->set_userdata('username', $user_data[0]->username);
           $this->session->set_flashdata('smessage', 'Logged in Successfully');
           redirect('Home/feed');
				 }else{
					 $this->session->set_flashdata('emessage', 'Incorrect password! <a href="'.base_url().'Home/register">Forgot password?</a>');
 	        redirect($_SERVER['HTTP_REFERER']);
				 }
				 }else{
					 $this->session->set_flashdata('emessage', 'Account does not exist! <a href="'.base_url().'Home/register">Create one?</a>');
 	        redirect($_SERVER['HTTP_REFERER']);
				 }
	    } else {
	        $this->session->set_flashdata('emessage', validation_errors());
	        redirect($_SERVER['HTTP_REFERER']);
	    }
	} else {
	    $this->session->set_flashdata('emessage', 'Please insert some data, No data available');
	    redirect($_SERVER['HTTP_REFERER']);
	}
}

	// ====================================== PROFILE ====================================================
	public function profile(){
		if(!empty($this->session->userdata('user_data'))){
		$user_id = $this->session->userdata('user_id');
		$data['user_data'] = $this->db->get_where('tbl_users', array('id' => $user_id))->result();
		$data['posts_data'] = $this->db->get_where('tbl_posts', array('user_id' => $user_id));
		$user_data = $data['user_data'];
		$following = unserialize($user_data[0]->following);
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('id != ', $user_id);
		$this->db->order_by('rand()');
		$data['sugestions_data']= $this->db->limit(7)->get();
		$data['navpage'] = 'User';
	$this->load->view('header', $data);
	$this->load->view('profile');
	$this->load->view('footer');
	}else{
		redirect('/', 'refresh');
	}
	}

	// ====================================== PROFILE ====================================================
	public function stories(){
		if(!empty($this->session->userdata('user_data'))){
		$user_id = $this->session->userdata('user_id');
		$data['user_data'] = $this->db->get_where('tbl_users', array('id' => $user_id))->result();
		$data['posts_data'] = $this->db->get_where('tbl_stories', array('user_id' => $user_id));
		$user_data = $data['user_data'];
		$following = unserialize($user_data[0]->following);
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('id != ', $user_id);
		$this->db->order_by('rand()');
		$data['sugestions_data']= $this->db->limit(7)->get();
		$data['navpage'] = 'User';
	$this->load->view('header', $data);
	$this->load->view('stories');
	$this->load->view('footer');
	}else{
		redirect('/', 'refresh');
	}
	}

	// ===================================== UPDATE PROFILE =================================
	public function edit_profile(){
		  $this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->load->helper('security');
			if($this->input->post())
			{
			$this->form_validation->set_rules('bio', 'bio', 'xss_clean|trim');
			$this->form_validation->set_rules('name', 'name', 'xss_clean|trim');
				if($this->form_validation->run()== TRUE)
				{
		       $bio=$this->input->post('bio');
		       $name=$this->input->post('name');
					 $nnnn = '';
					 $img1='image';
				 		$file_check=($_FILES['image']['error']);
				 		if($file_check!=4){
				 		$image_upload_folder = FCPATH . "assets/uploads/stories/";
				 			if (!file_exists($image_upload_folder))
				 			{
				 				mkdir($image_upload_folder, DIR_WRITE_MODE, true);
				 			}
				 			$new_file_name="user".date("Ymdhms");
				 			$this->upload_config = array(
				 					'upload_path'   => $image_upload_folder,
				 					'file_name' => $new_file_name,
				 					'allowed_types' =>'jpg|jpeg|png',
				 					'max_size'      => 25000
				 			);
				 			$this->upload->initialize($this->upload_config);
				 			if (!$this->upload->do_upload($img1))
				 			{
				 				$upload_error = $this->upload->display_errors();
				 			}else{
				 				$file_info = $this->upload->data();
				 				$videoNAmePath = "assets/uploads/stories/".$new_file_name.$file_info['file_ext'];
				 				$nnnn = $videoNAmePath;
				 			}
				 		}
						$user_data = $this->db->get_where('tbl_users', array('id' => $this->session->userdata('user_id')))->result();
						if(empty($nnnn)){
							$profile_image = $user_data[0]->image;
						}else{
							$profile_image = $nnnn;
						}
						$likes = [];
						$updateProfile = array('name' => $name, 'image' => $profile_image, 'bio'=>$bio);
						$this->db->where('id', $user_data[0]->id);
						$zapak2 = $this->db->update('tbl_users', $updateProfile);
						$this->session->set_flashdata('smessage', 'Profile Updated');
		        redirect('User/profile', 'refresh');
		    } else {
		        $this->session->set_flashdata('emessage', validation_errors());
		        redirect($_SERVER['HTTP_REFERER']);
		    }
		} else {
		    $this->session->set_flashdata('emessage', 'Please insert some data, No data available');
		    redirect($_SERVER['HTTP_REFERER']);
		}
	}


public function logout(){
	$this->session->unset_userdata('user_data');
	$this->session->unset_userdata('user_id');
	$this->session->unset_userdata('username');
	redirect('/');
}

}
