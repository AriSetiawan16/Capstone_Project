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
        'description',
        'recommendation',
        'image_path',
    ];

}
