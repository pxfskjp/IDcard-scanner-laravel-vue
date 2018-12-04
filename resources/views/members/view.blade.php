@extends('layouts.app')
@section('content')
<div class="container mt-3">
	<div class="row">
		<div class="col">
			<h3>Members - {{ $member->first_name }} {{ $member->last_name }}</h3>
		</div>
	</div>
</div>
<div class="container mt-3">
  <div class="row">
    <div class="col">
      <ul class="nav justify-content-end">
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/admin/members/edit/' . $member->id) }}">Edit Member</a>
        </li>
      </ul>
    </div>
  </div>
</div>
<div class="container mt-2">
	<div class="row">
		<div class="col">
			<dl class="row">
			  <dt class="col-sm-3">Full Name</dt>
			  <dd class="col-sm-9">{{ $member->first_name }} {{ $member->last_name }}</dd>
			  <dt class="col-sm-3">Barcode ID</dt>
			  <dd class="col-sm-9">{{ $member->barcode_id }}</dd>
			  <dt class="col-sm-3">Optional 1</dt>
			  <dd class="col-sm-9">{{ $member->optional_1 }}</dd>
			  <dt class="col-sm-3">Optional 2</dt>
			  <dd class="col-sm-9">{{ $member->optional_2 }}</dd>
			  <dt class="col-sm-3">Optional 3</dt>
			  <dd class="col-sm-9">{{ $member->optional_3 }}</dd>
			  <dt class="col-sm-3">Optional 4</dt>
			  <dd class="col-sm-9">{{ $member->optional_4 }}</dd>
        <dt class="col-sm-3">Card Printed</dt>
        <dd class="col-sm-9">
          @if($member->printed == 0)
            Not Printed
          @else
            Printed
          @endif
        </dd>
			</dl>
		</div>
	</div>
</div>
@endsection