<?php
// If the file is called directly and not included
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
	header('Location: /');
}

@define('DOCUMENT_ROOT', '/membri/gabrieldn5j');

/**
 * Language check.
 * 
 * Checks which language the user has selected, and returns an array with the current page's words.
 * 
 * @param array $requestedPages Name of requested pages. The page name is based on its php file in the languages folder. If omitted, defaults are 'home', 'navbar' and 'header'.
 * 
 * @return array An associative array containing the transations.
 */
function get_current_language_pages(array $requestedPages, array $additionalPages = [])
{
	// Languages root file
	$languagePath = DOCUMENT_ROOT . '/lang';

	// Array of valid languages
	$validLanguages = get_valid_languages();

	// Default fallback language
	$lang = 'en';

	if (isset($additionalPages)) {
		// Adds additional pages to the requested ones
		foreach ($additionalPages as $page) {
			array_push($requestedPages, $page);
		}

		unset($page);
	}

	// Sets the language
	set_language($validLanguages, $lang);

	// Creates an array with all requested translations
	$translation = [];

	// Adds translations of each requested page in the associative array.
	// The current directory should be the root because the caller file is in the root
	foreach ($requestedPages as $page) {
		if (isset($requestedPages)) {
			$path = "$languagePath/$lang/$page.php";

			// If transation file doesn't exists, the italian version will be used
			$currentPage = require($path);

			$translation[$page] = $currentPage;
		}
	}

	// Returns an associative array containing words of the requested pages
	return $translation;
}

function checkHttpLanguage($validLanguages)
{
	// Get the language from the HTTP request
	$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

	// If the language is not 'it' or 'en', fallback to 'en'
	$lang = in_array($lang, $validLanguages) ? $lang : 'en';

	return $lang;
}

function get_valid_languages()
{
	return ['it', 'en'];
}

function set_language(array $validLanguages, string &$lang)
{
	// If there's a request for a new language
	if (isset($_POST['lang']) && in_array($_POST['lang'], $validLanguages)) {
		$lang = $_POST['lang'];
	}

	// If there's already a cookie with language
	if (!isset($_POST['lang']) && isset($_COOKIE['lang'])) {

		$cookieLang = $_COOKIE['lang'];

		// If the cookie is already equal to local language variable
		if ($cookieLang === $lang || !in_array($cookieLang, $validLanguages))
			return;

		// If the cookie has a different language, and it's a valid one
		$lang = $cookieLang;

		return;
	}

	// Fallback to http language (or english if it fails) when there's no language selected
	if (!isset($_POST['lang']) || !in_array($_POST['lang'], $validLanguages)) {
		$lang = checkHttpLanguage($validLanguages);
		return; // Language should not be set with the fallback one because it could mess with web engines
	}

	// If the language is not set, it gets set to the cookie for 30 days..
	setcookie('lang', $lang, time() + 60 * 60 * 24 * 30, '/');

	// ..and the page will be reloaded to avoid a potential 'resend module' pop-up after refreshing the page
	header('Location: ' . $_SERVER['REQUEST_URI']);
	exit(0);
}
