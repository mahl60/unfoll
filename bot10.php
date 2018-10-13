<?php
set_time_limit(100);
error_reporting(0);
ignore_user_abort(1);
session_start();
require_once('fungsi.php');
$TimeZone="+7";
$_time=gmdate("H", time() + ($TimeZone * 60 * 60));
$_SESSION['data'] = array('cookies' => 'ds_user=jual_igfollow10;rur=PRN;mid=W8HjXwABAAFC43JSjjhquvzPa-oB;ds_user_id=8703308377;urlgen="{\"180.246.175.59\": 17974}:1gBIvY:y9aJ8nuagNOcWKfjHBpru6rt3Y8";sessionid=IGSCb7254a823c66ea1fa3782b0a55830579735691cac8a3a8174fd5ce0685a127be%3AK5aF7UjJdrjGeLDNetcN4XxdnoQ3s1YO%3A%7B%22_auth_user_id%22%3A8703308377%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22_auth_user_hash%22%3A%22%22%2C%22_platform%22%3A1%2C%22_token_ver%22%3A2%2C%22_token%22%3A%228703308377%3AjQw2gltBfMQzbZwKoAdez2M3tZAJce7E%3A8b85f01ed34d17cbc82de8894912a22923859beda3025125397d2fbacdae5637%22%2C%22last_refreshed%22%3A1539433312.7267782688%7D;mcd=3;csrftoken=5lXXrCZK2qiDgGFthoh8mvZVu1Xll0IJ;', 'useragent' => 'Instagram 6.22.0 Android (11/3.3.5; 240; 480x320; samsung; SM-N9000; SM-N9000; smdkc210; en_US)', 'device_id' => 'android-ca0daec69b5adc880fb464895726dbdf6', 'username' => 'jual_igfollow10', 'id' => '8703308377');
while(true){
	if($_time>7){
      $jumlah= "9";
        $_POST['tipe'] = "followers";
        $target = "24239929";
	$data_session = $_SESSION['data'];
	$getinfo = proccess(1, $data_session['useragent'], 'users/'.$target.'/info/');
	$getinfo = json_decode($getinfo[1]);
	if($_POST['tipe']=='followers'):
		if(!is_numeric($jumlah))
			$limit = 1;
		elseif($jumlah>($getinfo->user->follower_count-1))
			$limit = $getinfo->user->follower_count-1;
		else
			$limit = $jumlah-1;
		$tipe = 'followers';
	else:
		if(!is_numeric($jumlah))
			$limit = 1;
		elseif($jumlah>($getinfo->user->follower_count-1))
			$limit = $getinfo->user->follower_count-1;
		else
			$limit = $jumlah-1;
		$tipe = 'followers';
	endif;
	$c = 0;
	$listids = array();
	do{
		$parameters = ($c>0) ? '?max_id='.$c : '';
		$req = proccess(1, $data_session['useragent'], 'friendships/'.$target.'/'.$tipe.'/'.$parameters, $data_session['cookies']);
		$req = json_decode($req[1]);
		for($i=0;$i<count($req->users);$i++):
			if(count($listids)<=$limit)
				$listids[count($listids)] = $req->users[$i]->pk;
		endfor;
		$c = (isset($req->next_max_id)) ? $req->next_max_id : 0;
	}while(count($listids)<=$limit);
	for($i=0;$i<count($listids);$i++):
			$cross = proccess(1, $data_session['useragent'], 'friendships/create/'.$listids[$i].'/', $data_session['cookies'], hook('{"user_id":"'.$listids[$i].'"}'));
			$cross = json_decode($cross[1]);
			print $i.'. <b>@'.$data_session['username'].' Follow => '.$listids[$i].PHP_EOL;
			flush();
	endfor;
}
else
{
        $jumlah= "9";
        $_POST['tipe'] = "following";
	$target = $_SESSION['data']['id'];
	$data_session = $_SESSION['data'];
	$getinfo = proccess(1, $data_session['useragent'], 'users/'.$target.'/info/');
	$getinfo = json_decode($getinfo[1]);
	if($_POST['tipe']=='following'):
		if(!is_numeric($jumlah))
			$limit = 1;
		elseif($jumlah>($getinfo->user->following_count-1))
			$limit = $getinfo->user->following_count-1;
		else
			$limit = $jumlah-1;
		$tipe = 'following';
	else:
		if(!is_numeric($jumlah))
			$limit = 1;
		elseif($jumlah>($getinfo->user->follower_count-1))
			$limit = $getinfo->user->follower_count-1;
		else
			$limit = $jumlah-1;
		$tipe = 'followers';
	endif;
	$c = 0;
	$listids = array();
	do{
		$parameters = ($c>0) ? '?max_id='.$c : '';
		$req = proccess(1, $data_session['useragent'], 'friendships/'.$target.'/'.$tipe.'/'.$parameters, $data_session['cookies']);
		$req = json_decode($req[1]);
		for($i=0;$i<count($req->users);$i++):
			if(count($listids)<=$limit)
				$listids[count($listids)] = $req->users[$i]->pk;
		endfor;
		$c = (isset($req->next_max_id)) ? $req->next_max_id : 0;
	}while(count($listids)<=$limit);
	for($i=0;$i<count($listids);$i++):
			$cross = proccess(1, $data_session['useragent'], 'friendships/destroy/'.$listids[$i].'/', $data_session['cookies'], hook('{"user_id":"'.$listids[$i].'"}'));
			$cross = json_decode($cross[1]);
			print $i.'. <b>@'.$data_session['username'].'</b> <font color="green">Sukses Follow => </font><b style="color:gray;">[ @'.$listids[$i].' ]</b><br>';
			flush();
	endfor;
}
	
	sleep(250);
	
}
?>
