<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group'
    ];

    /**
     * Get a setting by key with a fallback default value
     */
    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        if (!$setting) {
            return $default;
        }

        // Auto JSON decode if JSON string
        $val = $setting->value;
        if (is_string($val) && (str_starts_with($val, '{') || str_starts_with($val, '['))) {
            $decoded = json_decode($val, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }
        }

        return $val;
    }

    /**
     * Set / update a setting
     */
    public static function set(string $key, $value, string $group = 'general'): self
    {
        if (is_array($value) || is_object($value)) {
            $value = json_encode($value);
        }

        return static::updateOrCreate(
            ['key' => $key],
            ['value' => (string) $value, 'group' => $group]
        );
    }

    /**
     * Retrieve all settings as key => value array
     */
    public static function allKeyValues(): array
    {
        $settings = static::all();
        $res = [];
        foreach ($settings as $s) {
            $val = $s->value;
            if (is_string($val) && (str_starts_with($val, '{') || str_starts_with($val, '['))) {
                $decoded = json_decode($val, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $val = $decoded;
                }
            }
            $res[$s->key] = $val;
        }
        return $res;
    }
}
