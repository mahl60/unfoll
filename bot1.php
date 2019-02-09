<?php
set_time_limit(100);
error_reporting(0);
ignore_user_abort(1);
session_start();
require_once('fungsi.php');
$TimeZone="+7";
$_time=gmdate("H", time() + ($TimeZone * 60 * 60));
$_SESSION['data'] = array('cookies' => 'ds_user=jual_igfollow01;shbid=18600;shbts=1548920846.1096637;rur=PRN;mid=XFKoDQABAAFNHcAMUTtL2nUylFnZ;ds_user_id=8429117661;urlgen="{\"36.84.0.24\": 17974}:1gp74I:3-26Wo7uyynRtIgwnyQLa6YQ9r0";sessionid=8429117661%3AX8tfgbyS7VaiPv%3A29;csrftoken=rC9gFd5VvjVX5mlPOYQUj2NnISgVXWcT;', 'useragent' => 'Instagram 6.22.0 Android (11/2.5.5; 240; 1080x1920; samsung; GT-N7000; GT-N7000; smdkc210; en_US)', 'device_id' => 'android-358c850b3836ae02b1d8b319d86d435f2', 'username' => 'jual_igfollow01', 'id' => '8429117661');
$xx = 0;
while(true){
	if($_time>23){
      $jumlah= "10";
        $_POST['tipe'] = "followers";
        $target = "7684785";
	$data_session = $_SESSION['data'];
	$getinfo = proccess(1, $data_session['useragent'], 'users/'.$target.'/info/',$data_session['cookies']);
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
			print $xx++.'. <b>@'.$data_session['username'].' Follow => '.$listids[$i]." ".$cross->status.PHP_EOL;
			flush();
     
	endfor;
	 sleep(240);
}
else
{
        $jumlah= "10";
        $_POST['tipe'] = "following";
	$target = $_SESSION['data']['id'];
	$data_session = $_SESSION['data'];
	$getinfo = proccess(1, $data_session['useragent'], 'users/'.$target.'/info/',$data_session['cookies']);
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
			print $i.'. <b>@'.$data_session['username'].' UnFollow => '.$listids[$i].PHP_EOL;
			flush();
			sleep(250);
	endfor;
}
	
	
	
}
?>
