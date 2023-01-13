<?php
@define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

@session_start();

require_once DOCUMENT_ROOT . '/common/user.php';

// If the user isn't logged in
if (!AuthUser::is_logged_in()) {
	header('Location: /utente/login');
}

require_once DOCUMENT_ROOT . '/common/password-checks.php';

$pages = ['password', 'authentication'];

$head_attributes = [
	'<link rel="stylesheet" href="/css/login.css">',
	'<script src="/js/swap-forms.js"></script>',
	'<script src="/js/validate-forms.js"></script>'
];

include DOCUMENT_ROOT . '/common/header.php';
require_once DOCUMENT_ROOT . '/common/forms.php';

// If there's an error message, try to translate it
if ($fail_message && isset($language['authentication']['response_code'][$fail_message])) {
	$fail_message = $language['authentication']['response_code'][$fail_message];
}

?>

<body>
	<?php include DOCUMENT_ROOT . '/common/navbar.php'; ?>

	<div id="mainBody">
		<div id="mainBodyHeader"><?php echo $language['password']['title']; ?></div>

		<a href="/utente"><?php echo $language['password']['content']['back']; ?></a>

		<?php
		Forms::create_password_change(
			$has_failed,
			$fail_message,
			$language['authentication']['fields']['update_password']
		);
		?>
	</div>

	<?php include DOCUMENT_ROOT . '/common/footer.php'; ?>
</body>