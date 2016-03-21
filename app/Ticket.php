<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    const STATUS_NONE = 1;
    const STATUS_READY = 2;
    const STATUS_INPROGRESS = 3;
    const STATUS_REVISION = 4;
    const STATUS_DONE = 5;
    const STATUSES = [1 => 'Waiting', 2 => 'Ready', 3 => 'In Progress', 4 => 'Revision', 5 => 'Done'];

    const CATEGORY_DESIGN = 1;
    const CATEGORY_BUG = 2;
    const CATEGORY_FUNCTIONALITY = 3;
    const CATEGORY_PROJET_MANAGEMENT = 4;
    const CATEGORY_DEPLOY = 5;
    const CATEGORIES = [1 => 'Design', 2 => 'Bug', 3 => 'Functionality', 4 => 'Project Management', 5 => 'Deployment'];

    const PRIORITY_LOW = 1;
    const PRIORITY_MID = 2;
    const PRIORITY_HIGH = 3;
    const PRIORITIES = [1 => 'Low', 2 => 'High', 3 => 'Urgent'];

    const ESTIMATE_S = 1;
    const ESTIMATE_M = 2;
    const ESTIMATE_L = 3;
    const ESTIMATE_XL = 4;
    const ESTIMATES = [1 => 'S', 2 => 'M', 3 => 'L', 4 => 'XL'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'category', 'status', 'priority', 'date_start', 'date_end', 'estimate', 'user_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function getStatus(){
        $status = Ticket::STATUSES[$this->status];
        return (!isset($status) || is_null($status)) ? 'Unknown' : $status;
    }

    public function getCategory(){
        $category = Ticket::CATEGORIES[$this->category];
        return (!isset($category) || is_null($category)) ? 'Unknown' : $category;
    }

    public function getPriority(){
        $priority = Ticket::PRIORITIES[$this->priority];
        return (!isset($priority) || is_null($priority)) ? 'Unknown' : $priority;
    }

    public function getEstimate(){
        $estimate = Ticket::ESTIMATES[$this->estimate];
        return (!isset($estimate) || is_null($estimate)) ? 'Unknown' : $estimate;
    }
}
