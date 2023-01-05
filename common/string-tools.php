<?php
// If the file is called directly and not included
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
	header('Location: /');
}

// Alternative to `str_ends` and `str_contains` (for older PHP versions)
function is_url_last_element(string $element)
{
	$url = explode('/', get_url());
	$url_length = count($url);
	$last_element = $url[$url_length - 1];

	// If the last element is empty, check the second-last
	if (empty($last_element) && count($url) >= 2) return $url[$url_length - 2] === $element;

	return $last_element === $element;
}

function get_url()
{
	// $uri = explode('/', $_SERVER['REQUEST_URI'])
	$uri = $_SERVER['REQUEST_URI'];

	return explode('?', $uri, 2)[0];
}
