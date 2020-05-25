<?php

namespace App\Models\Observer\Job;

use App\Models\Job\Task;

use Illuminate\Http\Request;

use App\Models\Job\TaskHistory;

class TaskObserver
{
    /**
     * Handle the task "created" event.
     *
     * @param \App\Models\Job\Task $task
     * @return void
     */
    public function created(Task $task)
    {
        //
    }

    /**
     * Handle the task "updated" event.
     *
     * @param \App\Models\Job\Task $task
     * @return void
     */
    public function updated(Request $request, Task $task)
    {
        $changes = $task->isDirty() ? $task->getDirty() : false;

        echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($changes);echo '<PRE/>';exit;
        
        if ($changes && count($changes) > 0) {
            
            foreach ($changes as $attr => $value) {

                $taskHistory = new TaskHistory;

                $taskHistory->field_name = $attr;

                $taskHistory->original_value = $task->getOriginal($attr);

                $taskHistory->modified_value = $task->$attr;

                $taskHistory->user_id = auth()->user()->id;

                $taskHistory->ip = $request->ip();

                $taskHistory->save();



            }

        }

    }

    /**
     * Handle the task "deleted" event.
     *
     * @param \App\Models\Job\Task $task
     * @return void
     */
    public function deleted(Task $task)
    {
        //
    }

    /**
     * Handle the task "restored" event.
     *
     * @param \App\Models\Job\Task $task
     * @return void
     */
    public function restored(Task $task)
    {
        //
    }

    /**
     * Handle the task "force deleted" event.
     *
     * @param \App\Models\Job\Task $task
     * @return void
     */
    public function forceDeleted(Task $task)
    {
        //
    }
}
