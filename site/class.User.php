<?php 

	class User{
		public $userid;
		public $username;
		public $userRealName;
		public $database;
		public $hasSubmitted;
		public $job;
		
		
		function __construct($userID,$database){
			
			$sql=file_get_contents('sql/selectUser.sql');
			$params=array(
				'userID'=>$userID
			);
			$statement=$database->prepare($sql);
			$statement->execute($params);
			$users=$statement->fetchAll(PDO::FETCH_ASSOC);
			
			$user=$users[0];
			
			$userRealName=$user['realName'];
			$userID=$user['userID'];
			$username=$user['username'];
			$hasSubmitted=$user['hasSubmitted'];
			
			$sql2=file_get_contents('sql/getUserJob.sql');
			$params2=array(
				'userID'=>$userID
			);
			$statement2=$database->prepare($sql2);
			$statement2->execute($params2);
			$nameAndJob=$statement2->fetchAll(PDO::FETCH_ASSOC);
			
			if(empty($nameAndJob)) $this->job="Not Listed";
			else {
				$jobs=$nameAndJob[0];
				$this->job=$jobs['jobName'];
				
			}
			
			$this->database=$database;
			$this->userID=$userID;
			$this->username=$username;
			$this->userRealName=$userRealName;
			$this->hasSubmitted=$hasSubmitted;
			
		}
	}