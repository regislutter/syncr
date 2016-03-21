<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \DateTime;

class Ticket extends Model
{
    const STATUS_BACKLOG = 0;
    const STATUS_WAITING = 1;
    const STATUS_READY = 2;
    const STATUS_INPROGRESS = 3;
    const STATUS_REVISION = 4;
    const STATUS_DONE = 5;
    public static $STATUSES = [0 => 'Backlog', 1 => 'Waiting', 2 => 'Ready', 3 => 'In Progress', 4 => 'Revision', 5 => 'Done'];

    const CATEGORY_DESIGN = 1;
    const CATEGORY_BUG = 2;
    const CATEGORY_FUNCTIONALITY = 3;
    const CATEGORY_PROJET_MANAGEMENT = 4;
    const CATEGORY_DEPLOY = 5;
    public static $CATEGORIES = [1 => 'Design', 2 => 'Bug', 3 => 'Functionality', 4 => 'Project Management', 5 => 'Deployment'];

    const PRIORITY_LOW = 1;
    const PRIORITY_MID = 2;
    const PRIORITY_HIGH = 3;
    public static $PRIORITIES = [1 => 'Low', 2 => 'High', 3 => 'Urgent'];

    const ESTIMATE_S = 1;
    const ESTIMATE_M = 2;
    const ESTIMATE_L = 3;
    const ESTIMATE_XL = 4;
    public static $ESTIMATES = [1 => 'S', 2 => 'M', 3 => 'L', 4 => 'XL'];

    const DATE_FORMAT = 'd M Y';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'category', 'status', 'priority', 'date_start', 'date_end', 'estimate', 'user_id', 'project_id'];

    public function scopeUnassigned($query)
    {
        return $query->where('status', Ticket::STATUS_BACKLOG)->get();
    }

    public function scopeAssigned($query)
    {
        // Get tickets undone or done for less than 2 days
        return $query->whereIn('status', [Ticket::STATUS_WAITING, Ticket::STATUS_READY, Ticket::STATUS_INPROGRESS, Ticket::STATUS_REVISION])->orWhere(function($q){
            $date = new DateTime;
            $date->modify('-2 days');
            $formatted_date = $date->format('Y-m-d H:i:s');
            $q->where('status', Ticket::STATUS_DONE)->where('updated_at', '>', $formatted_date);
        })->get();
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function project(){
        return $this->belongsTo('App\Project');
    }

    public function getStatus(){
        $status = Ticket::$STATUSES[$this->status];
        return (!isset($status) || is_null($status)) ? 'Unknown' : $status;
    }

    public function getCategory(){
        $category = Ticket::$CATEGORIES[$this->category];
        return (!isset($category) || is_null($category)) ? 'Unknown' : $category;
    }

    public function getCategoryIconClass(){
        $iconClass = 'fi-link-broken';
        switch($this->category){
            case Ticket::CATEGORY_DESIGN:
                $iconClass = 'fi-brush';
                break;
            case Ticket::CATEGORY_BUG:
                $iconClass = 'fi-bug';
                break;
            case Ticket::CATEGORY_FUNCTIONALITY:
                $iconClass = 'fi-cogs';
                break;
            case Ticket::CATEGORY_PROJECT_MANAGEMENT:
                $iconClass = 'fi-project';
                break;
            case Ticket::CATEGORY_DEPLOY:
                $iconClass = 'fi-fork';
                break;
        }
        return $iconClass;
    }

    public function getPriorityColorClass(){
        switch($this->priority){
            case Ticket::PRIORITY_MID:
                return 'prio-middle';
                break;
            case Ticket::PRIORITY_HIGH:
                return 'prio-high';
                break;
            default:
                return 'prio-low';
                break;
        }
    }

    public function getPriority(){
        $priority = Ticket::$PRIORITIES[$this->priority];
        return (!isset($priority) || is_null($priority)) ? 'Unknown' : $priority;
    }

    public function getEstimate(){
        $estimate = Ticket::$ESTIMATES[$this->estimate];
        return (!isset($estimate) || is_null($estimate)) ? 'Unknown' : $estimate;
    }

    public function getDateStart(){
        if(!$this->date_start) {
            return '/';
        }
        return date(Ticket::DATE_FORMAT, strtotime($this->date_start));
    }

    public function getDateEnd(){
        if(!$this->date_end) {
            return '/';
        }
        return date(Ticket::DATE_FORMAT, strtotime($this->date_end));
    }
}
