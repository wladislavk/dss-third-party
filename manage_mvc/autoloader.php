<?php namespace Ds3\Libraries\Legacy; ?><?php

	function mlaphp_autoloader($class)
	{
		// strip off any leading namespace separator from PHP 5.3
		$class = ltrim($class, '\\');

		// the eventual file path
		$subpath = '';

		// is there a PHP 5.3 namespace separator?
		$pos = strrpos($class, '\\');
		if ($pos !== false) {
			// convert namespace separators to directory separators
			$ns = substr($class, 0, $pos);
			$subpath = str_replace('\\', DIRECTORY_SEPARATOR, $ns) . DIRECTORY_SEPARATOR;
			// remove the namespace portion from the final class name portion
			$class = substr($class, $pos + 1);
		}

		// convert underscores in the class name to directory separators
		$subpath .= str_replace('_', DIRECTORY_SEPARATOR, $class);

		// the path to our central class directory location
		$dir = APP_PATH;

		// prefix with the central directory location and suffix with .php,
		// then require it.
		$file = $dir . DIRECTORY_SEPARATOR . $subpath . '.php';
		require $file;
	}

	// register it with SPL
	spl_autoload_register('mlaphp_autoloader');

?>
