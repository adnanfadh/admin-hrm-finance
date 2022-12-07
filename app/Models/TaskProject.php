<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskProject extends Model
{
    use HasFactory;

    protected $table = 'task_projects';
    protected $fillable = [
        'project_id',
        'task',
        'status_task'
    ];

    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }
}
