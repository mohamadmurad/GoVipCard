<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cards extends Model
{
    use HasFactory;

    protected $fillable =[
        'barcode',
        'balance',
        'name',

    ];


    public function withdraw(){
        return $this->hasMany(Withdrawal::class,'barcode','barcode')->orderBy('id','desc');
    }

    public function deposits(){
        return $this->hasMany(deposit::class,'barcode','barcode')->orderBy('id','desc');
    }
}
