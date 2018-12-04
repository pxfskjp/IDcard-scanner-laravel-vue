@extends('layouts.app')
@section('content')
<div class="container mt-3">
	<div class="row">
		<div class="col">
			<h3>Events</h3>
		</div>
	</div>
</div>
<div class="container mt-3">
  <div class="row">
    <div class="col">
      <ul class="nav justify-content-end">
        <li class="nav-item">
          <a class="nav-link" href="{{ url('admin/events/new') }}">Add New Event</a>
        </li>
      </ul>
    </div>
  </div>
</div>
<div class="container mt-2">
  @foreach ($events as $event)
    <div class="row mb-1">
      <div class="col">
        <div class="card">
          <div class="card-body pt-1 pb-1 pl-1 pr-1">
            <div class="col-sm-12">
              <div class="row">
                <div class="col-6 text-left font-weight-bold">
                  <a href="{{ url('admin/events/view/'.$event->id) }}">{{ $event->name }}</a>
                </div>
                <div class="col-6 text-right">
                  {{ $event->date }}
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