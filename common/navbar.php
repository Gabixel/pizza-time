<?php
// If the file is called directly and not included
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
	header('Location: /');
}

@define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

?><nav class="topnav">
	<?php
	require_once DOCUMENT_ROOT . '/common/user.php';
	require_once DOCUMENT_ROOT . '/common/string-tools.php';

	/* [0] -> Name
	 * [1] -> Href
	 * [2] -> Extra classes (ignoring 'link')
	 */
	$leftTabs = [
		[
			$language['navbar']['menu'],
			'menu',
			'',
		],
		[
			$language['navbar']['gallery'],
			'galleria',
			'',
		],
		[
			$language['navbar']['contact'],
			'contattaci',
			'',
		],
	];

	/* [0] -> UI Name
	 * [1] -> Flag file name
	 * [2] -> Language folder
	 * [3] -> HTML language
	 */
	$availableLanguages = [
		['Italiano', 'it', 'it', 'it'],
		['English', 'gb', 'en', 'en'],
	];
	?>

	<div class="left">
		<a href="/" class="link topnav-logo">Pizza Time</a>
		<a class="link hamburger-bar"><i class="fas"></i></a>
		<div class="pages">
<?php
	// Left tabs distributor
	foreach ($leftTabs as $currTab) {

		$current_class = '';

		// If this element is the current tab (by checking end of URI), ignoring first one since it's the logo link (and it has a special case)
		if (is_url_last_element($currTab[1])) {
			$current_class = 'current ';
		}

		if (!empty($currTab[1])) {
			$currTab[1] = '/' . $currTab[1];
		}

		$href = !empty($currTab[1]) ? 'href = "' . $currTab[1] . '"' : '';

		$tab = "\t\t\t<a " . $href . ' class="link ' . $current_class . $currTab[2] . '">' . $currTab[0] . "</a>\n";

		echo $tab;
	}
?>
		</div>
	</div>
	<div class="right">
<?php
$is_user_current_tab = is_url_last_element('utente');

// If the current page is inside the `/utente` path, the login button will have the `current` class
$current_user_class = is_url_last_element('utente')
	? 'current'
	: '';

// User icon (based on login status)
$user_icon = '<i class="fas fa-sign-in-alt"></i>';
$admin = false;
if (AuthUser::is_logged_in()) {
	$user_icon = '<i class="fas fa-user"></i>';

	// If the user is an admin, show admin button
	if (AuthUser::is_admin()) {
		$is_admin_current_tab = is_url_last_element('admin');

		$current_admin_class = $is_admin_current_tab
			? 'current'
			: '';

		$admin_icon = '<i class="fas fa-table"></i>';

		$admin = "\t\t<a href=\"/utente/admin\" class=\"link admin $current_admin_class\">$admin_icon</a>\n";
	}
}

// If the user is an admin
if ($admin) echo $admin;

// Print user tab
echo "\t\t<a href=\"/utente\" class=\"link login $current_user_class\">$user_icon</a>\n";

?>
		<div class="lang-container">
			<span class="link language"><i class="fas fa-globe"></i></span>
			<form method="POST" id="languageForm"></form>
			<div class="lang-dropdown">
				<?php
				foreach ($availableLanguages as $lang) {
				?>
					<button class="lang" lang="<?php echo $lang[3]; ?>" form="languageForm" name="lang" value="<?php echo $lang[2]; ?>" type="submit">
						<?php
						// Each language button
						echo "<img src=\"/img/flags/$lang[1].svg\" draggable=\"false\"><span>$lang[0]</span>";
						?>
					</button>
				<?php
				}
				?>
			</div>
		</div>
	</div>

</nav>