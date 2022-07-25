<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class device_verification extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'reg_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
