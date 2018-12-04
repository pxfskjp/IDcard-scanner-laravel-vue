@extends('layouts.app')
@section('content')
<div class="container mt-3 d-print-none">
	<div class="row">
		<div class="col">
			<h3>Get all members for one day</h3>
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
          <form method="POST" action="{{ url('admin/reports/membersday_export') }}">
            {{ csrf_field() }}
            <input type="hidden" name="date" value="{{ $scan_date }}"/>
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
      <p>
        <span class="font-weight-bold">Scan Date:</span> {{ $scan_date }}
      </p>
    </div>
  </div>
</div>

<div class="container mt-2">

  <table class="table table-sm">
    <thead>
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Time In</th>
        <th scope="col">Time Out</th>
        <th scope="col">Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($scans as $scan)
        <tr>
          <td>{{ $scan[0]['member']['first_name'] }} {{ $scan[0]['member']['last_name'] }}</td>
          <td>{{ $scan[0]['time'] }}</td>
          <td>{{ $scan[1]['time'] }}</td>
          <td>{{ $scan[2] }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

</div>
@endsection