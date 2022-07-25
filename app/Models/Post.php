<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use HasFactory;
    use Sluggable;
    use \Conner\Tagging\Taggable;

    protected $guarded=[];
    // protected $fillable = ['tags','slug','title','description','thumbnail','editor'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function photo(){
        return $this->hasMany(Photo::class)->orderBy('created_at','DESC');
    }
}
