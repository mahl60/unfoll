<?php
set_time_limit(0);
ignore_user_abort(1);
error_reporting(0);
session_start();
require_once('fungsi.php');
echo "masukan username : ";
$username = trim(fgets(STDIN));
echo "masukan password : ";
$pass = trim(fgets(STDIN));

		$ua = generate_useragent();
		$devid = generate_device_id();
		$login = proccess(1, $ua, 'accounts/login/', 0, hook('{"device_id":"'.$devid.'","guid":"'.generate_guid().'","username":"'.$username.'","password":"'.$pass.'","Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}'));
		$data = json_decode($login[1]);
		preg_match_all('%Set-Cookie: (.*?);%',$login[0],$d);$cookie = '';
			for($o=0;$o<count($d[0]);$o++)$cookie.=$d[1][$o].";";
                        $data= array('cookies' => $cookie, 'useragent' => $ua, 'device_id' => $devid, 'username' => $data->logged_in_user->username, 'id' => $data->logged_in_user->pk);

//print_r($data);
$cookies= $data['cookies'];
$useragent= $data['useragent'];
$device_id= $data['device_id'];
$username= $data['username'];
$id= $data['id'];

$data = "$"."_SESSION['data'] = array('cookies' => "."'$cookies'".", "."'useragent' => "."'$useragent'".", "."'device_id' => "."'$device_id'".", "."'username' => "."'$username'".", "."'id' => "."'$id'".");";



echo file_put_contents("hasil.txt",$data);






//echo "INSERT INTO `instagram` (`id`, `cookies`, `useragent`, `device_id`, `verifikasi`, `poin`, `username`, `passwd`) VALUES
//('"."$id"."', '"."$cookies"."', '"."$useragent"."', '"."$device_id"."', '0', '3', '"."$udername."."', '.RACHMAT98.')";



?>
