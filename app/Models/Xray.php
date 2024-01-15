<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xray extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'user_id',
        'rayphoto',

    ];
    protected $hidden = [
        'id',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function getRayphotoAttribute($value)
    {
        $actual_link = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
        return ($value == null ? '' : $actual_link . 'images/rays/' . $value);
    }
}
