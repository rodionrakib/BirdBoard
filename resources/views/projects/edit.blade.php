@extends('layout')
@section('content')
 <section id="get-started" class="padd-section text-center wow fadeInUp">

    <div class="container">
      <div class="section-title text-center">

         <h1> Edit Project </h1>
      </div>
    </div>

	<div class="container">
		@if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif
		<form method="POST" action={{$project->path()}}>
			@csrf
			@method('PATCH')
  		<div class="form-group">
    		<label for="title">Project Title</label>
    		<input type="text"  name="title"  value="{{ $project->title }}" class="form-control" id="title" placeholder="Project Title">
  		</div>

  		<div class="form-group">
    		<label for="description">Description</label>
    		<textarea class="form-control" name="description" id="description" rows="5">{{$project->description}}</textarea>
  		</div>

  		<div class="form-group">
    		<label for="description"> Notes</label>
    		<textarea class="form-control" name="notes" id="description" rows="5">{{$project->notes}}</textarea>
  		</div>
   			<button type="submit" class="btn btn-primary">Update</button>
		</form>
	</div>
</section>
@endsection
