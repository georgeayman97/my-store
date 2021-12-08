<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const STATUS_ACTIVE = 'active';
    const STATUS_DRAFT = 'draft';
    
    use HasFactory;

    protected $fillable = [
        'name','slug','description','category_id','image_path','price','sale_price',
        'quantity','weight','width','height','length','status'
    ];

    protected $perPage = 20;

    public static function validateRules()
    {
        return [
            'name' => 'required|max:255',
            'category_id' => 'required|int|exists:categories,id',
            'description' => 'nullable',
            'image' => 'nullable|image|dimensions:min_width:300,min_height:300',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|int|min:0',
            'sku' => 'nullable|unique:products,sku',
            'weight' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'status' => 'in:' . self::STATUS_ACTIVE . ',' . self::STATUS_DRAFT,
        ];
    }
}
