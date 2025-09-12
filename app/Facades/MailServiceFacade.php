<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\MailService;

class MailServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MailService';
    }
}