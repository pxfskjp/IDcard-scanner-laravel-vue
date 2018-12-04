@extends('layouts.app')

@section('content')
<div class="container mt-3">
	<div class="row">
		<!-- Daily Scan -->
		<div class="col-md">
			<div class="card">
				<div class="card-header">
					<div class="card-img text-center">
						<h1 class="display-1"><i class="fa fa-clock"></i></h1>
					</div>
				</div>
				<div class="card-body">
					<div class="text-center">
						<h3>Daily Scanner</h3>
					</div>
					<div class="row">
						<div class="col">
							<a class="btn btn-primary btn-block" href="{{ url('/scans/daily') }}">Go</a>
						</div>
					</div>
				</div>
			</div>		
		</div>
		<!-- Event Scan -->
		<div class="col-md">
			<div class="card">
				<div class="card-header">
					<div class="card-img text-center">
						<h1 class="display-1"><i class="fa fa-calendar"></i></h1>
					</div>
				</div>
				<div class="card-body">
					<div class="text-center">
						<h3>Event Scanner</h3>
					</div>
						<div class="row">
							<div class="col">
								<select class="form-control event_list" style="width:100%" onchange="location = '/scans/event/' + this.value;">
										<option value="0">Select an event</option>
								</select>
							</div>
						</div>
				</div>
			</div>		
		</div>	
	</div>
</div>

<script>
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


