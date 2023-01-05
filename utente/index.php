<?php
@define('DOCUMENT_ROOT', '/membri/gabrieldn5j');

@session_start();

require_once DOCUMENT_ROOT . '/common/user.php';

$is_logged_in = AuthUser::is_logged_in();

// If the user requested a logout
if (isset($_POST['logOut'])) {
	// Logout (remove user from the session) if the user is logged in
	if ($is_logged_in) AuthUser::logout();

	// Say that the user logged out
	$_SESSION['logOut'] = true;
}

// If the user isn't logged in or has requested a logout, go to the login page
if (!$is_logged_in || isset($_POST['logOut'])) header('Location: /utente/login');

require_once DOCUMENT_ROOT . '/common/sql.php';
require_once DOCUMENT_ROOT . '/common/userpage.php';

$pages = ['user'];

$head_attributes = ['<link rel="stylesheet" href="/css/userpage.css">'];

include DOCUMENT_ROOT . '/common/header.php';

// Start SQL connection
$sql_query = new SQLQuery();

// Set the user to an invalid one if there are problems
$id = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : -1;

// Set user stats
$user = new UserStats($sql_query, $_SESSION['user']['id']);

?>

<body>
	<?php include DOCUMENT_ROOT . '/common/navbar.php'; ?>

	<div id="mainBody">
		<div id="mainBodyHeader"><?php echo $language['user']['title']; ?></div>

		<?php
		UserPage::create_profile($user, $language['user']['content']['profile']);
		?>
		
		<!-- <div id="userProductHistory">
			<p></p>
		</div> -->
	</div>

	<?php include DOCUMENT_ROOT . '/common/footer.php'; ?>
</body>

</html>