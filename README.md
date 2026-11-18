# Laravel GDPR Audit Log

![Laravel GDPR Audit Log](https://raw.githubusercontent.com/jeffersongoncalves/laravel-gdpr-audit-log/main/art/jeffersongoncalves-laravel-gdpr-audit-log.png)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/laravel-gdpr-audit-log.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-gdpr-audit-log)
[![Tests](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-gdpr-audit-log/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jeffersongoncalves/laravel-gdpr-audit-log/actions/workflows/tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/laravel-gdpr-audit-log.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-gdpr-audit-log)

The EU General Data Protection Regulation (GDPR) makes the controller responsible for, and able to demonstrate, compliance (accountability, Art. 5(2)), and asks for measures that ensure the security of processing (Art. 32). This package keeps an audit trail of who viewed, changed, exported or anonymized personal data, built on [laravel-gdpr](https://github.com/jeffersongoncalves/laravel-gdpr)'s `#[PersonalData]` declarations.

- **Column names, never values:** the log itself doesn't copy the data it protects.
- **Append-only and hash-chained:** each entry carries an HMAC of the previous one. `gdpr:audit-verify` tells you if an entry was altered, removed from the middle or inserted.
- **Automatic where Eloquent can see it:** changes to personal data columns, deletions, and every anonymization (DSAR erasure, retention).

> This package gives you tooling. It does not make you compliant on its own.

## Installation

```bash
composer require jeffersongoncalves/laravel-gdpr-audit-log
php artisan vendor:publish --tag="gdpr-audit-log-migrations"
php artisan migrate
```

Set `GDPR_HASH_KEY` (see laravel-gdpr). The chain falls back to `APP_KEY`, and rotating the key makes older entries fail verification.

## Usage

Add the trait to the models that hold personal data:

```php
use JeffersonGoncalves\GdprAuditLog\Concerns\AuditsPersonalData;

#[PersonalData('email', anonymize: AnonymizeStrategy::Hash)]
class Customer extends Model implements HasPersonalData
{
    use AuditsPersonalData;
    use InteractsWithPersonalData;
}
```

- Updating a declared column logs `updated` with the column names. Other columns are ignored.
- Deleting the model logs `deleted`.
- `anonymizePersonalData()`, called directly, by [laravel-gdpr-dsar](https://github.com/jeffersongoncalves/laravel-gdpr-dsar) or by [laravel-gdpr-retention](https://github.com/jeffersongoncalves/laravel-gdpr-retention), logs `anonymized`. That save also logs `updated` first.

Eloquent can't tell when data is read, so log access where you show it:

```php
$customer->auditAccess('Support ticket #42');            // all declared columns
$customer->auditAccess('Billing', ['email']);

GdprAuditLog::record('exported', $customer, ['email'], 'Answer a DSAR', ['ticket' => 42]);
```

The actor is the authenticated user unless you pass `actor:`. The IP address and user agent of the request are stored too (`store_request`). They are personal data, so they stay out of the hash chain and can be anonymized without breaking it.

### Verifying

```bash
php artisan gdpr:audit-verify
```

```php
// routes/console.php
Schedule::command('gdpr:audit-verify')->daily();
```

The oldest entry you kept is trusted as the start of the chain, so deleting old entries from the start keeps the rest verifiable. A gap in the middle does not.

## Upgrading to 2.0

2.0 runs on [laravel-privacy](https://github.com/jeffersongoncalves/laravel-privacy), the engine shared by the
LGPD, GDPR, CCPA, US privacy and Quebec suites. The classes, config keys, tables, commands and events of this package
keep their names: your code, config and data need no change. Suites installed side by side never see each other's
events. If you extend a class of this package, it now inherits from its `JeffersonGoncalves\Privacy` base.

## Testing

```bash
composer test
```

## Changelog

See [CHANGELOG](CHANGELOG.md).

## License

The MIT License (MIT). See [License File](LICENSE.md).
