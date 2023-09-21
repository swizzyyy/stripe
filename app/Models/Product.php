<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function tag()
    {
        return $this->hasOne(Tag::class,'id','tag_id');
    }
}
