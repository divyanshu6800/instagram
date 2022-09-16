<?php
/*
* Instagram API Class
* This class helps to authenticate with Instagram API
*/
class InstagramAuth {
public $client_id = '815483799876102';
public $client_secret = 'cfbf4e538cf7a85f8d7f976688808908';
public $redirect_url = 'https://localhost/instagram/InstagramAuth/getAccessToken/';
private $act_url = 'https://api.instagram.com/oauth/access_token';
private $ud_url = 'https://api.instagram.com/v1/users/self/';
public function __construct(array $config = array()){
$this->initialize($config);
}
public function initialize(array $config = array()){
foreach ($config as $key => $val){
if (isset($this->$key)){
$this->$key = $val;
}
}
return $this;
}
public function getAuthURL(){
$authURL = "https://api.instagram.com/oauth/authorize/?client_id=815483799876102&redirect_uri=" .urlencode('https://localhost/instagram/InstagramAuth/getAccessToken/') . "&response_type=code&scope=user_profile,user_media";
return $authURL;
}
public function getAccessToken() {
$code = $_GET['code'];
$urlPost = 'client_id='. $this->client_id . '&client_secret=' . $this->client_secret . '&grant_type=authorization_code&redirect_uri=' . $this->redirect_url . '&code='. $code;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.instagram.com/oauth/access_token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $urlPost);
$data = json_decode(curl_exec($ch), true);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
if($http_code != '200'){
throw new Exception('Error : Failed to receive access token '.$http_code);
}
$this->getUserProfileInfo($data['user_id'], $data['access_token']);
// $this->getUserProfileInfo($data['access_token']);
}
public function getUserProfileInfo($user_id, $access_token) {
$url = 'https://graph.instagram.com/v11.0/'.$user_id.'?fields=id,username&access_token=' . $access_token;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
$data = json_decode(curl_exec($ch), true);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
if($http_code != 200){
throw new Exception('Error : Failed to get user information');
}
print_r($data);
}
}
