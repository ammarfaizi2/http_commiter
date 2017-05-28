<?php
require __DIR__ . '/vendor/autoload.php';

define('data',__DIR__ . '/data');
is_dir(data) or mkdir(data);
use Handler\ActionHandler;
(new ActionHandler(
	'ammarfaizi2',
	'454469123iceteag')
)->run();