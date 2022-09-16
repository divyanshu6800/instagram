<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
function __construct()
		{
			parent::__construct();
			$this->load->model("admin/login_model");
			$this->load->model("admin/base_model");
			$this->load->library("upload");
		}

public function index()
	{
		if(!empty($this->session->userdata('user_data'))){
			redirect('Home/feed');
		}else{
			$this->load->view('beforeheader');
			$this->load->view('index');
			$this->load->view('beforefooter');
		}
	}

public function register()
	{
		if(!empty($this->session->userdata('user_data'))){
			redirect('Home/feed');
		}else{
			$this->load->view('beforeheader');
			$this->load->view('register');
			$this->load->view('beforefooter');
		}
	}

	// ===================================== INSTAGRAM FEED =======================================
	public function feed()
		{
			if(!empty($this->session->userdata('user_data'))){
				$data['user_data'] = $this->db->get_where('tbl_users', array('id' => $this->session->userdata('user_id')))->result();
				$user_data = $data['user_data'];
				$main_feed = [];
				$stories_top = [];
				$following = unserialize($user_data[0]->following);
				foreach($following as $friends){
					$friend_data = $this->db->get_where('tbl_users', array('id' => $friends))->result();
					if(!empty($friend_data)){
						$posts = $this->db->get_where('tbl_posts', array('user_id' => $friend_data[0]->id));
						foreach($posts->result() as $enter_posts){
							array_push($main_feed, $enter_posts);
						}
						$story = $this->db->get_where('tbl_stories', array('user_id' => $friend_data[0]->id, 'deleted' => 0));
						foreach($story->result() as $enter_story){
							array_push($stories_top, $enter_story);
						}
					}
				}
				$this->db->select('*');
				$this->db->from('tbl_users');
				$this->db->where('id != ', $this->session->userdata('user_id'));
				$this->db->order_by('rand()');
				$data['sugestions_data']= $this->db->limit(7)->get();
				$data['stories'] = $stories_top;
				$data['main_feed'] = $main_feed;
				$data['navpage'] = 'Home';
				$this->load->view('header', $data);
				$this->load->view('feed');
				$this->load->view('footer');
			}else{
				redirect('/', 'refresh');
			}
		}

	// ====================================== FOLLOW PEOPLE ====================================================
	public function follow($person){
		if(!empty($this->session->userdata('user_data'))){
			$user_data = $this->db->get_where('tbl_users', array('id' => $this->session->userdata('user_id')))->result();
			$person_data = $this->db->get_where('tbl_users', array('id' => $person))->result();
			$user_following = unserialize($user_data[0]->following);
			$person_followers = unserialize($person_data[0]->followers);
			array_push($user_following, $person_data[0]->id);
			array_push($person_followers, $user_data[0]->id);

			$this->db->where('id', $user_data[0]->id);
			$zapak = $this->db->update('tbl_users', array('following' => serialize($user_following)));

			$this->db->where('id', $person_data[0]->id);
			$zapak2 = $this->db->update('tbl_users', array('followers' => serialize($person_followers)));

			$data['status'] = true;
			$data['message'] = 'You are now following '.$person_data[0]->name;
			echo json_encode($data);
		}else{
			redirect('/', 'refresh');
		}
	}

	// ======================================= UNFOLLOW PEOPLE ================================================
	public function unfollow($person){
		if(!empty($this->session->userdata('user_data'))){
			$user_data = $this->db->get_where('tbl_users', array('id' => $this->session->userdata('user_id')))->result();
			$person_data = $this->db->get_where('tbl_users', array('id' => $person))->result();
			$user_following = unserialize($user_data[0]->following);
			$person_followers = unserialize($person_data[0]->followers);
			if (($userKey = array_search($person_data[0]->id, $user_following)) !== false) {
			    array_splice($user_following, $userKey);
			}
			if (($perKey = array_search($user_data[0]->id, $person_followers)) !== false) {
			    array_splice($person_followers, $perKey);
			}
			// print_r($user_following);exit;

			$this->db->where('id', $user_data[0]->id);
			$zapak = $this->db->update('tbl_users', array('following' => serialize($user_following)));

			$this->db->where('id', $person_data[0]->id);
			$zapak2 = $this->db->update('tbl_users', array('followers' => serialize($person_followers)));

			$data['status'] = true;
			$data['message'] = 'Unfollowed '.$person_data[0]->name;
			echo json_encode($data);
		}else{
			redirect('/', 'refresh');
		}
	}

// ========================= SEARCH USERS ======================================================
	public function search($search){
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->like('username', $search);
		// $this->db->or_like('name', $search);
		$user_data = $this->db->get();
		$searchResults = [];
		foreach($user_data->result() as $user){
			$tempArray = array("id" => $user->id, "name" => $user->name, "username" => $user->username);
			array_push($searchResults, $tempArray);
		}
		$resp['message'] = 'results';
		$resp['searchresults'] = $searchResults;
		echo json_encode($resp);
	}

