<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessDetails extends Model
{
    use HasFactory;

    protected $primaryKey = 'shortener_identifier';
    public $incrementing = false;

    protected $fillable = [
        'ip',
        'user_agent',
        'shortener_identifier',

    ];

    public function shortener()
    {
        return $this->belongsTo(Shortener::class, 'shortener_identifier');
    }
}
