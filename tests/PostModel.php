<?php

namespace Zqhong\FastdEloquent\Test;

use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    public $timestamps = false;
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'author',
        'title',
        'content',
        'created_at',
        'updated_at',
    ];
}