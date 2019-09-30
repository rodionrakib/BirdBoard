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

    public function members()
    {
        return $this->belongsToMany(User::class,'project_member');
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

     public function activities()
    {
        return $this->morphMany('App\Activity', 'activityable');
    }

    public function getActivities()
    {
         return  Activity::where('project_id',$this->id)
                            ->orderBy('created_at','desc')
                            ->take(10)
                            ->get();
    }

    public function invite(User $user)
    {

        return $this->members()->attach($user);


    }


}
