<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $primaryKey = 'key';
    public $incrementing = false;

    protected $fillable = [
        'key',
        'value',
        'serialize',
    ];

    public static function getValue($key, $default = null)
    {
        $value_data = Setting::find($key);
        if (!$value_data) {
            return $default;
        }

        if ($value_data->serialize) {
            try {
                return unserialize($value_data->value);
            } catch (\Throwable $e) {
                return $value_data->value;
            }
        }

        return $value_data->value ?? $default;
    }

    public static function getAllSettings(): array
    {
        $settings = Setting::all();
        $result = [];
        foreach ($settings as $setting) {
            $result[$setting->key] = self::getValue($setting->key);
        }
        return $result;
    }

    public static function setValue($value)
    {
        $fileKeys = ['favicon', 'logo', 'og_image'];

        foreach ($value as $key => $val) {
            if (in_array($key, $fileKeys, true)) {
                if ($val instanceof \Illuminate\Http\UploadedFile) {
                    $value_data = Setting::firstOrNew(['key' => $key]);
                    $path = $val->store('settings', 'public');
                    $value_data->value = asset('storage/' . $path);
                    $value_data->serialize = 0;
                    $value_data->save();
                }
                continue;
            }

            $value_data = Setting::firstOrNew(['key' => $key]);
            if ($value_data->serialize) {
                $value_data->value = serialize($val);
            } else {
                $value_data->value = is_array($val) ? implode(',', $val) : $val;
            }
            $value_data->save();
        }
    }
}
