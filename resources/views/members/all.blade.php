@extends('layouts.app')
@section('content')
<div class="container mt-3">
	<div class="row">
		<div class="col">
			<h3>Members</h3>
		</div>
	</div>
</div>
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
      <ul class="nav justify-content-end">
        <li class="nav-item">
          <a class="nav-link" href data-toggle="modal" data-target="#upload_modal">Upload CSV</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('admin/members/export_not_printed') }}">Export Not Printed</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('admin/members/export_all') }}">Export All</a>
        </li>
      </ul>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="upload_modal" tabindex="-1" role="dialog" aria-labelledby="upload_modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload CSV</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form enctype="multipart/form-data" method="POST" action="{{ url('/admin/members/import_list') }}">
      	{{ csrf_field() }}
	      <div class="modal-body">
	      	<p>
	      		Please ensure your CSV file matches the column order below:
	      	</p>
	      	<div class="row mb-3">
	      		<div class="col font-weight-bold text-center">First Name</div>
	      		<div class="col font-weight-bold text-center">Last Name</div>
	      		<div class="col font-weight-bold text-center">Barcode</div>
	      		<div class="col font-weight-bold text-center">Optional 1</div>
	      		<div class="col font-weight-bold text-center">Optional 2</div>
	      		<div class="col font-weight-bold text-center">Optional 3</div>
	      		<div class="col font-weight-bold text-center">Optional 4</div>
	      	</div>
	        <input type="file" name="list"/><br><br>
	        <input type="checkbox" name="file_headers" value="1" checked/> This file contains a header row at the top.
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary">Upload</button>
	      </div>
	    </form>
    </div>
  </div>
</div>

<div class="container mt-2">
  @foreach ($members as $member)
    <div class="row mb-1">
      <div class="col">
        <div class="card">
          <div class="card-body pt-1 pb-1 pl-1 pr-1">
            <div class="col-sm-12">
              <div class="row">
                <div class="col-4 text-left font-weight-bold">
                  <a href="{{ url('admin/members/view/'.$member->id) }}">{{ $member->first_name }} {{ $member->last_name }}</a>
                </div>
                <div class="col-3 text-left">
                  {{ $member->barcode_id }}
                </div>
                <div class="col-2 text-right">
                  @if($member->printed == 0)
                  	<span class="badge badge-warning">Not Printed</span>
                  @else
                  	<span class="badge badge-success">Printed</span>
                  @endif
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