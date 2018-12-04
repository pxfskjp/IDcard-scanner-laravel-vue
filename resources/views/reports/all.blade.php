@extends('layouts.app')
@section('content')
<div class="container mt-3">
	<div class="row">
		<div class="col">
			<h3>Reports</h3>
			<p class="mb-0">What would you like to get a report of?</p>
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


<h4 class="mb-3">Daily Scan Reports</h4>
    <div class="card">
      <div class="card-header">
        <a class="card-link" data-toggle="collapse" href="#collapseOne">
          Get all members for one day
        </a>
      </div>
      <div id="collapseOne" class="collapse" data-parent="#accordion">
        <div class="card-body">
          <form action="{{ url('admin/reports/membersday') }}" method="POST">
            {{ csrf_field() }}
          	<div class="row">
          		<div class="col-md-3">
          			<input class="form-control" placeholder="Select Date" type="date" name="date" />
          		</div>
          		<div class="col-md-3">
          			<button class="btn btn-primary btn-block">Generate</button>
          		</div>
          	</div>
          </form>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
        Get a date range for one member
      </a>
      </div>
      <div id="collapseTwo" class="collapse" data-parent="#accordion">
        <div class="card-body">
          <form action="{{ url('admin/reports/daysmember') }}" method="POST">
            {{ csrf_field() }}
          	<div class="row">
          		<div class="col-md-3">
          			<input class="form-control" placeholder="Select Date" type="date" name="start_date" />
          		</div>
          		<div class="col-md-3">
          			<input class="form-control" placeholder="Select Date" type="date" name="end_date" />
          		</div>
          		<div class="col-md-3">
          			<select class="form-control member_list" placeholder="Select Member" type="text" name="member" style="width: 100%">
                   <option value="0">Select a member</option>
                </select>
          		</div>
          		<div class="col-md-3">
          			<button class="btn btn-primary btn-block">Generate</button>
          		</div>
          	</div>
          </form>
        </div>
      </div>
    </div>
    <h4 class="mt-3 mb-3">Event Scan Reports</h4>
    <div class="card">
      <div class="card-header">
        <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
          Get all members for one event
        </a>
      </div>
      <div id="collapseThree" class="collapse" data-parent="#accordion">
        <div class="card-body">
          <form action="{{ url('admin/reports/membersevent') }}" method="POST">
            {{ csrf_field() }}
          	<div class="row">
          		<div class="col-md-3">
          			<select class="form-control event_list" placeholder="Select Event" name="event" style="width:100%"/>
                  <option value="0">Select an event</option>
                </select>
          		</div>
          		<div class="col-md-3">
          			<button class="btn btn-primary btn-block">Generate</button>
          		</div>
          	</div>
          </form>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <a class="collapsed card-link" data-toggle="collapse" href="#collapseFour">
          Get all events for one member
        </a>
      </div>
      <div id="collapseFour" class="collapse" data-parent="#accordion">
        <div class="card-body">
          <form action="{{ url('admin/reports/eventsmember') }}" method="POST">
            {{ csrf_field() }}
          	<div class="row">
          		<div class="col-md-3">
          			<select class="form-control member_list" placeholder="Select Member" type="text" name="member" style="width: 100%">
                   <option value="0">Select a member</option>
                </select>
          		</div>
          		<div class="col-md-3">
          			<button class="btn btn-primary btn-block">Generate</button>
          		</div>
          	</div>
          </form>
        </div>
      </div>
    </div>
		</div>
	</div>
</div>

<script>
  // Select 2 Member
  $('.member_list').select2({
    ajax: {
      url: '/members',
      dataType: 'json',
      processResults: function (data) {
        var names = [];
        $.each(data, function(key, val) {
          names.push({
            text: val['first_name'] + ' ' + val['last_name'],
            id: val['barcode_id']
          });
        });
        return{
          results: names
        };
      },
      minimumInputLength: 2
    }
  });

  // Select 2 Event
  $('.event_list').select2({
    ajax: {
      url: '/events',
      dataType: 'json',
      processResults: function (data) {
        var names = [];
        $.each(data, function(key, val) {
          names.push({
            text: val['name'],
            id: val['id']
          });
        });
        return{
          results: names
        };
      },
      minimumInputLength: 2
    }
  });
</script>

@endsection