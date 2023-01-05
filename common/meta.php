<?php
// If the file is called directly and not included
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
	header('Location: /');
}

@define('DOCUMENT_ROOT', '/membri/gabrieldn5j');

$description = htmlentities($language['head']['meta']['description']);
$image_path = '/img/banner.png';

?><meta charset="UTF-8" />
	<meta name="description" content="<?php echo htmlentities($language['head']['meta']['description']); ?>" />
	<meta name="keywords" content="<?php include DOCUMENT_ROOT . '/common/keywords.php'; ?>" />
	<meta name="theme-color" content="#923131" />
	<meta name="robots" content="index, follow" />
	<meta name="rating" content="general" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="twitter:card" content="summary" />
	<link itemprop="image" href="<?php echo $server_url . $image_path; ?>">
	<meta property="og:title" content="<?php echo $title_page; ?>" />
	<meta property="og:description" content="<?php echo $description; ?>" />
	<meta property="og:url" content="<?php echo $full_url; ?>" />
	<meta property="og:image" content="<?php echo $server_url_insecure . $image_path; ?>" />
	<meta property="og:image:secure_url" content="<?php echo $server_url . $image_path; ?>" />
	<meta property="og:image:alt" content="Logo Banner" />
	<meta property="og:image:width" content="1134" />
	<meta property="og:image:height" content="1134" />
	<meta property="og:type" content="website" />
	<meta property="og:site_name" content="Pizza Time" />
<?php

unset($description);

?>