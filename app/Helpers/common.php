<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

if (!function_exists('toTitleCase')) {
    function toTitleCase(string $case)
    {
        return ucwords(str_replace('_', ' ', mb_strtolower($case)));
    }
}

if (!function_exists('format_date')) {
    function format_date($date, $format = 'Y-m-d H:i:s')
    {
        return \Carbon\Carbon::parse($date)->format($format);
    }
}

if (!function_exists('encrypt')) {
    function encrypt(mixed $value)
    {
        return Crypt::encrypt($value);
    }
}

if (!function_exists('decrypt')) {
    function decrypt(mixed $value)
    {
        return Crypt::decrypt($value);
    }
}

if (!function_exists('convertToBase64')) {
    function convertToBase64(string $image)
    {
        return 'data:image/png;base64,' . base64_encode($image);
    }
}

if (!function_exists('generateCode')) {
    function generateCode(Model $model, $prefix = null)
    {
        // Get the current date in the format 'YmdHis' (YearMonthDayHourMinuteSecond)
        $datePart = now()->format('YmdHis');

        // Get the total count of data for the current date
        $modelCount = $model->count() + 1;

        // Determine the number of digits needed for the order count
        $numberOfDigits = max(3, intval(log10($modelCount)) + 1);

        // Format the order count with leading zeros
        $formattedCount = str_pad((string) $modelCount, $numberOfDigits, '0', STR_PAD_LEFT);

        // Use provided prefix or model prefix
        $prefix = $prefix ?: $model->prefix;

        // Assemble the new order number
        $newNumber = "{$prefix}{$datePart}{$formattedCount}";

        return $newNumber;
    }
}


if (!function_exists('cleanJsonString')) {
    function cleanJsonString(string $jsonString)
    {
        // Remove surrounding triple backticks
        $jsonString = trim($jsonString, " \t\n\r\0\x0B`");

        // Remove "json" keyword
        $jsonString = str_ireplace('json', '', $jsonString);

        return $jsonString;
    }
}

if (!function_exists('extractDomain')) {
    function extractDomain(string $link)
    {
        $url = str_replace(['www.', 'https://', 'http://', ' '], [''], $link);
        $url = explode('/', $url)[0] ?? null;

        return $url;
    }
}

if (!function_exists('checkPermissions')) {
    function checkPermissions(string $permissions)
    {
        $userId = Auth::user()->id;

        $control = User::where('id', $userId)
            ->whereHas('roles.permissions', function ($q) use ($permissions) {
                $q->whereIn('name', $permissions);
            })->first();

        return $control ? true : false;
    }
}


