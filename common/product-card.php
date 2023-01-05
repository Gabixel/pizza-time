<?php
// If the file is called directly and not included
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
	header('Location: /');
}

@define('DOCUMENT_ROOT', '/membri/gabrieldn5j');

class ProductCard
{
	private static $icon_types = [
		1 => 'pizza-classica',
		2 => 'calzone',
		3 => 'pizza-speciale',
		4 => 'bevanda',
		5 => 'dolce',
		6 => 'fritto',
	];

	public static $icon_path = '/img/product-types/';

	/**
	 * Creates a product card with the information given to this.
	 * 
	 * It creates the entire product card in a string containing HTML elements based on the parameters.
	 * 
	 * @param	int		$id							Product ID.
	 * @param	bool	$is_user_logged_in			Checks if the user is logged in. If true, the card doesn't ask for login. Default is `false`.
	 * @param	bool	$is_available				Checks if the product is out-of-stock. Default is `true`.
	 * @param	int		$type						The product type (like *'Pizza'*, *'Drink'*, etc.). Default is `1` (*'Pizza'*).
	 * @param	bool	$is_frozen					Checks if the product is initially frozen or not. Default is `false`.
	 * @param	string	$image						The image path/file name.
	 * @param	string	$title						The title of the product (e.g. *'Margherita'*).
	 * @param	string	$price_total				The price (in Euro) as a string. Will be splitted in the decimals and the integer part since float can fail.
	 * @param	array	$ingredients_normal			Normal ingredients list. Default is empty.
	 * @param	array	$ingredients_post_cooking	Post-cooked ingredients list. It's also used to check if there are any of these ones. Default is empty.
	 * @param	string	$description				In case of empty ingrendients (e.g. water), the description will be used.
	 * @param	array	$translation				Translations array.
	 * 
	 * @return	string	The string containing all the HTML tags for the product card.
	 */
	public static function create(
		int $id,
		bool $is_user_logged_in = false,
		bool $is_available = true,
		int $type = 1,
		bool $is_frozen = false,
		string $image,
		string $title,
		float $price_total,
		array $ingredients_normal = [],
		array $ingredients_post_cooking = [],
		string $description = "",
		array $translation
	) {
		$available_class = $is_available ? '' : 'unavailable';

		// Open card
		$product_card = "\t\t\t<div class=\"product $available_class\">\n";

		// Preview (image + checkbox)
		// TODO: customers' favourite products, new products
		$product_card .= self::get_preview($id, $is_available, $image, $is_user_logged_in, $translation['products']['checkbox']);

		// Title + frozen
		$product_card .= self::get_title($title, $type, $is_frozen, $translation['products']);

		// Price (small)
		$product_card .= self::get_price_small($price_total, $translation['price']['decimals_separator']);

		// Description (with text or ingredients)
		// TODO: frozen ingredients
		$product_card .= self::get_description($ingredients_normal, $ingredients_post_cooking, $description, $translation['ingredients']);

		// Horizontal line
		$product_card .= "\t\t\t\t<hr>\n";

		// Extra info (bigger price, post-cooking tip)
		// check if there are post-cooking ingredients. if so, add the tip
		// self::get_price_big();
		$product_card .= self::get_extra_info($ingredients_post_cooking, $price_total, $translation);

		// Add the unavailable text if it's out of stock
		if (!$is_available) $product_card .= self::get_unavailable_status($translation['products']['unavailable']);

		// Close card
		$product_card .= "\t\t\t</div>\n";

		return $product_card;
	}

