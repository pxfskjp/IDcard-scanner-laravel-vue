@extends('layouts.app')
@section('content')
<div class="container mt-3">
	<div class="row">
		<div class="col">
			<h3>Events - {{ $event->name }}</h3>
		</div>
	</div>
</div>
<div class="container mt-3">
  <div class="row">
    <div class="col">
      <ul class="nav justify-content-end">
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/admin/events/edit/' . $event->id) }}">Edit Event</a>
        </li>
      </ul>
    </div>
  </div>
</div>
<div class="container mt-2">
	<div class="row">
		<div class="col">
			<dl class="row">
			  <dt class="col-sm-3">Name</dt>
			  <dd class="col-sm-9">{{ $event->name }}</dd>
			  <dt class="col-sm-3">Date</dt>
			  <dd class="col-sm-9">{{ $event->date }}</dd>
			  <dt class="col-sm-3">Description</dt>
			  <dd class="col-sm-9">{{ $event->description }}</dd>
			</dl>
		</div>
	</div>
</div>
<div class="container mt-2">
	<h4>Members Scanned</h4>
  @foreach ($scans as $scan)
    <div class="row mb-1">
      <div class="col">
        <div class="card">
          <div class="card-body pt-1 pb-1 pl-1 pr-1">
            <div class="col-sm-12">
              <div class="row">
                <div class="col-6 text-left font-weight-bold">
                  {{ $scan->first_name }} {{ $scan->last_name }}
                </div>
                <div class="col-6 text-right">
									{{ $scan->date }} {{ $scan->time }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>
@endsection