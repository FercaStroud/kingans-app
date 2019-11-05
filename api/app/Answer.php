<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

Class Answer extends Model
{
    use SoftDeletes;
    protected $table = 'answers';
    public $timestamps = true;
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $fillable = [
        'question_id',
        'title',
    ];
    protected $primaryKey = 'id';
}