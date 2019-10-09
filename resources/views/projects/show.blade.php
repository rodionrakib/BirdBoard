@extends ('layouts.app')

@section('content')
    <header class="flex items-center mb-3 pb-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-grey text-sm font-normal">
                <a href="/projects" class="text-grey text-sm font-normal no-underline hover:underline">My Projects</a>
                / {{ $project->title }}
            </p>


        </div>
        <div class="flex items-center">
            @foreach($project->members as $member)
                <img
                        src="https://www.gravatar.com/avatar/{{md5($member->email)}}?s=60"
                        alt="{{$member->name}}'s Profile"
                        class="rounded-full">
            @endforeach
            <img
                        src="https://www.gravatar.com/avatar/{{md5('sovon.kucse@gmail.com')}}?s=60"
                        alt="Owners
                         Profile"
                        class="rounded-full">


            <a href="{{ $project->path() . '/edit' }}" class="button">Edit Project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-lg text-grey font-normal mb-3">Tasks</h2>

                    {{-- tasks --}}
                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">
                            <form method="POST" action="{{ $task->path() }}">
                                @method('PATCH')
                                @csrf

                                <div class="flex">
                                    <input name="title" value="{{ $task->title }}" class="w-full {{ $task->completed ? 'text-grey' : '' }}">
                                    <input name="completed" type="checkbox" onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                </div>
                            </form>
                        </div>
                    @endforeach

                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="POST">
                            @csrf

                            <input placeholder="Add a new task..." class="w-full" name="title">
                        </form>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>

                    {{-- general notes --}}
                    <form method="POST" action="{{ $project->path() }}">
                        @csrf
                        @method('PATCH')

                        <textarea
                            name="notes"
                            class="card w-full mb-4"
                            style="min-height: 200px"
                            placeholder="Anything special that you want to make a note of?"
                        >{{ $project->notes }}</textarea>

                        <button type="submit" class="button">Save</button>
                    </form>

                    @if ($errors->any())
                        <div class="field mt-6">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm text-red">{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                    
                </div>
            </div>

            <div class="lg:w-1/4 px-3 lg:py-8">
                @include ('projects.card')
                <div class="card" style="height: 200px">
                <ul>
                @foreach($activities as $activity)
                   

                    @if($activity->description === 'project_created')   
                    <li> You Created  Project {{ $activity->activityable->title }} </li>

                    @elseif($activity->description === 'project_updated')   
                    <li> You Updated Project  {{ $activity->activityable->title }}</li>

                     
                    @elseif($activity->description === 'task_created')   
                    <li> You Created  Task {{ $activity->activityable->title }} </li>

                    @elseif($activity->description === 'task_completed')   
                    <li> You Completed Task  {{ $activity->activityable->title }}</li>

                    @elseif($activity->description === 'task_incompleted')   
                    <li> You Incompleted Task  {{ $activity->activityable->title }}</li>

                    @endif
                   
                 @endforeach
                </ul>
                </div>
                @if(auth()->user()->can('manage',$project))
                <form method="POST" action="{{$project->path()}}/invitation">

                    @csrf
                    <input  class="w-full border border-grey rounded" type="email" 
                    name="email" placeholder="Email address " 
                    >
                    <button type="submit" class="button ">Invite</button>
                </form>
                @endif
                @if($errors->invitation->any())
                <div class="field mt-6">
                    
                
                    @foreach($errors->invitation->all() as $error)
                    <li class="text-sm text-red"> {{$error}} </li>
                    @endforeach
                </div>
                @endif
            </div>
             
        </div>
    </main>


@endsection