	// Image + checkbox + login/click tip 
	private static function get_preview($id, $is_available, $image, $is_user_logged_in, $translation)
	{
		// Open preview
		$product_preview = "\t\t\t\t<div class=\"productPreview\">\n";

		// If not logged in or out-of-stock, add the disabled attribute to the checkbox
		$disabled_attribute = $is_available && $is_user_logged_in ? '' : 'disabled';
		// Checkbox
		$product_preview .= "\t\t\t\t\t<input type=\"checkbox\" value=\"$id\" class=\"productCheckBox\" $disabled_attribute>\n";

		// Image path
		$image = "/img/products/$image";

		// If the image doesn't exists, show a generic one
		if (!file_exists(DOCUMENT_ROOT . $image)) $image = "/img/products/default.jpg";

		// Image container
		$product_preview .= "\t\t\t\t\t<div class=\"productImage\" style=\"--img: url('$image')\"></div>\n";

		// Check if the user is logged in. If not, ask to login/register
		$message = $is_user_logged_in
			? $translation['user']
			: $translation['guest'];
		// Tip message
		$product_preview .= "\t\t\t\t\t<p>$message</p>\n";

		// Close preview
		$product_preview .= "\t\t\t\t</div>\n";

		return $product_preview;
	}

	// Div + full title
	private static function get_title($title, $product_type, $is_frozen, $translations)
	{
		// Open title
		$product_title = "\t\t\t\t<div class=\"productTitle\">\n";

		$product_title .= self::get_full_title($title, $product_type, $is_frozen, $translations);

		// Close title
		$product_title .= "\t\t\t\t</div>\n";

		return $product_title;
	}

	// Icon product type + title + (if) frozen icon
	private static function get_full_title($title, $product_type, $is_frozen, $translations)
	{
		// Open full title
		$product_full_title = "\t\t\t\t\t<div class=\"productFullTitle\">\n";

		// Open title (+ tooltip with full title)
		$product_full_title .= "\t\t\t\t\t\t<span title=\"$title\">";

		// Icon
		$product_full_title .= self::get_product_type_icon($product_type, $translations['type']);

		// Title string
		$product_full_title .= '<span>' . htmlentities($title) . '</span>';

		// Close title
		$product_full_title .= "</span>\n";

		// Close full title
		$product_full_title .= "\t\t\t\t\t</div>\n";

		// If the product is frozen, add the icon
		if ($is_frozen) $product_full_title .= "\t\t\t\t\t<i class=\"far fa-snowflake\" title=\"" . $translations['frozen'] . "\"></i>\n";

		return $product_full_title;
	}

	// Product icon
	private static function get_product_type_icon($product_type, $icon_translation)
	{
		$icon = '';

		$icon = self::get_product_type_image_file($product_type);
		if (!$icon) {
			$icon = 'generico';
			$product_type = 0;
		}

		$icon = '<img src="' . self::$icon_path . $icon;

		$icon_title = isset($icon_translation[$product_type]) ? $icon_translation[$product_type] : '';
		$icon_title = $icon_title ? "alt=\"$icon_title\" title=\"$icon_title\"" : '';

		// Close the image
		$icon .= ".svg\" $icon_title>";

		return $icon;
	}

	public static function get_product_type_image_file($product_type)
	{
		if (!isset(self::$icon_types[$product_type])) return false;

		return self::$icon_types[$product_type];
	}

	// Price formatted with language decimal separator
	private static function get_price_formatted($price_total, $decimals_separator)
	{
		// Splitting algorithm
		$price_integer = floor($price_total);
		$decimals_position = strpos($price_total, '.') + 1;
		$price_decimals = substr($price_total, $decimals_position);

		// If there's only one digit of decimal, multiply it by 10 and re-convert to string
		$price_decimals =
			(floor(intval($price_decimals) / 10) === 0.0)
			? strval(intval($price_decimals) * 10)
			: $price_decimals;

		$price_formatted = sprintf('%s%d%s%02d', "&euro; ", $price_integer, $decimals_separator, $price_decimals);

		return $price_formatted;
	}

	// Price (small version)
	private static function get_price_small($price_total, $decimals_separator)
	{
		$price = self::get_price_formatted($price_total, $decimals_separator);

		// Price container
		$product_price_small = "\t\t\t\t<div class=\"productPriceSmall\"><span>$price</span></div>\n";

		return $product_price_small;
	}

