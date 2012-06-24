<?php

Autoloader::map(array(
	'S3' => __DIR__.DS.'libraries'.DS.'S3'.DS.'S3'.EXT,
));
Autoloader::namespaces(array(
	'ls3' => Bundle::path('ls3'),
));