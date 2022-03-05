<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    const STATUS_ACTIVE = 'active';
    const STATUS_DRAFT = 'draft';
    
    use SoftDeletes;
    use HasFactory;

    // to initialize global scope
    public static function booted()
    {
        static::addGlobalScope('active', function(Builder $builder){
            $builder->where('products.status','=','active');
        });
    }

    protected $fillable = [
        'name','slug','description','category_id','image_path','price','sale_price',
        'quantity','weight','width','height','length','status'
    ];

    protected $perPage = 10;

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

    // Accessor get image_url
    public function getImageUrlAttribute()
    {
        if(!$this->image_path){
            return asset('images/placeholder.png');
        }
        // if the image is link 
        if(stripos($this->image_path, 'http') === 0){
            return $this->image_path;
        }

        return asset('uploads/' . $this->image_path);
    }

    // Mutators: set{AttributeName}Attribute
    public function setNameAttribute($value)
    {
        // to convert first char in names to capital letter
        //$this->attributes['name'] = Str::studly($value); //without spaces

        $this->attributes['name'] = Str::title($value);  //with spaces

        // initialize the slug column from here
        $this->attributes['slug'] = Str::slug($value);
    }
}
