<?php

namespace JeffersonGoncalves\GdprAuditLog;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class GdprAuditLogServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-gdpr-audit-log')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations();
    }
}
