<?php

namespace App\Observers;

use App\Task;
use App\Activity;

class TaskObserver
{
    /**
     * Handle the task "created" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        $this->createActivity($task,'task_created');
    }

    /**
     * Handle the task "updated" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function updated(Task $task)
    {
        
        
        if($task->completed == false) {$this->createActivity($task,'task_incompleted');}
        else{$this->createActivity($task,'task_completed');}

        

    }

    /**
     * Handle the task "deleted" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function deleted(Task $task)
    {
        //
    }

    /**
     * Handle the task "restored" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function restored(Task $task)
    {
        //
    }

    /**
     * Handle the task "force deleted" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function forceDeleted(Task $task)
    {
        //
    }

    public function createActivity($task,$type){

          Activity::create([
                'activityable_id' => $task->id,
                'activityable_type' => Task::class,
                'description' => $type,
                'project_id' => $task->project->id
            ]);
    }
}
