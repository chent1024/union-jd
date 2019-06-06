<?php
error_reporting(E_ALL);
require dirname(__DIR__) . '/vendor/autoload.php';

$jd = new \UnionJd\Client([
    'app_key' => 'xxx',
    'secret_key' => 'xxx'
]);

$rs = $jd->order->query(['time' => '2019041610']);

print_r($rs);
