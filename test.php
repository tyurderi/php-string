<?php
/**
 * Created by PhpStorm.
 * User: tm-rm
 * Date: 10.03.16
 * Time: 15:01
 */

require_once __DIR__ . '/vendor/autoload.php';

$pattern = new WCKZ\StringUtil\StaticString('Hello World');
foreach($pattern as $char)
{
    echo $char->value(), PHP_EOL;
}