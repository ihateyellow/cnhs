<?php defined('KANASHII') or die(("Access Denied."));

class db
{

    private $db; // * Query to perform
    private $query;  //query holder
    private $result; // Result holds data retrieved from server
    private $num_rows; // store the nos of rows in a result

    public function __construct()
    {
		 $this->con();
    }

    function con()
    {
        try {
			set_error_handler(array($this, 'errHandler'));
            $this->db = new PDO(DB_TYPE.':host='.DB_HOST .'; dbname='.DB_NAME,DB_USER,DB_PASSWORD,
            array(PDO::ATTR_PERSISTENT => true));
			restore_error_handler();
			$this->state = true;

			// if(!empty($_SESSION['timezone']))
				// $this->db->exec("SET time_zone='".$_SESSION['timezoneoffset']."' ");
			if(!empty($_SESSION['timezone']))
				date_default_timezone_set($_SESSION['timezone']);
			if($this->db === null){
				echo "error";
			}
        } 
        catch (PDOException $e)
        {
			die('Please contact Yel . Thank you. #ERROR [ 404 ] ');
           //  echo 'Connection Failed: ' . $e->getMessage();
        }
    }
	
	public function errHandler($errno, $errstr){
		// echo 'Go abibaa go!';
	}


    public function __sleep()
    {
        return array('mysql:host='.DB_HOST .'; dbname='.DB_NAME,DB_USER,DB_PASSWORD);
		// do kill
		// $x = $this->db->GetAll("select concat('KILL ',id,';') as sleep from information_schema.processlist where `user` like 'abibaa_yel' AND `command` like 'SLEEP'");
		// foreach($x as $s){ $this->db->exec($s['sleep']); }
    }

    public function __wakeup()
    {
		//$this->disconnect();
        $this->con(); 
    }

    function connect()
    {
        if($this->db==null)
        {
            $this->con();
        }
    }


    function disconnect()
    {
        if($this->db !=null)
        {
            $this->db =null;
			unset($this->db);
        }
    }

    public function strip_html_tags($value)
    {
        $value = preg_replace(
            array(
                // Remove invisible content
                '@<head[^>]*?>.*?</head>@siu',
                '@<style[^>]*?>.*?</style>@siu',
                '@<script[^>]*?.*?</script>@siu',
                '@<object[^>]*?.*?</object>@siu',
                '@<embed[^>]*?.*?</embed>@siu',
                '@<applet[^>]*?.*?</applet>@siu',
                '@<noframes[^>]*?.*?</noframes>@siu',
                '@<noscript[^>]*?.*?</noscript>@siu',
                '@<noembed[^>]*?.*?</noembed>@siu'
            ),
            array(
                '', '', '', '', '', '', '', '', ''), $value );

        return strip_tags( $value);
    }
    public function fix_page($value)
    {
        $value = htmlspecialchars(trim($value));
        if (get_magic_quotes_gpc())
            $value = stripslashes($value);
        return $value;
    }

    public	function fix_mysql($value)
    {
        if (get_magic_quotes_gpc())
        {
            $value = stripslashes($value);
        }
      //  $value = $this->db->real_escape_string(trim($value));
        return $value;
    }

    public	function clean($value)
    {
        $value = $this->fix_page($value);
        $value = $this->strip_html_tags($value);
        $bad = array("=","<", ">", "/","\"","`","~","'","$","%","#","?",".exe","DROP","DELETE","SLEEP(");
        $value = str_ireplace($bad, "", $value);
       // $value = $this->fix_mysql($value);
        return $value;
    }//end of clean
	
	public	function cln($value)
	{
		if(!empty($value))
		{
			$value = $this->fix_page($value);
			$value = $this->strip_html_tags($value);
			$bad1 = array("=", "/","\"","`","~","'","$","%","#","?","+"); // acceptable string
			foreach($bad1 as $a){ $value = str_replace($a,"\\".$a,$value); }
			$input = strtolower($value);
			$bad2 = array(";","<", ">",".exe",".sh","drop","delete","truncate",); // prohibited string 
			foreach($bad2 as $b){  if(strpos($input,$b) !== false)  { $flag = true; break; } } if($flag == true){ $value = ''; } 
		}
		else{
			$value = '';
		}
		return $value;
	}
	

