@extends('layout')
@section('content')
 <section id="get-started" class="padd-section text-center wow fadeInUp">

    <div class="container">
      <div class="section-title text-center">

        <h2>simple systeme fordiscount </h2>
        <p class="separator">Integer cursus bibendum augue ac cursus .</p>
        <a href="{{route('project-create')}}" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Add Project</a>
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
		<form method="POST" action={{ route('project-save') }}>
			@csrf
  		<div class="form-group">
    		<label for="title">Project Title</label>
    		<input type="text"  name="title" class="form-control" id="title" placeholder="Project Title">
  		</div>

  		<div class="form-group">
    		<label for="description">Example textarea</label>
    		<textarea class="form-control" name="description" id="description" rows="5"></textarea>
  		</div>
   			<button type="submit" class="btn btn-primary">Create</button>
		</form>
	</div>
</section>
@endsection
