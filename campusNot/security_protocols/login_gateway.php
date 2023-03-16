<?php
	// send errors to browser
	ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);

	$host = "localhost";
	$user = "group10";
	$pass = "lenientslick";
	$db = "group10";
	$charset = 'utf8mb4';
	//group10, lenientslick

	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	$options = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
	];
	try {
		 $pdo = new PDO($dsn, $user, $pass, $options);
	} catch (\PDOException $e) {
		 throw new \PDOException($e->getMessage(), (int)$e->getCode());
	}
	session_start();
	session_destroy();
	$username = $_POST["username"];
	$password = $_POST["password"];
    if ($username == NULL || $password == NULL) {
        header("Location: index.html");
    }

	$stmt = $pdo->prepare("SELECT * FROM user_general WHERE userName = ?");
	$stmt->execute([$_POST['username']]);
	$user = $stmt->fetch();

	if ($user['userName'] != NULL && password_verify($password, $user['userPassword']) && $user['userStatus'] == 1) {
		session_start();
		$id = $user["userID"];
        $_SESSION["userID"] = $user['userID'];
		$_SESSION["userName"] = $user['userName'];
        $_SESSION["userType"] = $user['userType'];
        $_SESSION["userStatus"] = $user['userStatus'];
        if ($user['userType'] == 'S') {
            header("Location: ../home_pages/home_page_student.php");
        }
        if ($user['userType'] == 'P') {
            header("Location: ../home_pages/home_page_professor.php");
        }
        if ($user['userType'] == 'A') {
            $stmt = $pdo->prepare("SELECT adminPermissionsCode FROM admin_basic_general WHERE userID = ?");
	        $stmt->execute([$id]);
	        $user = $stmt->fetch();
            $_SESSION["permissionsCode"] = $user['adminPermissionsCode'];
            header("Location: ../home_pages/home_page_admin.php");
        }
 	} else {
        echo 'Invalid login information';
	}