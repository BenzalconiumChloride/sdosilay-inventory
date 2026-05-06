<?php

if (!defined('WEB_ROOT')) {

	header('Location: index');

	exit;

}



if (isset($_GET['logout'])) {

	doLogout();

}



function checkUser()

{

	if (!isset($_SESSION['school_id'])) {

		header('Location: ' . WEB_ROOT . 'login');

		exit;

	}

}



function doLogin()

{

	include SRV_ROOT . 'global-library/database.php';

	$schoolId = $_POST['txtSchoolId'];

	$password = $_POST['txtPassword'];

	if ($schoolId == "") {

		$data = ["schoolId" => null, "message" => "You must enter your School ID"];

		return $data;

	} else if ($password == "") {

		$data = ["schoolId" => "$schoolId", "message" => "You must enter the password"];

		return $data;

	} else {

		$chk = $conn->prepare("SELECT s_id, s_schoolId, s_schoolName, s_schoolPassword FROM tbl_schools WHERE s_schoolId = ? AND is_deleted != 1");

		$chk->execute([$schoolId]);

		if ($chk->rowCount() > 0) {

			$chk_data = $chk->fetch();

			$hashedPassword = $chk_data['s_schoolPassword'];

			if (password_verify($password, $hashedPassword)) {

				$_SESSION['school_id']   = $chk_data['s_id'];

				$_SESSION['school_code'] = $chk_data['s_schoolId'];

				$_SESSION['school_name'] = $chk_data['s_schoolName'];

				$today_date1 = date('Y-m-d H:i:s');

				$sql = $conn->prepare("UPDATE tbl_schools SET lastLogin = ? WHERE s_id = ?");

				$sql->execute([$today_date1, $chk_data['s_id']]);

				header('Location: ' . WEB_ROOT . '');

				exit;

			} else {

				$data = ["schoolId" => "$schoolId", "message" => "Invalid password, please try again."];

				return $data;

			}

		} else {

			$data = ["schoolId" => null, "message" => "Invalid School ID, please try again."];

			return $data;

		}

	}

}



/*

	Register a new school

*/

function doRegister()

{

	include SRV_ROOT . 'global-library/database.php';

	$schoolId        = trim($_POST['txtSchoolId']);

	$schoolName      = trim($_POST['txtSchoolName']);

	$password        = $_POST['txtPassword'];

	$confirmPassword = $_POST['txtConfirmPassword'];

	// ── Validation ──────────────────────────────────────────

	if ($schoolId === "") {

		return ["success" => false, "field" => "txtSchoolId", "message" => "School ID is required."];

	}

	if ($schoolName === "") {

		return ["success" => false, "field" => "txtSchoolName", "message" => "School name is required."];

	}

	if ($password === "") {

		return ["success" => false, "field" => "txtPassword", "message" => "Password is required."];

	}

	if (strlen($password) < 8) {

		return ["success" => false, "field" => "txtPassword", "message" => "Password must be at least 8 characters."];

	}

	if ($password !== $confirmPassword) {

		return ["success" => false, "field" => "txtConfirmPassword", "message" => "Passwords do not match."];

	}

	// ── Check if School ID already exists ────────────────────

	$chk = $conn->prepare("SELECT s_id FROM tbl_schools WHERE s_schoolId = ? AND is_deleted != 1");

	$chk->execute([$schoolId]);

	if ($chk->rowCount() > 0) {

		return ["success" => false, "field" => "txtSchoolId", "message" => "School ID already exists. Please choose another."];

	}

	// ── Hash password & insert ────────────────────────────────

	$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

	$dateCreated    = date('Y-m-d H:i:s');

	$sql = $conn->prepare(

		"INSERT INTO tbl_schools (s_schoolId, s_schoolName, s_schoolPassword, s_dateCreated, is_deleted)
		 VALUES (?, ?, ?, ?, 0)"

	);

	$sql->execute([$schoolId, $schoolName, $hashedPassword, $dateCreated]);

	if ($sql->rowCount() > 0) {

		return ["success" => true, "message" => "School registered successfully! You may now log in."];

	} else {

		return ["success" => false, "field" => null, "message" => "Registration failed. Please try again."];

	}

}



/*

	Logout a school user

*/

function doLogout()

{

	if (isset($_SESSION['school_id'])) {

		unset($_SESSION['school_id']);

		unset($_SESSION['school_code']);

		unset($_SESSION['school_name']);

		session_unset();

		session_destroy();

		if (ini_get("session.use_cookies")) {

			$params = session_get_cookie_params();

			setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

		}

	}

	header('Location: ' . WEB_ROOT . '');

	exit;

}

?>