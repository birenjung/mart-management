<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    protected $primaryKey = 'cart_id';

    protected $fillable = ['cart_items'];

    protected $attributes = [
        'cart_items' => '{
            "user_id": "",
            "products": {
                "1": {
                    "product_id": "",
                    "quantity": 1
                }
            }
        }'
    ];
    

   protected $casts = [
        'cart_items' => 'array'
   ];
}
