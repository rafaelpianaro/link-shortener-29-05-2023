<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shortener extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    public function remove_access_details($shortener_identifier): void
    {
        $this->detach($shortener_identifier);
    }
}
