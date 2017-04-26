<?php

if (!function_exists('casset')) {
    /**
     * Generate an asset path for the application, with modifies timestamps.
     *
     * @param string $path
     *
     * @return string
     */
    function casset($path)
    {
        $file = public_path($path);

        if (file_exists($file)) {
            $path .= '?t=' . filemtime($file);
        }

        return asset(
            $path,
            request()->secure()
        );
    }
}

if (!function_exists('client_version')) {
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
