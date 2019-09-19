<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Task;

class Project extends Model
{
    protected $guarded=[];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
    	return $this->hasMany(\App\Task::class);
    }

    public function addTask($arrtibutes)
    {
    	
    	$this->tasks()->create($arrtibutes);
    }

    public function path()
    {
        return '/projects/'.$this->id;
    }
}
