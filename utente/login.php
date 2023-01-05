<?php
@define('DOCUMENT_ROOT', '/membri/gabrieldn5j');

@session_start();

require_once DOCUMENT_ROOT . '/common/user.php';

// If the user is logged in
if (AuthUser::is_logged_in()) {
	header('Location: /utente');
}

require_once DOCUMENT_ROOT . '/common/login-checks.php';

$pages = ['login', 'authentication'];

$head_attributes = [
	'<link rel="stylesheet" href="/css/login.css">',
	'<script src="/js/swap-forms.js"></script>',
	'<script src="/js/validate-forms.js"></script>'
];

include DOCUMENT_ROOT . '/common/header.php';
require_once DOCUMENT_ROOT . '/common/forms.php';

// Pre-checks for error codes
$extra_login_class = $has_login_failed ? 'error' : ($has_success_message ? 'success' : '');
$message = '';

if ($has_login_failed) $message = $login_error;
if ($has_register_failed) $message = $register_error;
if ($has_success_message) $message = $success_message;

$response_codes = $language['authentication']['response_code'];

if (isset($response_codes[$message]))
	$message = $language['authentication']['response_code'][$message];

?>

<body>
	<?php include DOCUMENT_ROOT . '/common/navbar.php'; ?>

	<div id="mainBody">
		<div id="mainBodyHeader"><?php echo $language['login']['title']; ?></div>

		<?php
		// Create Login form
		Forms::create_login(
			$has_register_failed ? '' : 'visible',
			$extra_login_class,
			$has_login_failed || $has_success_message ? $message : '',
			$language['authentication']['fields']['login']
		);

		// Create Register form
		Forms::create_register(
			$has_register_failed ? 'visible' : '',
			$has_register_failed,
			$has_register_failed ? $message : '',
			$language['authentication']['fields']['register']
		);
		?>
	</div>

	<?php include DOCUMENT_ROOT . '/common/footer.php'; ?>
</body>

</html>