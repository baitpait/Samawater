<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Client;
use App\Models\ClientType;
use App\Models\SubscriptionStatus;
use App\Models\SubscriptionType;
use Carbon\Carbon;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * استيراد مشتركين من شيت "الاشتراك" في ملف Excel (سما عام.xlsx).
 * يدخل فقط الصفوف الكاملة؛ الصفوف الناقصة يُبلّغ عن أرقامها فقط.
 */
class ImportSamaExcel extends Command
{
    protected $signature = 'sama:import-excel {file? : مسار ملف Excel (افتراضي: سما عام.xlsx في جذر المشروع)}';

    protected $description = 'استيراد المشتركين من شيت الاشتراك في Excel — الصفوف الناقصة تُتخطى ويُبلّغ عن أرقامها';

    private const HEADER_ROW = 3;

    private const NAME_HEADERS = ['اسم المشترك', 'العنواون', 'العنوان'];

    private const SUBSCRIPTION_HEADERS = ['الاشتراك'];

    private const BOTTLE_HEADERS = ['مجموع العبوات', 'كولر مجلى'];

    private const REQUIRED_FOR_COMPLETE = ['name'];

    public function handle(): int
    {
        $file = $this->argument('file') ?: base_path('سما عام.xlsx');
        if (! is_readable($file)) {
            $this->error('الملف غير موجود أو غير مقروء: ' . $file);
            return self::FAILURE;
        }

        $this->info('جاري فتح الملف: ' . $file);
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getSheetByName('الاشتراك') ?? $spreadsheet->getSheet(1);
        $highestRow = $sheet->getHighestRow();
        $highestCol = $sheet->getHighestDataColumn();

        $colMap = $this->buildColumnMap($sheet);
        if (empty($colMap['name'])) {
            $this->error('لم يُعثر على عمود "اسم المشترك" في صف الهيدر.');
            return self::FAILURE;
        }

        $this->ensureLookups();
        $imported = 0;
        $skipped = [];

        for ($row = self::HEADER_ROW + 1; $row <= $highestRow; $row++) {
            $name = $this->getCellValue($sheet, $row, $colMap['name']);
            $name = is_scalar($name) ? trim((string) $name) : '';
            if ($name === '') {
                $skipped[] = $row;
                continue;
            }

            $address = $this->getCellValue($sheet, $row, $colMap['address'] ?? null);
            $address = $address !== null && is_scalar($address) ? trim((string) $address) : '';

            $notesParts = [];
            $toolsVal = $this->getCellValue($sheet, $row, $colMap['tools'] ?? null);
            if ($toolsVal !== null && is_scalar($toolsVal) && trim((string) $toolsVal) !== '') {
                $notesParts[] = 'الادوات: ' . trim((string) $toolsVal);
            }
            $noteVal = $this->getCellValue($sheet, $row, $colMap['note'] ?? null);
            if ($noteVal !== null && is_scalar($noteVal) && trim((string) $noteVal) !== '') {
                $notesParts[] = 'ملاحظة: ' . trim((string) $noteVal);
            }
            $matalobVal = $this->getCellValue($sheet, $row, $colMap['matalob'] ?? null);
            if ($matalobVal !== null && is_scalar($matalobVal) && trim((string) $matalobVal) !== '') {
                $notesParts[] = 'مطلوب ش: ' . trim((string) $matalobVal);
            }
            $notes = implode(' | ', $notesParts);

            $phoneOne = $this->getCellValue($sheet, $row, $colMap['phone_one'] ?? null);
            $phoneOne = $phoneOne !== null && is_scalar($phoneOne) ? trim((string) $phoneOne) : null;
            $phoneTwo = $this->getCellValue($sheet, $row, $colMap['phone_two'] ?? null);
            $phoneTwo = $phoneTwo !== null && is_scalar($phoneTwo) ? trim((string) $phoneTwo) : null;

            $bottleBalance = 0;
            if (! empty($colMap['bottle_balance'])) {
                $v = $this->getCellValue($sheet, $row, $colMap['bottle_balance']);
                if (is_numeric($v)) {
                    $bottleBalance = (int) $v;
                }
            }

            $cityId = null;
            $cityName = $this->getCellValue($sheet, $row, $colMap['city'] ?? null);
            $cityName = $cityName !== null && is_scalar($cityName) ? trim((string) $cityName) : '';
            if ($cityName !== '') {
                $city = City::firstOrCreate(['city_name' => $cityName]);
                $cityId = $city->id;
            }

            $subscriptionTypeId = $this->resolveSubscriptionType($sheet, $row, $colMap);
            $subscriptionStatusId = SubscriptionStatus::where('status_name', 'نشط')->value('id');
            if (! $subscriptionStatusId) {
                $this->warn('حالة "نشط" غير موجودة في subscription_statuses.');
                $skipped[] = $row;
                continue;
            }

            try {
                Client::create([
                    'name' => $name,
                    'address' => $address ?: null,
                    'phone_one' => $phoneOne ?: null,
                    'phone_two' => $phoneTwo ?: null,
                    'notes' => $notes ?: null,
                    'bottle_balance' => $bottleBalance,
                    'client_type' => 'فردي',
                    'city_id' => $cityId,
                    'subscription_type_id' => $subscriptionTypeId,
                    'subscription_status_id' => $subscriptionStatusId,
                    'subscription_start_date' => Carbon::today(),
                ]);
                $imported++;
            } catch (\Throwable $e) {
                $this->warn("صف {$row}: " . $e->getMessage());
                $skipped[] = $row;
            }
        }

        $this->newLine();
        $this->info("تم استيراد {$imported} مشتركاً.");
        if (count($skipped) > 0) {
            $this->warn('الصفوف الناقصة أو التي تُركت دون استيراد: ' . implode(', ', $skipped));
        }

        return self::SUCCESS;
    }

