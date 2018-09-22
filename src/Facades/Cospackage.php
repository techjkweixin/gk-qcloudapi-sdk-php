<?php
namespace Gkcosapi\Cospackage\Facades;

use Illuminate\Support\Facades\Facade;

class Cospackage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Gkcosapi\Cospackage\Cospackage';
    }
}