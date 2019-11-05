<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

Class Question extends Model
{
    use SoftDeletes;
    protected $table = 'questions';
    public $timestamps = true;
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $fillable = [
        'survey_id',
        'type',
        'title',
    ];
    protected $primaryKey = 'id';
}