<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'description',
        'name',
        'image',
        'volume',
        'old_price',
        'current_price',
        'category_id',
        'parent_id',
        'quantity',
        'ingredients',
         'specifications',
         'features'

    ];
    protected $casts = [
        'ingredients' => 'array',
        'specifications' => 'array',
        'features' => 'array',
    ];

    //Relation
    public function category()
    {
        return $this->beLongsTo(Category::class);
    }

   
    //-------------------------------
        // العلاقة للحصول على البدائل لعطر معين

        public function parent(){
            return $this->beLongsTo(Product::class,'parent_id');
        }

        public function alternatives()
        {
            return $this->hasMany(Product::class,'parent_id');
        }
        //Relation orderItem
        public function orderItems()
        {
            return $this->hasMany(OrderItem::class);
        }

        //comment
        public function comments()
        {
            return $this->morphMany(Comment::class,'commentable');
        }


}
