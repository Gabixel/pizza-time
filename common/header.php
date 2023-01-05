<?php
// If the file is called directly and not included
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
	header('Location: /');
}

// Define a constant for the server root
@define('DOCUMENT_ROOT', '/membri/gabrieldn5j');

// For authentication
@session_start();

// Timezone
date_default_timezone_set('Europe/Rome');

// Includes the language check function
require_once DOCUMENT_ROOT . '/common/language.php';

$title_page = '';
$language = get_current_language_pages($pages ?? [], ['head', 'navbar', 'footer']);

// Find the page title
$title_page = isset($pages) && isset($language[$pages[0]]['page_title'])
	? $language[$pages[0]]['page_title']
	: '';

if (!$title_page) {
	$title_page = 'Home';

	foreach ($language as $lang) {
		if (!isset($lang['page_title'])) continue;

		// Title found
		$title_page = $lang['page_title'];
		break;
	}
}

$title_page = "$title_page &bull; Pizza Time";

$server_url = $_SERVER['SERVER_NAME'];

$server_url_insecure = 'http://' . $server_url;
$server_url = 'https://' . $server_url;

$full_url = $server_url . $_SERVER['REQUEST_URI'];

?>

<!DOCTYPE html>
<html lang="<?php echo $language['head']['html_lang']; ?>" prefix="og: https://ogp.me/ns#">

<head>
	<title><?php echo $title_page; ?></title>
	<?php include DOCUMENT_ROOT . '/common/meta.php'; ?>
	<link rel="preload" as="font" crossorigin type="font/woff2" href="/fonts/Oregano/Oregano-Regular.woff2">
	<link rel="preload" as="font" crossorigin type="font/woff2" href="/fonts/Oregano/Oregano-Italic.woff2">
	<link rel="preload" as="font" crossorigin type="font/woff" href="/fonts/Oregano/Oregano-Regular.woff">
	<link rel="preload" as="font" crossorigin type="font/woff" href="/fonts/Oregano/Oregano-Italic.woff">
	<link rel="preload" as="style" href="/css/base.css">
	<link rel="preload" as="style" href="/css/navbar.css">
	<link rel="preload" as="style" href="/css/body.css">
	<link rel="preload" as="style" href="/css/footer.css">
	<link rel="preload" as="script" href="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js">
	<link rel="preload" as="script" href="/js/navbar.js">
	<link rel="preload" as="script" href="/js/body.js">
	<link rel="preload" as="script" href="/js/page-check.js">
	<style>
		<?php include DOCUMENT_ROOT . '/common/fonts.php'; ?>
	</style>
	<link rel="stylesheet" href="/css/base.css">
	<link rel="stylesheet" href="/css/navbar.css">
	<link rel="stylesheet" href="/css/body.css">
	<link rel="stylesheet" href="/css/footer.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="/js/navbar.js"></script>
	<script src="/js/body.js"></script>
	<script src="/js/page-check.js"></script>
	<?php
	// If there are per-page specific attributes
	if (isset($head_attributes)) {
		foreach ($head_attributes as $attr) {
			echo "\t$attr\n";
		}
	}
	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
	<link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
	<link rel="manifest" href="/img/favicon/site.webmanifest">
	<link rel="mask-icon" href="/img/favicon/safari-pinned-tab.svg" color="#c23d3d">
	<link rel="shortcut icon" href="/img/favicon/favicon.ico">
	<meta name="msapplication-TileColor" content="#c23d3d">
	<meta name="msapplication-config" content="/img/favicon/browserconfig.xml">
	<!--<link rel="canonical" href="<php echo $server_url; ?>">-->
</head>