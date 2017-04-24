<?php
include('config.php');
include('functions.php');

$action=$_GET['action'];
$jobID=get('jobID');

$theseJobs=null;

if(!empty($jobID)){
	$sql=file_get_contents('sql/selectJob.sql');
	$params=array('profileid'=>$jobID);
	$statement=$database->prepare($sql);
	$statement->execute($params);
	$theseJobs=$statement->fetchAll(PDO::FETCH_ASSOC);
	$thisJob=$theseJobs[0];
}

if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_SESSION['userID'])){
		$jobName=$_POST['jobtitle'];
		$jobDescription=$_POST['description'];
		$payRate=$_POST['payrate'];
		$skills=$_POST['skills'];
		$comments=$_POST['comments'];
		if($action=='add'){
			$sql=file_get_contents('sql/createJob.sql');
			$params=array( 
				'jobname'=>$jobName,
				'jobdesc'=>$jobDescription,
				'payrate'=>$payRate,
				'skills'=>$skills,
				'comments'=>$comments
			);
			$statement=$database->prepare($sql);
			$statement->execute($params);
			$job=getJob($jobName,$database);
			joinUserAndJob($job['profileID'],$user->userID,$database);
		}
		elseif($action=='edit'){
			$sql=file_get_contents('sql/updateJobProfile.sql');
			$params=array( 
				'description'=>$jobDescription,
				'payRate'=>$payRate,
				'skills'=>$skills,
				'comments'=>$comments,
				'jobID'=>$jobID
			);
			$statement=$database->prepare($sql);
			$statement->execute($params);
			header('location: jobPage.php?jobName='.str_replace(" ","+",$thisJob['jobName']));
		}
		
	
		
	}
	else{ 
			header('location: login.php?action=pleaseSignIn');
		}
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Submit</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="stylesheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
		function logOutAlert(){
			alert("You have logged out.");
		}
    </script>
    <style>
        /* Remove the navbar's default margin-bottom and rounded borders */
        .navbar {
            margin-bottom: 0;
            border-radius: 0;
        }

        /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
        .row.content {height: 530px}

        /* Set gray background color and 100% height */
        .sidenav {
            padding-top: 20px;
            background-color: #f1f1f1;
            height: 100%;
        }

        /* Set black background color, white text and some padding */
        footer {
            background-color: #555;
            color: white;
            padding: 15px;
        }

        /* On small screens, set height to 'auto' for sidenav and grid */
        @media screen and (max-width: 767px) {
            .sidenav {
                height: auto;
                padding: 15px;
            }
            .row.content {height:auto;}
        }
    </style>
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Home</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li><a href="search.php">Search</a></li>
                <li><a href="submit.php?action=add">Submit</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if(isset($_SESSION['userID'])): ?>
                	<li><a href="profilePage.php" style="font-size: 20px"><?php echo $user->userRealName?></a></li>
                	<li><a href="logout.php" style="font-size: 20px" onClick="logOutAlert()">Log Out</a></li>
                <?php else: ?>
                	<li><a href="logIn.php"><span class="glyphicon glyphicon-log-in"></span> Login / Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid text-center">
    <div class="row content">
       
        <div class="col-sm-2 sidenav"> 
            
        </div>
        
        <div class="col-sm-8 text-left">
           <br/>
            <h1>Submit</h1>
            <p>Here you can submit a post about your career. You don't have to submit any more than an overview, but you are welcome to tell us as much as you like. We have some questions you could answer, or you could just say whatever you like in the "other comments" section. You are encouraged to say what you really think about your career, the skills needed, and what you should expect working in this field. What differentiates this site from others of it's kind is that we know that every job has negative aspects, or ones that you wouldn't expect. By not censoring yourself, you may really help someone who faces the same problems as you.</p>
            <hr>
            <form method="POST" id="usrform">
				<h4>Job Title</h4>
	   			<?php if($action=='add'): ?>
		   			<input type="text" name="jobtitle" required/>
		   		<?php elseif($action=='edit'): ?>
		   			<input readonly type="text" name="jobtitle" value="<?php echo $thisJob['jobName']?>"/>
		   		<?php endif?>
		   			
		   		<hr>
		   		
		   		<h4>Pay Rate (optional)</h4>
		   		<?php if($action=='add'): ?>
					<input type="text" name="payrate"/>
				<?php elseif($action=='edit'): ?>
					<input type="text" name="payrate" value="<?php echo $thisJob['payRate']?>" />
				<?php endif?>
				<hr>
				<h4>Skills Required</h4>
				This should be the actual skills you need to perform the job, not necissarily what was listed on the job opening.
				<br>
				<?php if($action=='add'): ?>
					<textarea name="skills" form="usrform" cols="40" rows="5" maxlength="1500"></textarea>
				<?php elseif($action=='edit'): ?>
					<textarea name="skills" form="usrform" cols="40" rows="5" maxlength="1500"><?php echo $thisJob['skills']?></textarea>
				<?php endif ?>
				<hr>
				<h4>Job Description</h4>
				<?php if($action=='add'): ?>
					<textarea name="description" form="usrform" cols="50" rows="7" maxlength="1500"></textarea>
				<?php elseif($action=='edit'): ?>
					<textarea name="description" form="usrform" cols="50" rows="7" maxlength="1500"><?php echo $thisJob['description']?></textarea>
				<?php endif ?>
				<hr>
				<h4>Other Comments</h4>
				<?php if($action=='add'): ?>
					<textarea name="comments" form="usrform" cols="50" rows="6" maxlength="1500"></textarea>
				<?php elseif($action=='edit'): ?>
					<textarea name="comments" form="usrform" cols="50" rows="6" maxlength="1500"><?php echo $thisJob['comments']?></textarea>
				<?php endif ?>
				<br>
				<input type="hidden" name="action" value="submit" />
				<br>
				<input type="submit" style="width:150px; height:50px; font-size: 20px" value="Submit" name="signup"/>
		   </form>
           <br>
            
            
      </div>
        <div class="col-sm-2 sidenav">
            
        </div>
    </div>
</div>

<footer class="container-fluid text-center">
    <p>Pretend Copyright 2017</p>
</footer>

</body>
</html>
