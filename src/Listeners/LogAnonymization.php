<?php

namespace JeffersonGoncalves\GdprAuditLog\Listeners;

use JeffersonGoncalves\Gdpr\Events\PersonalDataAnonymized;
use JeffersonGoncalves\GdprAuditLog\AuditLogger;

class LogAnonymization
{
    public function __construct(protected AuditLogger $logger) {}

    public function handle(PersonalDataAnonymized $event): void
    {
        $this->logger->record('anonymized', $event->model, $event->columns);
    }
}
