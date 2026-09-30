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

    public static function getValue($key)
    {
        $value_data = Setting::find($key);
        if (!$value_data) {
            return null;
        }

        if ($value_data->serialize) {
            try {
                return unserialize($value_data->value);
            } catch (\Throwable $e) {
                return $value_data->value;
            }
        }

        return $value_data->value;
    }

    public static function setValue($value)
    {
        $value_key = array_keys($value);
        foreach ($value_key as $key) {
            $value_data = Setting::firstOrNew(['key' => $key]);

            if ($key === "favicon") {
                if (isset($value['favicon']) && $value['favicon'] instanceof \Illuminate\Http\UploadedFile) {
                    $link_upload_image = $value['favicon']->store('favicon', 'public');
                    $value_data->value = asset('storage/' . $link_upload_image);
                    $value_data->serialize = 0;
                    $value_data->save();
                }
                continue;
            }

            if ($value_data->serialize) {
                $value_data->value = serialize($value[$key]);
            } else {
                $value_data->value = is_array($value[$key]) ? implode(',', $value[$key]) : $value[$key];
            }
            $value_data->save();
        }
    }
}
