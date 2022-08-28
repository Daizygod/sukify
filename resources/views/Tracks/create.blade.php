<!DOCTYPE html>
<html>
<head>
    <title>Laravel 9 Form Validation</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header text-center font-weight-bold">
            <h2>Laravel 9 Form Validation</h2>
        </div>
        <div class="card-body">
            <form name="employee" id="employee" method="post" action="{{URL::to('tracks/store')}}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" id="name" name="name" class="@error('name') is-invalid @enderror form-control">
                    @error('name')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Age</label>
                    <input type="number" id="type" name="type" class="@error('type') is-invalid @enderror form-control">
                    @error('type')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Contact No</label>
                    <input type="number" id="counter" name="counter" class="@error('counter') is-invalid @enderror form-control">
                    @error('counter')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
The following below code will display validation error message on blade view file:

1
2
3
@error('name')
<div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
@enderror