	// Description (with text or ingredients)
	private static function get_description($ingredients_normal = [], $ingredients_post_cooking = [], $description = "", $translation)
	{
		// Open description
		$product_description = "\t\t\t\t<div class=\"productDescription\">\n";

		// If there's no description
		if (!$ingredients_normal && !$ingredients_post_cooking && !$description) {
			return "";
		}


		if ($description) {
			$product_description .= "\t\t\t\t\t<p class=\"alternative\">";
			$product_description .= $description;

			// Close description
			$product_description .= "</p>\n";
			$product_description .= "\t\t\t\t</div>\n";

			return $product_description;
		}

		// Else the product has ingredients

		$product_description .= "\t\t\t\t\t<p>";
		$product_description .= self::get_ingredients($ingredients_normal, $ingredients_post_cooking, $translation);

		// Close description
		$product_description .= "</p>\n";
		$product_description .= "\t\t\t\t</div>\n";

		return $product_description;
	}

	private static function get_ingredients($ingredients_normal = [], $ingredients_post_cooking = [], $translation)
	{
		// Count the number of post-cooking ingredients
		$total_post_cooking = count($ingredients_post_cooking ?? 0);

		$product_ingredients = "";

		// If there are normal ingredients
		if (isset($ingredients_normal) && !empty($ingredients_normal)) {

			// For each normal ingredient
			for ($i = 0; $i < count($ingredients_normal); $i++) {

				if (!isset($translation[$ingredients_normal[$i]])) {
					return "";
				}

				// If it's not the first element
				if ($i > 0) {
					// If it's the last ingredient and there are no post-cooking ones
					if ((($i + 1) == count($ingredients_normal)) && $total_post_cooking === 0) {
						$product_ingredients .= ' ' . $translation['separator'];
					} else {
						$product_ingredients .= ',';
					}

					$product_ingredients .= ' ';
				}

				$product_ingredients .= htmlentities($translation[$ingredients_normal[$i]]);
			}
		}
		// else there are no normal ingredients
		else $ingredients_normal = false;

		// If there are post-cooking ingredients
		if ($total_post_cooking > 0) {

			// If there was at least 1 normal ingredient and there's only one post-cooking
			if ($ingredients_normal && $total_post_cooking == 1) {
				$product_ingredients .= ' ' . $translation['separator'] . ' ';
			}

			// For each post-cooking ingredient
			for ($i = 0; $i < $total_post_cooking; $i++) {
				if (!isset($translation[$ingredients_post_cooking[$i]])) {
					return "";
				}

				// If it's not the first element
				if ($i > 0) {
					// If it's the last post-cooking ingredient
					if (($i + 1) == $total_post_cooking) {
						$product_ingredients .= ' ' . $translation['separator'];
					} else {
						$product_ingredients .= ',';
					}

					$product_ingredients .= ' ';
				}

				$product_ingredients .= "<span class=\"postCooking\">";
				$product_ingredients .= htmlentities($translation[$ingredients_post_cooking[$i]]);
				$product_ingredients .= "</span>";
			}
		}

		return $product_ingredients;
	}

	private static function get_extra_info($ingredients_post_cooking = [], $price, $translations)
	{
		// Open extra
		$product_extra = "\t\t\t\t<div class=\"infoExtra\">\n";

		// Check if there are post-cooking ingredients
		$has_post_cooking_ingredients = isset($ingredients_post_cooking) && !empty($ingredients_post_cooking);
		if ($has_post_cooking_ingredients) {
			// Add post-cooking tip
			$product_extra .= "\t\t\t\t\t<i class=\"fas fa-info-circle\"></i>";
			$product_extra .= "<span class=\"infoCook\">" . $translations['products']['post_cook'] . "</span>\n";
		}

		// Price (big version)
		$product_extra .= "\t\t\t\t\t<span class=\"productPrice\">";

		$product_extra .= self::get_price_formatted($price, $translations['price']['decimals_separator']);

		$product_extra .= "</span>\n";

		// Close extra
		$product_extra .= "\t\t\t\t</div>\n";
		return $product_extra;
	}

	private static function get_unavailable_status($translation)
	{
		$product_sold_out = "\t\t\t<div class=\"productSoldOut\">\n";

		$product_sold_out .= "\t\t\t\t<span class=\"soldOutText\">$translation</span>";

		$product_sold_out .= "\t\t\t</div>\n";

		return $product_sold_out;
	}
}

