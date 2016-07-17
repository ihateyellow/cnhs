<?php
	// allow cross browser
	header('Access-Control-Allow-Origin: *');

	if(!empty($_POST['type'])){
		if (!defined("KANASHII")){  define('KANASHII', true); }
	
	// path management
	define("DS","/");
	define('ROOT','cnhs'.DS);
	define('BASE_ROOT',$_SERVER['DOCUMENT_ROOT'].DS.ROOT);
	define('LIBS',$_SERVER['DOCUMENT_ROOT'].DS.ROOT.'server'.DS);

	// session management
	if(session_status() != PHP_SESSION_ACTIVE){
		if(!isset($_SESSION['active'])){
			@session_start();
			$_SESSION['active'] = 1;
		}	
	}

	// configuration manegement 
	if(file_exists(LIBS.'config.php')){
		require_once(LIBS.'config.php');
	}
	
	// library management
	if(file_exists(LIBS.'db.php')){
		require_once(LIBS.'db.php');
		$db = new db();
	}
	$rs = [];
	$p = $_POST;
	$type = $p['type'];
	switch($type){
		 case 'login':
			$rs['account'] = $db->GetAll("SELECT * FROM `users` WHERE `username` = '". $db->clean($p['username']) ."' AND `password` = '". md5($db->clean($p['password'])) ."' AND `status` = 'active' LIMIT 1");
		 break;

		 case 'getAllUser':
		 	$rs['users'] = $db->GetAll("SELECT * FROM `users`");
		 break;

		 case 'getUserData':
		 	$rs['account'] =   $db->GetAll("SELECT * FROM `users` WHERE `userid` = '". $db->clean($p['userid']) ."' LIMIT 1");
		 break;

		 case 'addAcount':

		 	$rs['check'] = $db->GetOne("SELECT count(1) FROM `users` WHERE `username` = '". $p['username'] ."' ");

		 	if((int)$rs['check'] === 0 ){
				// do insert 
				$rs['add'] = $db->exec("INSERT INTO `users` SET 
		 				`userid` = null,
		 				`username`  = '". $p['username'] ."',
		 				`password`  = '". md5($p['password']) ."',
		 				`userrole`  = '". $p['userrole'] ."',
		 				`name`	    = '". $p['name'] ."',
		 				`gender`    = '". $p['gender'] ."',
		 				`age`	    = '". $p['age'] ."',
		 				`yearlevel` = '". $p['yearlevel'] ."',
		 				`section`   = '". $p['section'] ."',
		 				`address`   = '". $p['address'] ."',
		 				`contactno` = '". $p['contactno'] ."',
		 				`schoolyear`= '". $p['schoolyear'] ."',
		 				`datecreation` = now()
		 				");
				$rs['flag'] = 1;
		 	}else{
		 		$rs['flag'] = 0;
		 	}
		 break;

		 case 'updateAccount':
 		  		// do insert 
				$rs['add'] = $db->exec("UPDATE `users` SET 
		 				`username`  = '". $p['username'] ."',
		 				`password`  = '". md5($p['password']) ."',
		 				`userrole`  = '". $p['userrole'] ."',
		 				`name`	    = '". $p['name'] ."',
		 				`gender`    = '". $p['gender'] ."',
		 				`age`	    = '". $p['age'] ."',
		 				`yearlevel` = '". $p['yearlevel'] ."',
		 				`section`   = '". $p['section'] ."',
		 				`address`   = '". $p['address'] ."',
		 				`contactno` = '". $p['contactno'] ."',
		 				`schoolyear`= '". $p['schoolyear'] ."',
		 				`status`	= '". $p['status'] ."'
		 				WHERE
		 				`userid`    = '". $p['userid'] ."'
		 				");
				$rs['flag'] = 1;
 		 break;

		 default:
		 	echo 'Something goes wrong . Please contact your respected developer.';
		 
	}


	// return 
	echo JSON_ENCODE($rs);
}




	
	