    public function clean_minor($value)
    {
        $value = $this->fix_page($value);
        $value = $this->strip_html_tags($value);
        $bad = array("=","<s","'","$","%","?",".exe","DROP","drop","Drop","DELETE","Delete","delete");
        $value = str_replace($bad, "", $value);
        //$value = $this->fix_mysql($value);
        return $value;
    }//end of clean


    //fetch one rows in a result and store it as  array
    public function query($sql)
    {
        if(!empty($sql))
        {
            $this->connect(); //connect to database
            try
            {
				$this->vlookup($sql);
                $q = $this->db->prepare($sql);
                $q->execute();
                $q->setFetchMode(PDO::FETCH_ASSOC);
                $data = $q->fetchAll();

                return $data;
                //echo json_encode($data);
                $this->disconnect(); //disconnect from database
            }
            catch (PDOException $e)
            {
                return $e->getMessage();
            }
        }
        else{
            return 'No query provided';
            die;
        }

    }
	
	
	
	public function exec($sql,$foradmin=false)
    {
        if(!empty($sql))
        {
            $this->connect(); //connect to database
            try
            {
                if(!$this->checkrestrictedwords($sql)||$foradmin||stristr($sql, 'sessionlogs')){
					$this->vlookup($sql);
                    $q = $this->db->prepare($sql);
                    $q->execute();
                    if($q->errorInfo()[0] == 0000){
                        return array ('stat'=>$q->rowCount(),'msg'=>"Success :: ". $q->rowCount() . " as Affected rows.",'insert_id'=>$this->db->lastInsertId() );
                    }else{
                        return  "Error # : ". $q->errorInfo()[0] . " :: " . $q->errorInfo()[1] . "<br/>" . "Message :" . $q->errorInfo()[2]; 
                    }   
                }else{
                    return false;
                }
            }
            catch(PDOException $e)
            {
                return $e->getMessage();
            }
             
        }else{
            return 'No query provided';
            die;
        }
            $this->disconnect(); //disconnect from database
    }

	public function exc($sql)
	{
		if(!empty($sql))
        {
			$this->connect(); //connect to database
			try
			{
				$q = $this->db->prepare($sql);
				$q->execute();
				if($q->errorInfo()[0] == 0000){
					return array ('stat'=>$q->rowCount(),'msg'=>"Success :: ". $q->rowCount() . " as Affected rows.",'insert_id'=>$this->db->lastInsertId() );
				}else{
					return  "Error # : ". $q->errorInfo()[0] . " :: " . $q->errorInfo()[1] . "<br/>" . "Message :" . $q->errorInfo()[2]; 
				}	
			}
			catch(PDOException $e)
			{
				return $e->getMessage();
			}
			 
		}else{
			return 'No query provided';
            die;
		}
			$this->disconnect(); //disconnect from database
	}
	
	
    //fetch one column
    public function GetOne($sql)
    {
        $this->connect(); //connect to database
        if(!empty($sql))
        {
            try
            {   
                $re = $this->db->prepare($sql);
                $re->execute();
                return $re->fetchColumn();
            }
            catch (PDOException $e)
            {
                return $e->getMessage ();
            }
        }
        else{
            return 'No query provided';
            die;
        }
        $this->disconnect(); //disconnect from database

    }

    //fetch one rows in a result and store it as an  object
    public function GetRow($sql)
    {
        if(!empty($sql))
        {
            $this->connect(); //connect to database
            try
            {
			//	$this->vlookup($sql);
			//	$sql = str_replace("LIKE","=",$sql);
                $q = $this->db->prepare($sql);
                $q->execute();
                return $q->fetch(PDO::FETCH_OBJ);
                $this->disconnect(); //disconnect from database

            }
            catch (PDOException $e)
            {
                return $e->getMessage ();
            }
			$this->disconnect(); //disconnect from database
        }
        else{
            return 'No query provided';
            die;
        }
		
    }

