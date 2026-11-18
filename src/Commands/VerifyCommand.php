<?php

namespace JeffersonGoncalves\GdprAuditLog\Commands;

use JeffersonGoncalves\GdprAuditLog\AuditLogger;
use JeffersonGoncalves\Privacy\AuditLog\Commands\VerifyCommand as BaseVerifyCommand;

class VerifyCommand extends BaseVerifyCommand
{
    protected $signature = 'gdpr:audit-verify';

    protected $description = 'Check that the GDPR audit log was not altered';

    protected string $logger = AuditLogger::class;
}
