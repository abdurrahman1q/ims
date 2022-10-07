<?php

namespace App\Models;

use App\Http\Controllers\ProductController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $guarded = [];
    public function customer()
    {
        return $this->belongsTo('App\Models\customer');
    }

    public function product()
    {
        return $this->hasMany('App\Models\product');
    }

   

    
}
