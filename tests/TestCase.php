<?php

namespace JeffersonGoncalves\GdprAuditLog\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use JeffersonGoncalves\Gdpr\GdprServiceProvider;
use JeffersonGoncalves\GdprAuditLog\GdprAuditLogServiceProvider;
use JeffersonGoncalves\GdprAuditLog\Tests\Fixtures\Customer;
use JeffersonGoncalves\PestPluginDatabaseMigrations\LoadsPackageMigrations;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use LoadsPackageMigrations;

    protected function getPackageProviders($app): array
    {
        return [
            GdprServiceProvider::class,
            GdprAuditLogServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('app.key', 'base64:'.base64_encode(str_repeat('a', 32)));
        $app['config']->set('database.default', 'testing');
        $app['config']->set('gdpr.models', [Customer::class]);
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadPackageMigrations(GdprAuditLogServiceProvider::class);

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('plan')->nullable();
        });
    }
}
