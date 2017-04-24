<?php
include('config.php');
include('functions.php');

$jobName=get('jobName');
$job=getJob($jobName,$database);

$creator=getPageCreator($job['profileID'],$database);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $job['jobName']?></title>
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
            <h1><?php echo $job['jobName']?></h1>
            <hr>
            <h3>Skills required:</h3>
            <?php echo $job['skills']?>
            <br>
            <h3>Pay Rate: </h3>
            <?php echo $job['payRate']?>
            <br>
            <h3>Description: </h3>
            <?php echo $job['description']?>
            <br>
            <h3>Other comments: </h3>
            <?php echo $job['comments']?>
            <br>
            <h3>Created by: </h3>
            <?php echo $creator['realName']?>
            
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