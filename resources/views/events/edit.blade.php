@extends('layouts.app')
@section('content')
@if ($errors->any())
<div class="container mt-3">
  <div class="row">
    <div class="col">
      <div class="alert alert-warning" role="alert">
        You have some errors. Please correct them before continuing.
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        <ul>
      </div>
    </div>
  </div>
</div>
@endif
<div class="container mt-3">
  <div class="row">
    <div class="col">
      <form role="form" method="POST" action="{{ url('admin/events/edit/'.$event->id) }}">
        {{ csrf_field() }}
        <div class="form-group row">
          <div class="col-md-6">
            <label for="name">Name</label>
            <input type="text" class="form-control form-control-sm {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{ null !== old('name') ? old('name') : $event->name }}">
          </div>
          <div class="col-md-6">
            <label for="date">Date</label>
            <input type="date" class="form-control form-control-sm {{ $errors->has('date') ? ' is-invalid' : '' }}" id="date" name="date" value="{{ null !== old('date') ? old('date') : $event->date }}">
          </div>
        </div>
        <div class="form-group row">
          <div class="col">
            <label for="description">Description</label>
            <textarea rows="5" class="form-control form-control-sm {{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" name="description">{{ null !== old('description') ? old('description') : $event->description }}</textarea>
          </div>
        </div>
        <div class="form-group row">
          <div class="col">
            <button class="btn btn-sm btn-primary">Update</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection