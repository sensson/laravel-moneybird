<?php

use Saloon\Config;
use Saloon\Http\Faking\MockClient;
use Sensson\Moneybird\Tests\TestCase;

Config::preventStrayRequests();

uses(TestCase::class)->in(__DIR__);
uses()->beforeEach(fn () => MockClient::destroyGlobal())->in(__DIR__);
