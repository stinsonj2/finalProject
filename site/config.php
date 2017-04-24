 
<?php
function autoloader($class){
    include 'class.'.$class.'.php';
}
spl_autoload_register('autoloader');
// Connecting to the MySQL database
$use = 'stinsonj2';
$password = 't8u6eQa6';

$database = new PDO('mysql:host=csweb.hh.nku.edu;dbname=db_spring17_stinsonj2', $use, $password);

session_start();

$current_url = basename($_SERVER['REQUEST_URI']);


if (isset($_SESSION["userID"])) {
	$sql = file_get_contents('sql/selectUser.sql');
	$params = array(
		'userID' => $_SESSION["userID"]
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$users = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	$user = $users[0];
	
	$user= new User($_SESSION["userID"],$database);

}
