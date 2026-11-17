<?php

namespace JeffersonGoncalves\GdprAuditLog\Tests;

use JeffersonGoncalves\GdprAuditLog\GdprAuditLogServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            GdprAuditLogServiceProvider::class,
        ];
    }
}
