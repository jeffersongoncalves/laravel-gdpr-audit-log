# Changelog

All notable changes to this project will be documented in this file.

## 1.0.0 - 2026-11-17

First release: GDPR accountability audit log (Art. 5(2)) for Laravel, part of the laravel-gdpr suite.

- Logs who viewed, changed, exported or anonymized personal data. Only column names are stored, never values.
- The log is append-only and hash-chained (HMAC). `gdpr:audit-verify` finds altered, removed or inserted entries.
- The `AuditsPersonalData` trait logs changes to declared columns and deletions, and every anonymization (DSAR erasure, retention) is logged automatically. `auditAccess()` records views.

## [Unreleased]