class ProductRequests
{
	public static function get_products(&$sql_query, $search = "")
	{
		$search = $sql_query->escape_string($search);

		// Request for all products, ordered by id and type.
		$query =
			"SELECT *
			FROM `products` p";

		if ($search) $query .= " WHERE p.name LIKE '%$search%'";

		$query .= " ORDER BY p.id_type ASC, p.id ASC";

		$products_query = $sql_query->request($query);

		// If there are no products
		if (!$products_query || $products_query->num_rows == 0) return [];

		// Products array
		$total_products = [];

		// Indexes
		$i = 0;

		// For each products
		while ($product = $products_query->fetch_assoc()) {
			// Store the product by its id_type
			$total_products[$i] = $product;
			// Increment index
			$i++;
		}

		return $total_products;
	}

	public static function get_filtered_products(&$sql_query, $search, $translation)
	{
		$search = $sql_query->escape_string($search);

		// Request for all products, ordered by id and type.
		$query =
			"SELECT *
			FROM `products` p";


		if ($search) {
			$product_indexes = self::array_search_partial($translation, $search);

			$query .= ' WHERE p.id IN (';

			if (!empty($product_indexes)) {
				$total_indexes = count($product_indexes) - 1;

				foreach ($product_indexes as $index => $value) {
					$query .= "'$value'";

					if ($index < $total_indexes) $query .= ',';
				}
			}

			$query .= ')';
		}

		$query .= " ORDER BY p.id_type ASC, p.id ASC";

		$products_query = $sql_query->request($query);

		// If there are no products
		if (!$products_query || $products_query->num_rows == 0) return [];
		// Products array
		$total_products = [];

		// Indexes
		$i = 0;

		// There's probably a better way, but I'll try to keep things simple
		// For each products
		while ($product = $products_query->fetch_assoc()) {
			// Store the product by its id_type and increment
			$total_products[$i] = $product;

			// Image

			$image_dir = '/img/products/';

			$image = isset($total_products[$i]['image']) ? $total_products[$i]['image'] : 'default.jpg';

			// If the image doesn't exists, show a generic one
			if (!file_exists(DOCUMENT_ROOT . $image_dir . $image)) {
				$image = 'default.jpg';
			}

			$total_products[$i]['image'] = $image_dir . $image;

			// Icon

			$icon = 'generico';
			$file = ProductCard::get_product_type_image_file($product['id_type']);
			if ($file) $icon = $file;
			$total_products[$i]['iconType'] = ProductCard::$icon_path . $icon . '.svg';

			$i++;
		}

		return $total_products;
	}

	// source for part of the function: https://gist.github.com/zuhairkareem/a8d7696663ad716adcf18ff5607a8ec8
	private static function array_search_partial($arr, $keyword)
	{
		$keyword = strtolower($keyword);
		$indexes = [];
		$i = 0;

		foreach ($arr as $index => $string) {
			if (strpos(strtolower($string), $keyword) !== FALSE)
				$indexes[$i++] = $index;
		}

		return $indexes;
	}

	public static function get_ingredients_id(&$sql_query, $product_id, $post_cooking = false)
	{
		// If the ingredient is post-cooking or not
		$post_cooking = $post_cooking ? 1 : 0;

		$query =
			"SELECT i.id
			FROM `ingredients` i
			INNER JOIN `ingredients_in_products` ip ON ip.id_ingredient = i.id
			WHERE ip.id_product = $product_id AND i.post_cooking = $post_cooking";

		$ingredients_query = $sql_query->request($query);

		// If it contains ingredients
		if ($ingredients_query->num_rows == 0) return [];

		// Ingredients array
		$ingredients_total = [];

		// Index
		$i = 0;

		// For each (pre- or post-cooking) ingredient
		while ($ingredient = $ingredients_query->fetch_assoc()) {
			// Set the ingredients in the array
			$ingredients_total[$i++] = $ingredient['id'];
		}

		return $ingredients_total;
	}
}
