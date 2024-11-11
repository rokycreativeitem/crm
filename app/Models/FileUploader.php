<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FileUploader extends Model
{
    use HasFactory;
    public static function upload($file, $path = null)
    {
        if ($file) {
            $file_name = Str::random(20) . '.' . $file->extension();
            $path      = 'uploads/' . $path;
            $file->move('public/' . $path, $file_name);
            return "{$path}/{$file_name}";
        }
    }
}
