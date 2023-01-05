<?php
// If the file is called directly and not included
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
	header('Location: /');
}

@define('DOCUMENT_ROOT', '/membri/gabrieldn5j');

@session_start();

require_once DOCUMENT_ROOT . '/common/user.php';
require_once DOCUMENT_ROOT . '/common/sql.php';

// Check if the user sent the form
$is_change_requested = isset($_POST['changePassword']);

$fail_message = '';

// Check if the user has failed the password change
$has_failed = isset($_SESSION['failed_password_change']);

// Save the fail message
if ($has_failed) {
	$fail_message = $_SESSION['failed_password_change'];

	$_SESSION['failed_password_change'] = NULL;
}

if(!$is_change_requested) return;

// Create connection and user
$sql_query = new SQLQuery();
$user = new AuthUser($sql_query);

// Retrieve infos
$old = $sql_query->escape_string($_POST['password'][0]);
$new = $sql_query->escape_string($_POST['password'][1]);
$user_id = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : -1;

// // Try to change password
$user->change_password($old, $new, $user_id);

// Re-redirect to the login page (where it checks for success/error messages)
header('Location: ' . $_SERVER['REQUEST_URI']);