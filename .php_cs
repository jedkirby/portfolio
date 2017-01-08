<?php

require_once realpath(__DIR__ . '/vendor/autoload.php');

use PhpCsFixer\Finder;
use Jedkirby\PhpCs\Config;

$finder = Finder::create();
$finder->in(__DIR__ . '/app');
$finder->in(__DIR__ . '/tests');
$finder->in(__DIR__ . '/resources/lang');
$finder->in(__DIR__ . '/resources/views');
$finder->in(__DIR__ . '/routes');

$config = new Config();
$config->setFinder($finder);

return $config;
