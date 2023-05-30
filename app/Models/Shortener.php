<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shortener extends Model
{
    use HasFactory;

    protected $primaryKey = 'identifier';
    public $incrementing = false;
    public $identifier = 'string';

    protected $fillable = [
        'identifier',
        'title',
        'url'

    ];

    public function access_details()
    {
        return $this->hasMany(AccessDetails::class, 'shortener_identifier');
    }
}
