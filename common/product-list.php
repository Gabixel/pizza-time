<?php
// If the file is called directly and not included
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
	header('Location: /');
}

@define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

require_once DOCUMENT_ROOT . '/common/product-card.php';

class ProductList
{

	public static function generate_list($sql_query, $language)
	{
		if (!$sql_query->is_db_connected()) {
			self::get_empty_list($language);
			return;
		}

		// Start Product Card generation

		// Checks if the user is logged in
		$is_user_logged_in = AuthUser::is_logged_in();

		// Setup variables
		$is_available = true; // is available
		$type = 1; // product type
		$is_frozen = false; // is frozen
		$image = ""; // image path
		$title = ""; // title
		$price_total = ""; // price
		$ingredients_normal = []; // normal ingredients
		$ingredients_post_cooking = []; // post-cook ingredients
		$description = ""; // description

		// Get products ordered by type
		$products = [];

		// Search
		$products = ProductRequests::get_products($sql_query);

		// There are no products?
		if (count($products) == 0) {
			self::get_empty_list($language);
			return;
		}

		// If there are products in the database

		// Foreach product in a product type
		foreach ($products as $current_product) {

			// Is available?
			$is_available = intval($current_product['is_available']) === 0 ? false : true;

			// Product ID
			$id = $current_product['id'];

			// Product type
			$type = $current_product['id_type'];

			// Is frozen?
			$is_frozen = intval($current_product['frozen']) === 0 ? false : true;

			// Image path
			$image = $current_product['image'];

			// Product title
			$title = $language['products']['title'];
			$title = isset($title[$id]) && $title[$id] ? $title[$id] : $current_product['name'];

			// Product price (as string)
			$price_total = $current_product['price'];

			// Normal ingredients
			$ingredients_normal = ProductRequests::get_ingredients_id($sql_query, $current_product['id'], false);

			// Post-cooking ingredients
			$ingredients_post_cooking = ProductRequests::get_ingredients_id($sql_query, $current_product['id'], true);

			// Product description
			$description = $language['products']['description'];
			$description = isset($description[$id]) && $description[$id] ? $description[$id] : '';

			// Final print
			echo ProductCard::create(
				$id, // id
				$is_user_logged_in, // show login / register message
				$is_available, // is available
				$type, // product type
				$is_frozen, // is frozen
				$image, // image
				$title, // title
				$price_total, // price
				$ingredients_normal, // normal ingredients
				$ingredients_post_cooking, // post-cook ingredients
				$description, // description
				$language // translations
			);
		}
		// Stop Product Card generation
	}

	private static function get_empty_list($language)
	{
?><div id="emptyResultContainer">
			<div class="resultImage"></div>
			<div class="resultMessage"><?php echo $language['menu']['search']['empty']; ?></div>
		</div><?php
			}
		}
