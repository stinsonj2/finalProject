<?php 
function joinUserAndJob($userID,$jobID,$database){
	$sql=file_get_contents('sql/updateUserJob.sql');
	$params=array(
		'profileID'=>$jobID,
		'userID'=>$userID
	);
	$statement=$database->prepare($sql);
	$statement->execute($params);
}
function getJob($jobName,$database){
	$sql=file_get_contents('sql/getJob.sql');
	$params=array('jobName'=>$jobName);
	$statement=$database->prepare($sql);
	$statement->execute($params);
	$jobs=$statement->fetchAll(PDO::FETCH_ASSOC);
	$job=$jobs[0];
	return($job);
}
function get($key) {
	if(isset($_GET[$key])) {
		return $_GET[$key];
	}
	
	else {
		return '';
	}
}
function getUserPosts($userID,$database){
	
	$sql=file_get_contents('sql/getUserJob.sql');
	$params=array('userID'=>$userID);
	$statement=$database->prepare($sql);
	$statement->execute($params);
	$jobs=$statement->fetchAll(PDO::FETCH_ASSOC);
	return $jobs;
}
function searchJobs($term,$database){
	$term='%'.$term.'%';
	$sql=file_get_contents('sql/searchJobs.sql');
	$params=array('term'=>$term);
	$statement=$database->prepare($sql);
	$statement->execute($params);
	$results=$statement->fetchAll(PDO::FETCH_ASSOC);
	return($results);
}
function getPageCreator($jobID,$database){
	$sql=file_get_contents('sql/getPageCreator.sql');
	$params=array('jobID'=>$jobID);
	$statement=$database->prepare($sql);
	$statement->execute($params);
	$creators=$statement->fetchAll(PDO::FETCH_ASSOC);
	$creator=$creators[0];
	return($creator);
	
}