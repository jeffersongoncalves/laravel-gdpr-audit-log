<?php

namespace JeffersonGoncalves\GdprAuditLog\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JeffersonGoncalves\GdprAuditLog\GdprAuditLog
 */
class GdprAuditLog extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-gdpr-audit-log';
    }
}
