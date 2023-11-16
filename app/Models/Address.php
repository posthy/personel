<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    const ADDRESS_TYPE_PERMANENT = "permanent";
    const ADDRESS_TYPE_TEMPORARY = "temporary";

    protected $fillable = [
        'person_id',
        'address_type', 
        'country',
        'city',
        'street',
        'number',
        'zip'
    ];

    public static function getAddressTypes()
    {
        return [
            self::ADDRESS_TYPE_PERMANENT,
            self::ADDRESS_TYPE_TEMPORARY
        ];
    }
}
