<?php

namespace JeffersonGoncalves\GdprAuditLog\Models;

use JeffersonGoncalves\Gdpr\Attributes\PersonalData;
use JeffersonGoncalves\Gdpr\Concerns\InteractsWithPersonalData;
use JeffersonGoncalves\Gdpr\Contracts\HasPersonalData;
use JeffersonGoncalves\Gdpr\Enums\LegalBasis;
use JeffersonGoncalves\Privacy\AuditLog\AuditLog as BaseAuditLog;

/**
 * One audit entry. Append-only and hash-chained: only the request columns (personal data,
 * outside the chain) may change, so an actor can still be anonymized.
 */
#[PersonalData('ip_address', purpose: 'Accountability (Art. 5(2))', legalBasis: LegalBasis::LegalObligation)]
#[PersonalData('user_agent', purpose: 'Accountability (Art. 5(2))', legalBasis: LegalBasis::LegalObligation)]
class AuditLog extends BaseAuditLog implements HasPersonalData
{
    use InteractsWithPersonalData;

    public function getTable(): string
    {
        return config('gdpr-audit-log.table', 'gdpr_audit_logs');
    }
}
