@extends('layout')
@section('content')
  <section id="get-started" class="padd-section text-center wow fadeInUp">

    <div class="container">
      <div class="section-title text-center">
        <h2>{{$project->title}}</h2>
        <p class="separator">{{$project->description}}</p>
      </div>
    </div>

    <div class="container">
      <div class="row">
      	<div class="col-lg-12">
      		@if ($errors->any())
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif
      		<form method="POST" action="{{route('task-store',$project->id)}}" >
      			@csrf
      			 <div class="form-group">
				    <label for="title">Task Body</label>
				    <input type="text" class="form-control" name="title" id="title" placeholder="Task ">
				  </div>	
			  <button type="submit" class="btn btn-primary">Add Task</button>
			</form>
      		<h1>Bootstrap To-Do App</h1>

			@foreach($project->tasks as $task)
				<form method="POST" action="{{$project->path()}}/tasks/{{$task->id}}" >
					@csrf
					@method('PATCH')
				<div class="form-group">
					<input type="text" name="title" value="{{$task->title}}">
					<input type="checkbox" name="completed" value="{{$task->completed}}"
					{{ $task->completed ? 'checked': ''}}
					 onchange="this.form.submit()">
					
					

				</div>
				</form>
			@endforeach

			<form method="POST" action="{{$project->path()}}">
				@csrf;
				@method('PATCH')
				<div class="form-group">
				  <label for="notes">Notes:</label>
				  <textarea class="form-control" rows="5"  name="notes" id="notes">{{ $project->notes }}</textarea>
				</div>
				<button type="submit">Save</button>
			</form>

      	</div>			
         	
      </div>
    </div>

  </section>
@endsection
