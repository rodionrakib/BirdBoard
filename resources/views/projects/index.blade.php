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
      <div class="row">
       
        @foreach($projects as $project)
        <div class="col-md-6 col-lg-3">
          <div class="feature-block">

            <img src="/img/svg/cloud.svg" alt="img" class="img-fluid">
            <h4>{{$project->title}}</h4>
            <p>{{$project->description}}</p>      
          
            <a href="{{ $project->path() }}">read more</a>
            <a href="{{ $project->path() }}/edit">Edit Project </a>

          </div>
        </div>
        @endforeach
      </div>
    </div>

  </section>
@endsection