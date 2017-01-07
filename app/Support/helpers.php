<?php

use App\Support\Exceptions\AssetNotFoundException;

if ( !function_exists('cached_asset'))
{
	/**
	 * Returns the asset with the modified timestamp appended to it.
	 *
	 * @param string $path
	 * 
	 * @throws AssetNotFoundException
	 * @return string
	 */
	function cached_asset($path)
	{

		$realPath = public_path($path);

		if (!file_exists($realPath)) {
			throw new AssetNotFoundException(sprintf(
				'File "%s" not found.',
				$realPath
			));
		}

		return asset(sprintf(
			'%s?%s',
			$path,
			filemtime($realPath)
		));

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
		$filename = base_path() . DIRECTORY_SEPARATOR . 'VERSION';

		// Return the content as a string
		return (string) trim(File::get($filename));

	}
}
