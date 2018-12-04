@extends('layouts.app')

@section('content')
     
<div class="row mt-3">
  <div class="col">
    <h2>Password</h2>
    <form action="{{ url('/update_settings') }}" method="POST">
      {{ csrf_field() }}
      @include('templates.error')
      @if(isset($p)&&$p==0)
      <div class="alert alert-success">
          <p>Password changed</p>
      </div>
      @endif
      @if(isset($p)&&$p==1)
      <div class="alert alert-danger">
          <p>Sorry that password already exists</p>
      </div>
      @endif
      <div class="row">
        <div class="col-md-4">
          <input type="password" class="form-control" placeholder="Enter New Password" name="password"/>
        </div>
        <div class="col-md-4">
          <input type="password" class="form-control" placeholder="Confirm New Password" name="password_confirmation"/>
        </div>
        <div class="col-md-4">
          <input type="submit" class="btn btn-primary btn-block" value="Update">
        </div>
      </div>
      {{ method_field('PUT') }}
    </form>
  </div>
</div>
@endsection