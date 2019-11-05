<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

Class Survey extends Model
{
    use SoftDeletes;
    protected $table = 'surveys';
    public $timestamps = true;
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $fillable = [
        'name',
        'description',
    ];
    protected $primaryKey = 'id';
}