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

	switch ($type) {
		case 'load_chat':
			$messageid = $db->clean($p['messageid']);
			//Chat Sender
			$rs['chat'] = $db->GetAll("SELECT * FROM `chat` 
							 		   WHERE `messageid` = ".$messageid."  ");
			break;
		case 'send_msg':
			$user = $db->clean($p['active_user']);
			$mate = $db->clean($p['chat_mate']);
			$messageid = $db->clean($p['messageid']);
			$message = $db->clean($p['message']);

			$rs['send_status'] = $db->execute("INSERT INTO `chat` 
											   SET `messageid` = ".$messageid.",
											   `message` = '".$message."',
											   `sender` = '".$user."',
											   `receiver` = '".$mate."',
											   `datechat` = now() ");
			break;

		case 'load_contact':
			$user = $db->clean($p['active_user']);
			$rs['contact'] = $db->GetAll("SELECT `userid`,`name` FROM `users` WHERE `username` NOT LIKE '".$user."' ORDER BY `userid`");
			$rs['user'] = $user;
			break;
		case 'live_search':
			$user = $db->clean($p['active_user']);
			$keyword = $db->clean($p['keyword']);
			$rs['result'] = $db->GetAll("SELECT `userid`,`name` FROM `users` WHERE `username` NOT LIKE '".$user."' AND `name` LIKE '".$keyword."%'");
			break;
		
		default:
		/**
		 *  
		 */
			
	}

	echo json_encode($rs);

}