<?php
// If the file is called directly and not included
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
	header('Location: /');
}

@define('DOCUMENT_ROOT', '/membri/gabrieldn5j');

class ImageGallery
{
	public static function generate_gallery($dir)
	{
		$gallery = '';

		$img_list = self::get_image_list($dir);

		// Create images
		foreach($img_list as $image) {
			$gallery .= self::create_image_card($dir, $image);
		}

		return $gallery . "\n";
	}

	private static function create_image_card($dir, $image)
	{
		$tabs = "\n\t\t\t";
		$card = "$tabs<div class=\"gallery-image-container\"><div class=\"gallery-image\" style=\"--img: url('$dir$image');\"></div></div>";

		return $card;
	}

	private static function get_image_list($dir)
	{
		$document_root = DOCUMENT_ROOT;

		$list = scandir($document_root . $dir, 0);

		// Remove first two elements related to the directory ('.' & '..')
		unset($list[0], $list[1]);

		return $list;
	}
}
