@extends('layouts.app')
@section('content')
	<div class="container mt-3">
		<div class="jumbotron">
			<h1 class="display-3">Member Event Scanner</h1>
			<h3>{{ $event->name }} - {{ $event->date }}</h3>
			<span class="small">{{ $event->description }}</span>
			<hr class="my-4">
			<p class="lead">Please sign-in or sign-out using the display below.</p>
		</div>
	</div>
	<div class="container mt-3">
		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-header">
						<h4 class="mb-0">Scan Barcode</h4>
					</div>
					<div class="card-body">
						<p class="card-text">Please scan your barcode here. You may have to select the box below if the cursor is not blinking.</p>
						<form role="form" method="POST" action="{{ url('/scans/event/'.$event->id) }}">
							{!! csrf_field() !!}
							<div class="form-group row">
								<div class="col-md-8">
									<input type="text" class="form-control" id="member_barcode_id" name="member_barcode_id" autofocus/>
								</div>
								<div class="col-md-4">
									<button type="submit" class="btn btn-primary btn-block">
										Submit
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container mt-3 d-none" id="success-message">
		<div class="row">
			<div class="col">
				<div class="alert alert-success text-center" role="alert">
					Scan Successful
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$('#success-message').removeClass('d-none');
		setTimeout(function(){
			$("#success-message").addClass('d-none');
		}, 1500);
	</script>
@endsection