    private function buildColumnMap(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet): array
    {
        $map = [];
        $col = 1;
        $maxCol = 30;
        while ($col <= $maxCol) {
            $val = $this->getCellValue($sheet, self::HEADER_ROW, $col);
            $header = is_scalar($val) ? trim((string) $val) : '';
            if ($header !== '') {
                if (in_array($header, self::NAME_HEADERS, true)) {
                    $map['name'] = $col;
                }
                if ($header === 'العنوان' || $header === 'العنواون') {
                    $map['address'] = $col;
                }
                if ($header === 'الادوات') {
                    $map['tools'] = $col;
                }
                if (in_array($header, self::SUBSCRIPTION_HEADERS, true)) {
                    $map['subscription'] = $col;
                }
                if ($header === 'هاتف') {
                    $map['phone_one'] = $col;
                }
                if ($header === 'هاتف3') {
                    $map['phone_two'] = $col;
                }
                if ($header === 'ملاحظة') {
                    $map['note'] = $col;
                }
                if ($header === 'مطلوب ش') {
                    $map['matalob'] = $col;
                }
                if (in_array($header, self::BOTTLE_HEADERS, true) || str_contains($header, 'مجموع العبوات')) {
                    $map['bottle_balance'] = $col;
                }
                if ($header === 'المدينة' || $header === 'مدينة' || str_contains($header, 'المدينة')) {
                    $map['city'] = $col;
                }
            }
            $col++;
        }
        if (! isset($map['city'])) {
            $map['city'] = 7;
        }
        if (empty($map['address'])) {
            $map['address'] = $map['name'] ?? null;
        }
        return $map;
    }

    private function getCellValue(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet, int $row, ?int $col): mixed
    {
        if ($col === null || $col < 1) {
            return null;
        }
        $coord = $this->columnLetterFromIndex($col) . $row;
        return $sheet->getCell($coord)->getValue();
    }

    private function columnLetterFromIndex(int $col): string
    {
        $letter = '';
        while ($col > 0) {
            $col--;
            $letter = chr(65 + ($col % 26)) . $letter;
            $col = (int) floor($col / 26);
        }
        return $letter;
    }

    private function resolveSubscriptionType(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet, int $row, array $colMap): ?int
    {
        if (empty($colMap['subscription'])) {
            return SubscriptionType::where('type_name', 'غير محدود')->value('id');
        }
        $val = $this->getCellValue($sheet, $row, $colMap['subscription']);
        $val = is_scalar($val) ? trim((string) $val) : '';
        if ($val === 'محدود') {
            return SubscriptionType::where('type_name', 'محدود')->value('id');
        }
        if ($val === 'غير محدود') {
            return SubscriptionType::where('type_name', 'غير محدود')->value('id');
        }
        return SubscriptionType::where('type_name', 'غير محدود')->value('id');
    }

    private function ensureLookups(): void
    {
        ClientType::firstOrCreate(['type_name' => 'فردي']);
        SubscriptionType::firstOrCreate(
            ['type_name' => 'محدود'],
            ['distribution_days' => 30]
        );
        SubscriptionType::firstOrCreate(
            ['type_name' => 'غير محدود'],
            ['distribution_days' => 0]
        );
        if (SubscriptionStatus::where('status_name', 'نشط')->doesntExist()) {
            SubscriptionStatus::create(['status_name' => 'نشط']);
        }
    }
}
