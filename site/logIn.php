<?php
	include('config.php');
	include('functions.php');

	$redirectNote=get('action');
	if($redirectNote=='pleaseSignIn'){echo '<script type="text/javascript">window.alert("Please sign in or make an account to post.")</script>';}
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Get username and password from the form as variables
		switch($_POST['action']){
			case 'login':
				$username = $_POST['username'];
				$password = $_POST['password'];
				$sql=file_get_contents('sql/attemptLogin.sql');
				$params=array(
					'username'=>$username,
					'password'=>$password
				);
				$statement=$database->prepare($sql);
				$statement->execute($params);
				$persons=$statement->fetchAll(PDO::FETCH_ASSOC);
				if(!empty($persons)){
					$person=$persons[0];

					$_SESSION['userID']=$person['userID'];

					header('location: index.php');
				}
				else{echo '<script type="text/javascript">window.alert("Login failed, incorrect username or password.")</script>';}
			break;
			case 'signup':
				$name=$_POST['name'];
				$username = $_POST['username'];
				$password = $_POST['password'];
				
				
				if(empty($name)) $name=$username;
				$sql=file_get_contents('sql/createUser.sql');
				$params=array(
					'username'=>$username,
					'password'=>$password,
					'name'=>$name
				);
				$statement=$database->prepare($sql);
				$statement->execute($params);
				$sql2=file_get_contents('sql/attemptLogin.sql');
				$params2=array(
					'username'=>$username,
					'password'=>$password,
				);
				$statement2=$database->prepare($sql2);
				$statement2->execute($params2);
				$persons=$statement2->fetchAll(PDO::FETCH_ASSOC);
				If(!empty($persons)){
					$person=$persons[0];
					$_SESSION['userID']=$person['userID'];
					header('location: index.php');
				}
				
		}
		
	}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="stylesheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
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
            <h1>Log In</h1>
            <p></p>
            <hr>
			<!--Login form-->
          	<form method="POST" name="login">
				<input type="text" name="username" placeholder="Username" required/>
				<input type="password" name="password" placeholder="Password" required/>
				<input type="hidden" name="action" value="login"/>
				<input type="submit" value="login" name="login" />
			</form>
           	<br><br><br>
           
           <h1>Sign Up</h1>
           <hr>
           <!--Sign up form-->
           <form method="POST" name='signup'>
		   		<input type="text" name="username" placeholder="Username" required/>
				<input type="password" name="password" placeholder="Password" required/>
				<input type="text" name="name" placeholder="Name (optional)"/>
				<input type="hidden" name="action" value="signup"/>
				
				<input type="submit" value="Sign Up" name="signup"/>
		   </form>
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
