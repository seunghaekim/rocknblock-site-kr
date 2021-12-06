<?php namespace amaryfilo\Feedback\Models;

use Model;

/**
 * Feedback Model
 */
class Feedback extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'amaryfilo_feedback_feedback';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [
        'inputs' => [
          'amaryfilo\Feedback\Models\Input',
          'table' => 'amaryfilo_feedback_key',
          'order' => 'id'
        ],
        'mails' => [
          'amaryfilo\Feedback\Models\Send',
          'table' => 'amaryfilo_send_key',
          'order' => 'id'
        ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
