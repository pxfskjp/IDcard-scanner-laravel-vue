@extends('layouts.app')
@section('content')
<div class="container mt-3 d-print-none">
	<div class="row">
		<div class="col">
			<h3>Get all events for one member</h3>
		</div>
	</div>
</div>
<div class="container mt-3 d-print-none">
  <div class="row">
    <div class="col">
      <ul class="nav justify-content-end">
        <li class="nav-item">
          <a class="nav-link" href="javascript:window.print()" >Print</a>
        </li>
        <li class="nav-item">
          <form method="POST" action="{{ url('admin/reports/eventsmember_export') }}">
            {{ csrf_field() }}
            <input type="hidden" name="member" value="{{ $member->barcode_id }}"/>
            <button type="submit" class="btn btn-link nav-link" >Export</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</div>

<div class="container mt-2">
  <div class="row">
    <div class="col">
      <p class="mb-0">
        <span class="font-weight-bold">Report Generated:</span> {{ date('Y-m-d H:i:s') }} EST
      </p>
      <p class="mb-0">
        <span class="font-weight-bold">Member:</span> {{ $member->first_name }} {{ $member->last_name }}
      </p>
      <p class="mb-0">
        <span class="font-weight-bold">Field 1:</span> {{ $member->optional_1 }}
      </p>
      <p class="mb-0">
        <span class="font-weight-bold">Field 2:</span> {{ $member->optional_2 }}
      </p>
      <p class="mb-0">
        <span class="font-weight-bold">Field 3:</span> {{ $member->optional_3 }}
      </p>
      <p>
        <span class="font-weight-bold">Field 4:</span> {{ $member->optional_4 }}
      </p>
    </div>
  </div>
</div>

<div class="container mt-2">

  <table class="table table-sm">
    <thead>
      <tr>
        <th scope="col">Event</th>
        <th scope="col">Time In</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($scans as $scan)
        <tr>
          <td>{{ $scan[0]['event']['name'] }} - {{ $scan[0]['event']['date'] }}</td>
          <td>{{ $scan[0]['time'] }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

</div>
@endsection