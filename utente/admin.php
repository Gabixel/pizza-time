<?php
@define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

@session_start();

require_once DOCUMENT_ROOT . '/common/user.php';

// If the user isn't logged in or isn't an admin, give 403 error
if (!AuthUser::is_logged_in() || !AuthUser::is_admin()) {
	http_response_code(403);
	include DOCUMENT_ROOT . '/403.php';
	exit();
}

require_once DOCUMENT_ROOT . '/common/sql.php';
require_once DOCUMENT_ROOT . '/common/admin.php';

$pages = ['admin'];

$head_attributes = [
	'<link rel="stylesheet" href="/css/userpage.css">',
	'<link rel="stylesheet" href="/css/admin.css">',
	'<script src="/js/admin.js"></script>'
];

include DOCUMENT_ROOT . '/common/header.php';

?>

<body>
	<?php include DOCUMENT_ROOT . '/common/navbar.php'; ?>
	<div id="mainBody">
		<div id="mainBodyHeader"><?php echo $language['admin']['title']; ?></div>

		<form id="tableList" action="/utente/admin" method="GET">
			<label for="adminTableSelector"><?php echo $language['admin']['content']['select_message']; ?></label>
			<select name="table" id="adminTableSelector" onchange="this.form.submit();">
				<?php
				// Create SQL connection
				$sql_query = new SQLQuery();

				$requested_table = isset($_GET['table']) ? $_GET['table'] : '';
				$exists = $requested_table
					? AdminHandler::table_exists($sql_query, $requested_table) !== false
					: false;

				echo AdminHandler::generate_table_options($sql_query, $requested_table, !$exists);
				?>
			</select>
			<!-- Replace 'localhost' with your phpMyAdmin directory --><a href="localhost" target="_blank"><i class="fab fa-php"></i><?php echo $language['admin']['content']['direct_database']; ?></a>
			<?php
			if ($exists) {
				$buttons = '';

				$buttons .= "\t<button type=\"submit\" name=\"deleteRows\"><i class=\"fas fa-trash-alt\"></i>"
					. $language['admin']['content']['delete_row'] . "</button>\n";

				echo $buttons;

				// Delete selected rows
				if (isset($_GET['selectedRows']) && !empty($_GET['selectedRows'])) {
					AdminHandler::delete_rows($sql_query, $requested_table, $_GET['selectedRows']);
				}
			}
			?>
		</form>
		<?php
		if ($exists) {
		?>
			<div class="tableViewContainer">
				<div class="scrollContainer">
					<div class="tableContainer">
						<?php
						echo AdminHandler::generate_table($sql_query, $requested_table);
						?>
					</div>
				</div>
				<div class="shadowContainer"></div>
			</div>
		<?php
		}
		?>
	</div>
	<?php include DOCUMENT_ROOT . '/common/footer.php'; ?>
</body>

</html>