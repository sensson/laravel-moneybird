<?php

use Saloon\Config;
use Sensson\Moneybird\Tests\TestCase;

Config::preventStrayRequests();

uses(TestCase::class)->in(__DIR__);
