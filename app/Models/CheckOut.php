<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckOut extends Model
{
    use HasFactory;
    protected $table = 'check_out';
    protected $primaryKey = 'check_out_id';

    protected $attributes = [
        'check_out' => '{
            "user_id": "",            
            "products": {
                "1": {
                    "product_id": "",
                    "quantity": 1,
                    "sold_at" : null
                }
            }           
        }'
    ];

    protected $casts = [
        'check_out' => 'array'
    ];
}
