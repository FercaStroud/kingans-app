<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

Class QuestionAnswer extends Model
{
    use SoftDeletes;
    protected $table = 'question_answer';
    public $timestamps = true;
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $fillable = [
        'answer_id',
        'question_id',
        'survey_id',
        'other',
    ];
    protected $primaryKey = 'id';
}