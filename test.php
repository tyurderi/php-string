<?php
/**
 * Created by PhpStorm.
 * User: tm-rm
 * Date: 10.03.16
 * Time: 15:01
 */

require_once __DIR__ . '/vendor/autoload.php';

$pattern = new WCKZ\StringUtil\MutateableString('Hello World');

$pattern[0]->after('H');

echo $pattern, PHP_EOL;