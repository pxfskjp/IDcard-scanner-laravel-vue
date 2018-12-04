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
      <form role="form" method="POST" action="{{ url('admin/members/edit/'.$member->id) }}">
        {{ csrf_field() }}
        <div class="form-group row">
          <div class="col-md-4">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control form-control-sm {{ $errors->has('first_name') ? ' is-invalid' : '' }}" id="first_name" name="first_name" value="{{ null !== old('first_name') ? old('first_name') : $member->first_name }}">
          </div>
          <div class="col-md-4">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control form-control-sm {{ $errors->has('last_name') ? ' is-invalid' : '' }}" id="last_name" name="last_name" value="{{ null !== old('last_name') ? old('last_name') : $member->last_name }}">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-4">
            <label for="optional_1">Optional 1</label>
            <input type="text" class="form-control form-control-sm {{ $errors->has('optional_1') ? ' is-invalid' : '' }}" id="optional_1" name="optional_1" value="{{ null !== old('optional_1') ? old('optional_1') : $member->optional_1 }}">
          </div>
          <div class="col-md-4">
            <label for="optional_2">Optional 2</label>
            <input type="text" class="form-control form-control-sm {{ $errors->has('optional_2') ? ' is-invalid' : '' }}" id="optional_2" name="optional_2" value="{{ null !== old('optional_2') ? old('optional_2') : $member->optional_2 }}">
          </div>
          <div class="col-md-4">
            <label for="optional_3">Optional 3</label>
            <input type="text" class="form-control form-control-sm {{ $errors->has('optional_3') ? ' is-invalid' : '' }}" id="optional_3" name="optional_3" value="{{ null !== old('optional_3') ? old('optional_3') : $member->optional_3 }}">
          </div>
          <div class="col-md-4">
            <label for="optional_4">Optional 4</label>
            <input type="text" class="form-control form-control-sm {{ $errors->has('optional_4') ? ' is-invalid' : '' }}" id="optional_4" name="optional_4" value="{{ null !== old('optional_4') ? old('optional_4') : $member->optional_4 }}">
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