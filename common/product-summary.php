<?php
// If the file is called directly and not included
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
	header('Location: /');
}

class ProductSummary
{
	public static function generate_summary($translation)
	{
?>
		<div id="summaryTitle">
			<i class="fas fa-shopping-cart"></i>
			<p><?php echo $translation['title']; ?></p>
			<p class="summCount">0</p>
			<?php
			if (!empty($_GET)) {
				echo "<div class=\"no-checkout\"><p><i class=\"fas fa-exclamation-triangle\"></i>{$translation['no-checkout']}</p></div>";
			}
			?>
		</div>
		<!-- TODO: action="/checkout.php" method="POST"-->
		<form action="/menu.php" method="GET" name="summaryCheckout" id="summaryList" class="notResizing">
			<div id="summCheckout">
				<input type="submit" id="checkout" value="<?php echo $translation['buttons']['submit']; ?>" disabled>
				<input type="button" id="cancelSummary" value="<?php echo $translation['buttons']['empty']; ?>" disabled>
			</div>
		</form>
		<div id="summaryHider">
			<i class="fas"></i>
			<p class="hideMessage"><?php echo $translation['hider']['hide']; ?></p>
			<p class="showMessage"><?php echo $translation['hider']['show']; ?></p>
		</div>
<?php
	}
}
