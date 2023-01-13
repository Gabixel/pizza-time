<?php
@define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

// If there's no POST request
if (!isset($_POST['type']) || ($_POST['type'] != 'translation' && $_POST['type'] != 'search')) {
	// Unauthorized
	http_response_code(403);
    include DOCUMENT_ROOT . '/403.php';
    exit();
}

@session_start();

require_once DOCUMENT_ROOT . '/common/language.php';
$language = get_current_language_pages(['products', 'ingredients', 'menu', 'price']);
$language['search'] = $language['menu']['search'];
$language['menu'] = NULL;

// If translation is requested
if ($_POST['type'] === 'translation') {
	echo json_encode($language);
	exit;
}

require_once DOCUMENT_ROOT . '/common/product-card.php';
require_once DOCUMENT_ROOT . '/common/sql.php';
require_once DOCUMENT_ROOT . '/common/user.php';

$sql_query = new SQLQuery();

$result['products'] = [];
$result['user']['is_logged_in'] = AuthUser::is_logged_in();

// If the dabase is correctly connected
if ($sql_query->is_db_connected()) {
	$search = $_POST['search'];
	
	// Retrieve JSON array of products + user login state + translation extras
	$result['products'] = ProductRequests::get_filtered_products($sql_query, $search, $language['products']['title']);

	$total_products = count($result['products']);

	// For each product, include (separated) ingredients
	for ($i = 0; $i < $total_products; $i++) {
		$result['products'][$i]['ingredients_normal'] =
			ProductRequests::get_ingredients_id($sql_query, $result['products'][$i]['id'], false);

		$result['products'][$i]['ingredients_post_cooking'] =
			ProductRequests::get_ingredients_id($sql_query, $result['products'][$i]['id'], true);
	}
}

echo json_encode($result);
