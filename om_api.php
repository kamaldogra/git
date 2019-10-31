<?php add_action("wpcf7_before_send_mail", "wpcf7_do_something_else");  
function wpcf7_do_something_else($cf7) {
$form_id = $cf7->id();
//define('WP_USE_THEMES', false);
//require_once('../../../../wp-load.php');
global $wpdb;
global $post;
date_default_timezone_set('Asia/Kolkata');
$url = json_decode(file_get_contents("http://ip-api.com/json/".$_SERVER['REMOTE_ADDR']));
$ip = $url->query;
$city = $url->city;
$state = $url->regionName;
$country = $url->country;
$date = date('d-m-Y H:i:s');

$disease = "NA";
if($form_id == "11841"){
	$name = $_POST['your-name'];
	$email = $_POST['your-email'];
	$mobile = $_POST['tel-173'];
	$message = $_POST['your-message'];
}
if($form_id == "11846"){
	$name = $_POST['text-824'];
	$email = $_POST['email-560'];
	$mobile = $_POST['tel-63'];
	$message = $_POST['textarea-451'];
}
if($form_id == "13936"){
	$name = $_POST['your-name'];
	$email = $_POST['your-email'];
	$mobile = $_POST['tel-58'];
	$message = $_POST['your-message'];
}
if($form_id == "11844"){
	$name = "NA";
	$email = $_POST['email-328'];
	$mobile = $_POST['tel-410'];
	$message = "NA";
}
$ch = curl_init();
$data = "name=$name&email=$email&mobile=$mobile&message=$message&disease=$disease&country=$country&city=$city&state=$state&ipaddress=$ip";
curl_setopt($ch, CURLOPT_URL,"http://ndayurveda.info/api/Query/OmPharma");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);
if(isset($server_output)){
  $wpdb_query = $wpdb->insert('lead_logs', array(
        'name' => $name,
        'email' => $email,
        'mobile' => $mobile,
        'message' => $message,
        'disease' => $disease,
        'country' => $country,
        'city' => $city,
        'state' => $state,
        'ip' => $ip,
        'response' => $server_output,
        'form_id' => $form_id,
        'date_time' => $date
    ));	
}
}
?>