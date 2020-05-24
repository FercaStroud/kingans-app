<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

Class News extends Model
{
    use SoftDeletes;
    protected $table = 'news';
    public $timestamps = true;
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $fillable = [
        'branch_id',
        'title',
        'src',
    ];
    protected $primaryKey = 'id';
}