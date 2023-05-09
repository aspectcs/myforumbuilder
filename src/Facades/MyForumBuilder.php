<?php

namespace Aspectcs\MyForumBuilder\Facades;

use Illuminate\Support\Facades\Facade;

class MyForumBuilder extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'MyForumBuilder';
    }
}
