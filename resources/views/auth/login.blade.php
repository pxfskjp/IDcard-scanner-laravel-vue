@extends('layouts.app')
@section('content')
<div class="container mt-3">
	<div class="row">
		<div class="col-md-8 mx-auto">
			<div class="card mt-3">
					<div class="card-header">
						Login
					</div>
					<div class="card-body">
						<form action="{{ url('login') }}" method="POST" role="form">
							{!! csrf_field() !!}
							<div class="row form-group d-none">
								<div class="col">
									<label>
										Email
									</label>
									<input type="email" name="email" value="admin@example.com" class="form-control form-control-sm {{ $errors->has('email') ? 'in-invalid' : '' }}"/>
									<div class="invalid-feedback">
										<strong>
											{{ $errors->first('email') }}
										</strong>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col">
									<label>
										Password
									</label>
									<input type="password" name="password" class="form-control form-control-sm {{ $errors->has('password') ? 'in-invalid' : '' }}"/>
									<div class="invalid-feedback">
										<strong>
											{{ $errors->first('password') }}
										</strong>
									</div>
								</div>
							</div>
							{{-- <div class="row form-group">
								<div class="col">
									<label class="form-check-label">
										<input class="form-check-input" type="checkbox" />
										Remember Me
									</label>
								</div>
							</div> --}}
							<div class="row form-group">
								<div class="col">
									<button class="btn btn-primary btn-sm btn-block">
										Login
									</button>
								</div>
							</div>
							{{-- <div class="row">
								<div class="col">
									<a class="btn btn-secondary btn-block btn-sm" href="{{ route('password.request') }}">
										Forgot Your Password?
									</a>
								</div>
							</div> --}}
						</form>
					</div>
				</div>
		</div>
	</div>
</div>
@endsection
