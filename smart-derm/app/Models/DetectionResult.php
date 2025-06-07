<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetectionResult extends Model
{
        protected $fillable = [
        'user_id',
        'name',
        'age',
        'gender',
        'predicted_class',
        'confidence',
        'recommendation',
        'image_path',
    ];

}