    //fetch all rows in a result to assoc_array
    public function GetAll($sql)
    {
        if(!empty($sql))
        {
        $this->connect(); //connect to database		
            try
            {
                $q = $this->db->prepare($sql);
                $q->execute();
                $q->setFetchMode(PDO::FETCH_ASSOC);
                $data = $q->fetchAll();

                return $data;
                //echo json_encode($data);

            }
            catch (PDOException $e)
            {
                return $e->getMessage ();
            }
			$this->disconnect(); //disconnect from database			
        }
        else{
            return 'No query provided';
            die;
        }

 

    }



    //fetch one rows in a result and store it as an  object
    public function GetRowObject($sql)
    {

        if(!empty($sql))
        {
            $this->connect(); //connect to database
            try
            {
                $q = $this->db->prepare($sql);
                $q->execute();
                return $q->fetch(PDO::FETCH_OBJ);
                $this->disconnect(); //disconnect from database
            }
            catch (PDOException $e)
            {
                return $e->getMessage ();
            }
        }
        else{
            return 'No query provided';
            die;
        }

    }


    //fetch one rows in a result and store it as  array
    public function GetRowArray($sql)
    {
        $this->connect(); //connect to database
        if(!empty($sql))
        {
            try
            {
                $q = $this->db->prepare($sql);
                $q->execute();
                return $q->fetch(PDO::FETCH_ASSOC);
            }
            catch (PDOException $e)
            {
                return $e->getMessage ();
            }
        }
        else{
            return 'No query provided';
            die;
        }
        $this->disconnect(); //disconnect from database
    }




    public function server_info() /* print server version */
    {
        $this->connect();
        return  $this->connect->server_info;
        $this->disconnect();
    }

    //delete function
    function delete($tbl,$id)
    {
        $this->execute("delete from {$this->clean($tbl)} where id='{$this->clean($id)}'");
    }

    //execute query supply
     public function execute($sql,$foradmin=false)
    {
        $this->connect(); //connect to database
        if(!empty($sql))
        {
			$this->vlookup($sql);
                // var_dump($foradmin);
            if(!$this->checkrestrictedwords($sql)||$foradmin||stristr($sql, 'sessionlogs')){
                $sth = $this->db->prepare($sql);
                return $sth->execute();
            }else{
                return false;
            }
            //return  $sth->fetchColumn();
        }
        else{
            return 'No query provided';
            die;
        }

        $this->disconnect(); //disconnect from database
    }

    public function checkrestrictedwords($sql){
        $sql = strtolower(preg_replace('/([^a-z-*A-Z])/','',$sql));
        return (int)$this->GetOne(' SELECT COUNT(1) FROM `bad_words` WHERE "'. $sql .'" LIKE CONCAT("%",`badword`,"%") ');
    }


    //check if column exists in the given database table
    public function checkcol($tbl,$col)
    {
        $this->connect(); //connect to database
        if(!empty($tbl))
        {
            try
            {
                $sql = "SELECT count(*)
				FROM information_schema.COLUMNS
				WHERE
					TABLE_SCHEMA = '".DB_NAME."'
				AND TABLE_NAME = '".$tbl."'
				AND COLUMN_NAME = '".$col."'";

                return $this->GetOne($sql);
            }
            catch (PDOException $e)
            {
                return $e->getMessage ();
            }
        }
        else{
            return 'No query provided';
            die;
        }
        $this->disconnect(); //disconnect from database
    }

