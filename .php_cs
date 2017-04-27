<?php

use PhpCsFixer\Finder;
use Jedkirby\PhpCs\Config;

$finder = Finder::create();
$finder->in([
    __DIR__ . '/app',
    __DIR__ . '/config',
    __DIR__ . '/resources/lang',
    __DIR__ . '/resources/views',
    __DIR__ . '/routes',
    __DIR__ . '/tests',
]);

$config = new Config();
$config->setFinder($finder);

return $config;
