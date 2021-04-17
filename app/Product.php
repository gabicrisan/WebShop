<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //seteaza ce coloane pot fi editate in tabelul products
    protected $fillable = [
        'name', 'description', 'image', 'price', 'type'
    ];

    //adauga $ la pret
    public function getPriceAttribute($value){
        $newform = "$".$value;
        return $newform;
    }
}