    function saveInfo($tbl)
    {
        $this->connect(); //connect to database
        $label = array();
        $value= array();
        $update="";

        //create the table if not exist
        $tbl_col=null;
        foreach($_POST as $f=>$v)
        {
            $tbl_col .= $f." varchar(255) not null,";
        }
        $tbl_col = substr($tbl_col, 0, -1);
        $sql_ = "create table if not exists {$tbl} ( id int auto_increment primary key,{$tbl_col},unique key tID(tID))";
        $this->execute($sql_);
        //echo $sql_;
        //end of table creation if not exists

        //process the given data
        foreach($_POST as $key=>$val)
        {
            $lb = $this->checkcol($tbl,$key);
            if($lb > 0)
            {
                $label[$key] = $key;
                if($key=="description" || $key=="valid" || $key=="link" || strstr($key,"dob") ||  $key=="custom" || $key=="detail" || $key=="billdue") //
                {
                    $value[$key]= $val;
                    $update .=$key."='".$val."',";
                }
                elseif($key=="password")
                {
                    //$pass = md5($this->strip_html_tags($_POST['username']).$this->strip_html_tags($_POST['password']));
                    $passwo = md5(md5($this->clean($_POST['username'])).md5($this->clean($_POST['password'])));
                    $pass = md5($passwo.PASSWORD_SALT);


                    $value[$key]= $pass;
                    $update .=$key."='".$pass."',";

                }
                else{
                    $value[$key]= $this->clean($val);
                    $update .=$key."='".$this->clean($val)."',";
                }

            }

        }
        $update = substr($update, 0, -1);//remove the last comma

        //check if colum exist is table
        $cols="";
        if(is_array($label))
        {
            foreach($label as $lbl)
            {
                $cols .=$lbl.',';
            }
        }
        $cols = substr($cols, 0, -1);//remove the last comma


        $va="";
        if(is_array($value))
        {
            foreach($value as $v)
            {
                $va .="'".$v."',";
            }
        }
        $va = substr($va, 0, -1);//remove the last comma

        $sql="";
        if(!empty($_POST['id']))
        {
            $sql = "update {$tbl} set {$update} where id='{$this->clean($_POST['id'])}'";
        }
        else{
            $sql = "insert into {$tbl}({$cols}) values({$va})";
        }


        $this->execute($sql);
        //print_r($_POST);

        $this->disconnect(); //disconnect from database
    }

    //get specific column from table
    function getField($col,$sF,$sV,$tbl,$cmd,$other=null)
    {
        return $this->$cmd("select
		{$this->clean($col)} from
		{$this->clean($tbl)} where
		{$this->clean($sF)}='{$this->clean($sV)}' {$other}");
    }

    //get specific column from table
    function getTblInfo($col,$tbl,$cmd,$cond=null)
    {
        return $this->$cmd("select
		{$this->clean($col)} from
		{$this->clean($tbl)} {$cond}");
    }
	
    // CRYPT NUMBER
    function crypt($action,$value){
        // $ruserid ='C'.substr(strtoupper(md5(date('YmdHisu'))),2,3) .substr(strtoupper(md5(FLOOR(RAND() * 1000) + 1)),2,4);
        // echo $ruserid.'<br />';
        // echo md5(PASSWORD_SALT_MER.$value);
        if(isset($action)&&isset($value)){
            $value = str_split($value);
            if($action == 'encrypt'){
                $rep = [1,0,9,8,7,6,5,4,3,2];
                foreach($value as $key => $val){
                    $value[$key] = str_replace($val,$rep[$val],$val);
                }
            }
            else if($action == 'decrypt'){
                $rep = [1=>0,0=>1,9=>2,8=>3,7=>4,6=>5,5=>6,4=>7,3=>8,2=>9];
                foreach($value as $key => $val){
                    $value[$key] = str_replace($val,$rep[$val],$val);
                }
            }
            return implode($value);
        }
        else return false;
    }
	
	public function vlookup($value){
		if(!empty($value)){
			$ip = $this->clean($_SERVER['REMOTE_ADDR']);
			$sql = $this->clean_minor($value);
			$sqlpage = $this->clean($_SERVER['QUERY_STRING']);
		//	$this->vlookupquery("INSERT INTO `vlookup` SET `ipaddress` = '". $ip ."' , `sqlpage` = '". $sqlpage ."' , `sqlstatement` = '". $sql ."'");			
		 }
		
	}
	
    //fetch one rows in a result and store it as  array
    public function vlookupquery($sql)
    {
        $this->connect(); //connect to database
        if(!empty($sql)){
			// restriction
			if(strpos($sql,'sessionid') === false){
				$sth = $this->db->prepare($sql);
				return $sth->execute();
			}
        }
        else{
            return 'No query provided';
            die;
        }
        $this->disconnect(); //disconnect from database     
    }
 	
	
}