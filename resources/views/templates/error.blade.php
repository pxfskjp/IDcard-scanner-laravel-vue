@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if (\Session::get('success'))
<div class="alert alert-success">
    <p>{{ \Session::get('success') }}</p>
</div>
@endif 
@if (\Session::get('error'))
<div class="alert alert-danger">
    <p>{{ \Session::get('error') }}</p>
</div>
@endif
@if(session('success'))
    <div class="alert alert-success">{{session('success')}}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{session('error')}}</div>
@endif