// ======================= ADD STORY ==============================
	public function add_story(){
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
          $this->session->set_flashdata('emessage',$upload_error);
             redirect($_SERVER['HTTP_REFERER']);
				}else{
					$file_info = $this->upload->data();
					$videoNAmePath = "assets/uploads/stories/".$new_file_name.$file_info['file_ext'];
					$nnnn=$videoNAmePath;
				}
      }
			$cur_date=time();
			$post_story = array('user_id' => $this->session->userdata('user_id'), 'image' => $nnnn, 'date' => $cur_date, 'deleted' => 0);
			$insert_data = $this->base_model->insert_table("tbl_stories", $post_story, 1);
			if($insert_data != 0){
				$this->session->set_flashdata('smessage','Story Posted :)');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('emessage','Some unknown error occurred :(');
				redirect($_SERVER['HTTP_REFERER']);
			}
	}

	public function add_post(){
		  $this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->load->helper('security');
			if($this->input->post()){
			$this->form_validation->set_rules('caption', 'caption', 'xss_clean|trim');
				if($this->form_validation->run()== TRUE)
				{
		       $caption=$this->input->post('caption');
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
				 				$this->session->set_flashdata('emessage',$upload_error);
				 					 redirect($_SERVER['HTTP_REFERER']);
				 			}else{
				 				$file_info = $this->upload->data();
				 				$videoNAmePath = "assets/uploads/stories/".$new_file_name.$file_info['file_ext'];
				 				$nnnn=$videoNAmePath;
				 			}
				 		}
						$likes = [];
						$post_story = array('user_id' => $this->session->userdata('user_id'), 'image' => $nnnn, 'caption'=>$caption, 'likes'=>serialize($likes), 'date' => time());
						$insert_data = $this->base_model->insert_table("tbl_posts", $post_story, 1);
						$this->session->set_flashdata('smessage', 'Posted :)');
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

	public function test()
		{
				$this->load->view('errors/test');

		}

	public function inbox($username=""){
		if(!empty($this->session->userdata('user_data'))){
		$data['navpage'] = "Inbox";
		if(!empty($username)){
			$user_id = $this->session->userdata('user_id');
			$friend_data = $this->db->get_where('tbl_users', array('username' => $username))->result();
			$check_conversations = $this->db->get_where('tbl_conversations', array('request' => $user_id, 'receive'=>$friend_data[0]->id))->result();
			if(empty($check_conversations)){
				$check_conversations = $this->db->get_where('tbl_conversations', array('receive' => $user_id, 'request'=>$friend_data[0]->id))->result();
			}
			if(!empty($check_conversations)){
				$data['chats'] = $this->db->order_by('id', 'aesc')->get_where('tbl_message', array('convo_id' => $check_conversations[0]->id));
				$data['friend_data'] = $friend_data;
			}else{
				$insert = array('request'=>$user_id, 'receive'=>$friend_data[0]->id, 'date'=>time());
				$insert_data = $this->base_model->insert_table("tbl_conversations", $insert, 1);
				$data['chats'] = $this->db->get_where('tbl_message', array('convo_id' => $insert_data));
				$data['friend_data'] = $friend_data;
			}
			$user_data = $this->db->get_where('tbl_users', array('id' => $this->session->userdata('user_id')))->result();
			$data['following'] = unserialize($user_data[0]->following);
			$data['user_data'] = $user_data;
			$this->load->view('header', $data);
			$this->load->view('inbox');
			$this->load->view('footer');
		}else{
			$user_data = $this->db->get_where('tbl_users', array('id' => $this->session->userdata('user_id')))->result();
			$data['following'] = unserialize($user_data[0]->following);
			$data['chats'] = '';
			$data['user_data'] = $user_data;
			$this->load->view('header', $data);
			$this->load->view('inbox');
			$this->load->view('footer');
		}
	}else{
		redirect('/', 'refresh');
	}
	}

	public function send_message(){
		  $this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->load->helper('security');
			if($this->input->post())
			{
			$this->form_validation->set_rules('friend_id', 'friend_id', 'required|xss_clean|trim');
			$this->form_validation->set_rules('message', 'message', 'required|xss_clean|trim');

				if($this->form_validation->run()== TRUE)
				{
		       $friend_id=$this->input->post('friend_id');
		       $message=$this->input->post('message');
					 $user_id = $this->session->userdata('user_id');
		 			$check_conversations = $this->db->get_where('tbl_conversations', array('request' => $user_id, 'receive'=>$friend_id))->result();
		 			if(empty($check_conversations)){
		 				$check_conversations = $this->db->get_where('tbl_conversations', array('receive' => $user_id, 'request'=>$friend_id))->result();
		 			}
					$insert = array('convo_id'=>$check_conversations[0]->id, 'send'=>$user_id, 'content'=>$message, 'date'=>time());
					$insert_data = $this->base_model->insert_table("tbl_message", $insert, 1);
					echo 1;
		    } else {
		        $this->session->set_flashdata('emessage', validation_errors());
		        redirect($_SERVER['HTTP_REFERER']);
		    }
		} else {
		    $this->session->set_flashdata('emessage', 'Please insert some data, No data available');
		    redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function like_post($post_id){
		$user_id = $this->session->userdata('user_id');
		$post_data = $this->db->get_where('tbl_posts', array('id' => $post_id))->result();
		$likes_array = unserialize($post_data[0]->likes);
		if(in_array($user_id, $likes_array)){
			if (($userKey = array_search($user_id, $likes_array)) !== false) {
					array_splice($likes_array, $userKey);
			}
		}else{
			array_push($likes_array, $user_id);
		}
			$this->db->where('id', $post_id);
			$zapak = $this->db->update('tbl_posts', array('likes' => serialize($likes_array)));
			echo 1;
	}

	// ==================================== NOTIFICATIONS AND FRIEND REQUESTS ===============================
	public function notifications(){
		if(!empty($this->session->userdata('user_data'))){
		$data['user_data'] = $this->db->get_where('tbl_users', array('id' => $this->session->userdata('user_id')))->result();
		$data['requests'] = unserialize($data['user_data'][0]->friend_requests);
		$data['navpage'] = "Notifications";
		$this->load->view('header', $data);
		$this->load->view('notifications');
		$this->load->view('footer');
	}else{
		redirect('/');
	}
	}

	public function error404()
		{
				$this->load->view('errors/error404');

		}

}
