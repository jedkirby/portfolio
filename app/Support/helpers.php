<?php

if ( ! function_exists('cached_asset'))
{
	/**
	 * Returns the asset with the modified timestamp appended to it.
	 *
	 * @param  string  $path
	 * @return string
	 *
	 * @throws LogicException
	 */
	function cached_asset($path)
	{

		// Get the full path to the asset.
		$realPath = public_path($path);

		if ( ! file_exists($realPath)) {
			throw new LogicException("File not found at [{$realPath}]");
		}

		// Get the last updated timestamp of the file.
		$timestamp = filemtime($realPath);

		// Append the timestamp to the path as a query string.
		$path .= '?'.$timestamp;

		return asset($path);

	}
}

if ( ! function_exists('client_version'))
{
	/**
	 * Returns the current client version from the file in the root of the site.
	 * 
	 * @return string
	 */
	function client_version()
	{

		// Get the path to the version file.
		$filename = base_path().DIRECTORY_SEPARATOR.'VERSION';

		// Return the content as a string
		return (string) trim(\File::get($filename));

	}
}
