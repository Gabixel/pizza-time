<?php
@define('DOCUMENT_ROOT', '/membri/gabrieldn5j');

$pages = ['403'];

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
		<div id="mainBodyHeader"><?php echo $language['403']['title']; ?></div>

		<?php
		echo $language['403']['content']['description'];
		?>
	</div>

	<?php include DOCUMENT_ROOT . '/common/footer.php'; ?>
</body>

</html>