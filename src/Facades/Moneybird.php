<?php

namespace Sensson\Moneybird\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Sensson\Moneybird\Moneybird
 */
class Moneybird extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Sensson\Moneybird\Moneybird::class;
    }
}
