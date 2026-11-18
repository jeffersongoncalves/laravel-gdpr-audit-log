<?php

namespace JeffersonGoncalves\GdprAuditLog;

use JeffersonGoncalves\Gdpr\Gdpr;
use JeffersonGoncalves\GdprAuditLog\Models\AuditLog;
use JeffersonGoncalves\Privacy\AuditLog\AuditLogger as BaseAuditLogger;

/**
 * Append-only, hash-chained log of who did what to whose personal data.
 *
 * @method AuditLog record(string $action, ?\Illuminate\Database\Eloquent\Model $subject = null, list<string> $columns = [], ?string $purpose = null, array<string, mixed> $metadata = [], ?\Illuminate\Database\Eloquent\Model $actor = null)
 */
class AuditLogger extends BaseAuditLogger
{
    protected string $config = 'gdpr-audit-log';

    protected string $model = AuditLog::class;

    public function __construct(Gdpr $gdpr)
    {
        parent::__construct($gdpr);
    }
}
