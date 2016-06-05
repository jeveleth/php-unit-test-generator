#!/usr/bin/env php
<?php


require __DIR__.'/vendor/autoload.php';

use Acme\TestGenerator;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new TestGenerator());
$application->run();