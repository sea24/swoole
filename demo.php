<?php
include "vendor/autoload.php";
use Src\Sea\Test;

$httpServer = new Test();
print_r($httpServer->test());