<?php

require_once __DIR__ . '/vendor/jedkirby/php-cs/src/Config.php';

use PhpCsFixer\Finder;
use Jedkirby\PhpCs\Config;

$finder = Finder::create();
$finder->in(__DIR__ . '/src');

$config = new Config();
$config->setFinder($finder);

return $config;
