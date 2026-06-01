<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Business Purpose: منع PHPUnit من مسح قاعدة التطوير eliyaa_local عبر RefreshDatabase.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $connection = (string) config('database.default', 'mysql');
        $database = (string) config("database.connections.{$connection}.database", '');

        if (app()->environment('testing') && $database === 'eliyaa_local') {
            $this->fail(
                'اختبارات PHPUnit مضبوطة على eliyaa_local — هذا يمسح بياناتك المحلية. '
                . 'يجب استخدام eliyaa_testing (راجع docs/LOCAL_DATABASE_SAFETY.md).'
            );
        }
    }
}
