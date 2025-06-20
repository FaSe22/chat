<?php

namespace Fase\Chat\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Fase\Chat\Chat
 */
class Chat extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Fase\Chat\Chat::class;
    }
}
