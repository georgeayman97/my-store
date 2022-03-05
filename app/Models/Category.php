<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    use SoftDeletes;

    //those const are used while using timestamps 
    //or any column like this 
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    // those are defaults values we dont need to rewrite them 
    // but if we want new values we can write them here again
    protected $connection = 'mysql';
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    // if we want to use timestamps in our table or not
    public $timestamps = true;

    // Mass Assignment proberty
    protected $fillable = [
        'name','parent_id','slug','status','description'
    ];

    //Accessors: get{AttributeName}Attribute
    //Exists Attribute 
    // $model->name
    public function getNameAttribute($value)
    {
        if($this->trashed()){
            return $value . ' (Deleted) ';
        }
        return $value;
    }

    //Non Exists Attribute 
    // $model->original_name
    public function getOriginalNameAttribute()
    {
        //find attribute with key 'name'
        return $this->attributes['name'];
    }

}
