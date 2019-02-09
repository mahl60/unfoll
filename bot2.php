<?php
header("Refresh:300");
set_time_limit(100);
error_reporting(0);
ignore_user_abort(1);
session_start();
require_once('fungsi.php');
$TimeZone="+7";
$_time=gmdate("H", time() + ($TimeZone * 60 * 60));
$_SESSION['data'] = array('cookies' => 'ds_user=jual_igfollow02;shbid=18600;shbts=1544840502.5683231;rur=FRC;mid=XBRlNQABAAGwnMe1AZjye8xcxmfU;ds_user_id=8538678537;urlgen="{\"36.80.219.45\": 17974}:1gXzaI:wRr--jQVuZqxBPldUTbj1MJDQw0";sessionid=IGSCf0aedd84303a35371d2f00ad7467443408b9b2b940bb11b277ae07694b924220%3A3cD2zQCvXjKohfh9lymBl3gFh3uw9UTn%3A%7B%22_auth_user_id%22%3A8538678537%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22_auth_user_hash%22%3A%22%22%2C%22_platform%22%3A1%2C%22_token_ver%22%3A2%2C%22_token%22%3A%228538678537%3AQMprjMekFkL4QC6DATHIAMB1xrNlF3dk%3A9027acbbd833292d980b2b79637b3c75e5de5e2aa16f98fd0e0646486cddf84b%22%2C%22last_refreshed%22%3A1544840502.5691144466%7D;mcd=3;csrftoken=Iieoai4Gc1FGnFgHBI6VGiMwbjplWFRm;', 'useragent' => 'Instagram 6.22.0 Android (10/1.5.2; 320; 1280x720; samsung; GT-N7000; GT-N7000; smdkc210; en_US)', 'device_id' => 'android-1074cf6dee6fd3a453ea3fa9d190a4304', 'username' => 'jual_igfollow02', 'id' => '8538678537');
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
        $jumlah= "200";
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
?>
