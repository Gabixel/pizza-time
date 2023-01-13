<?php
@define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

$pages = ['404'];

$head_attributes = [
	'<style>
	#mainBody {
		text-align: center;
	}
	</style>'
];

include DOCUMENT_ROOT . '/common/header.php';

?>

<body>
	<?php include DOCUMENT_ROOT . '/common/navbar.php'; ?>

	<div id="mainBody">
		<div id="mainBodyHeader"><?php echo $language['404']['title']; ?></div>

		<?php
		echo $language['404']['content']['description'];
		?>
	</div>

	<?php include DOCUMENT_ROOT . '/common/footer.php'; ?>
</body>

</html>