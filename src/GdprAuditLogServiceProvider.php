<?php

namespace JeffersonGoncalves\GdprAuditLog;

use Illuminate\Support\Facades\Event;
use JeffersonGoncalves\Gdpr\Events\PersonalDataAnonymized;
use JeffersonGoncalves\GdprAuditLog\Commands\VerifyCommand;
use JeffersonGoncalves\GdprAuditLog\Listeners\LogAnonymization;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class GdprAuditLogServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('gdpr-audit-log')
            ->hasConfigFile()
            ->hasMigrations(['create_gdpr_audit_logs_table'])
            ->hasCommand(VerifyCommand::class);
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(AuditLogger::class);
    }

    public function packageBooted(): void
    {
        if (config('gdpr-audit-log.log_anonymizations', true)) {
            Event::listen(PersonalDataAnonymized::class, LogAnonymization::class);
        }
    }
}
