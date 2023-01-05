<?php
@define('DOCUMENT_ROOT', '/membri/gabrieldn5j');

require_once DOCUMENT_ROOT . '/common/sql.php';
require_once DOCUMENT_ROOT . '/common/user.php';
require_once DOCUMENT_ROOT . '/common/product-card.php';
require_once DOCUMENT_ROOT . '/common/product-list.php';
require_once DOCUMENT_ROOT . '/common/product-summary.php';

$pages = ['menu', 'ingredients', 'price', 'products'];
$head_attributes = [
	'<link rel="stylesheet" href="/css/menu-elements.css">',
	'<link rel="stylesheet" href="/css/menu-list.css">',
	'<link rel="stylesheet" href="/css/menu-search.css">',
	'<link rel="stylesheet" href="/css/menu-summary.css">',
	'<script src="/js/menu-search.js"></script>',
	'<script src="/js/menu-summary.js"></script>',
	'<script src="/js/products-checkbox.js"></script>'
];

include DOCUMENT_ROOT . '/common/header.php';

?>

<body>
	<?php include DOCUMENT_ROOT . '/common/navbar.php'; ?>

	<div id="mainBody">
		<div id="bodyHeadFilters">
			<div id="mainBodyHeader"><?php echo $language['menu']['title']; ?></div>
			<div id="menuSearch">
				<div id="searchForm">
					<label for="searchBar"><i class="fas fa-search"></i></label>
					<input type="search" name="search" id="searchBar" maxlength="255" spellcheck="false" autocomplete="off" placeholder="<?php echo $language['menu']['content']['search_placeholder']; ?>">
					<div class="cancelSearch" title="<?php echo $language['menu']['content']['cancel_search']; ?>"><i class="fas fa-eraser"></i></div>
				</div>
			</div>
			<div id="menuSummary">
				<?php ProductSummary::generate_summary($language['menu']['summary']); ?>
			</div>
		</div>
		<div id="menuProductsList">
			<?php
			// Start SQL connection
			$sql_query = new SQLQuery();

			// Product Card list generation
			ProductList::generate_list($sql_query, $language);

			// Stop SQL connection
			unset($sql_query);
			?>
		</div>
	</div>

	<div id="scrollToTop" class="invisible">
		<i class="fas fa-chevron-up"></i>
	</div>

	<?php include DOCUMENT_ROOT . '/common/footer.php'; ?>
</body>

</html>