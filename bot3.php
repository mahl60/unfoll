<?php
header("Refresh:300");
set_time_limit(100);
error_reporting(0);
ignore_user_abort(1);
session_start();
require_once('fungsi.php');
$TimeZone="+7";
$_time=gmdate("H", time() + ($TimeZone * 60 * 60));
$_SESSION['data'] = array('cookies' => 'ds_user=jual_igfollow03;shbid=18600;shbts=1544840616.9173028;rur=FRC;mid=XBRlqAABAAExRX9cjiMcVIGlIBPw;ds_user_id=8550178570;urlgen="{\"36.80.219.45\": 17974}:1gXzc8:znUkrOslYHAGiQYD9vUHa9fCDwQ";sessionid=IGSCb402bc5c9ce106e2753170520f8a8ec997a5cbe599ddf0a23560f45c5d44e267%3Ays1qmn2JkpTYVyVFws3BT19dprRqYjY6%3A%7B%22_auth_user_id%22%3A8550178570%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22_auth_user_hash%22%3A%22%22%2C%22_platform%22%3A1%2C%22_token_ver%22%3A2%2C%22_token%22%3A%228550178570%3AcBFXXEem9NC0l9idsDWSrjmGcOi1sdiA%3Ae67584583da79091c0a6b0c6340ada49e772a1f4d7421ae273647ca2b2c35408%22%2C%22last_refreshed%22%3A1544840616.9181587696%7D;mcd=3;csrftoken=aWO4JSn6Bhkr0yW8VETqmgnXyzq3zTsa;', 'useragent' => 'Instagram 6.22.0 Android (11/3.4.3; 240; 320x480; samsung; GT-N7000; GT-N7000; smdkc210; en_US)', 'device_id' => 'android-c7d0e7e2922845f3e1185d246d01365d8', 'username' => 'jual_igfollow03', 'id' => '8550178570');
if($_time>23){
      $jumlah= "30";
        $_POST['tipe'] = "followers";
        $target = "522969993";
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
			print $i.'. <b>@'.$data_session['username'].'</b> <font color="green">Sukses Follow => </font><b style="color:gray;">[ @'.$listids[$i].' ]</b><br>';
			flush();
	endfor;
}
else
{
        $jumlah= "11";
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
	 sleep(240);
}
?>
