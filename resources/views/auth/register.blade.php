<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('bootstrap-3.1.1/css/bootstrap.min.css') }}">
</head>
<body>

<div class="container">
    <div class="row" style="margin-top: 100px">
        <div class="col-md-4 col-md-offset-4">
            <h4>Register | Custom Authentication</h4><hr>
            <form action="{{ route('auth.save') }}" method="post">
            @if(Session::get('Success'))
                <div class="alert alert-success">
                {{ Session::get('Success') }}
                </div>
            @endif

            @if(Session::get('Failure'))
                <div class="alert alert-danger">
                {{ Session::get('Failure') }}
                </div>
            @endif

            @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name='name' placeholder="Enter full name" value="{{ old('name') }}"> 
                    <span class="text-danger">@error('name'){{ $message }} @enderror</span>               
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name='email' placeholder="Enter e-mail address" value="{{ old('email') }}">
                    <span class="text-danger">@error('email'){{ $message }} @enderror</span>                
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name='password' placeholder="Enter password"> 
                    <span class="text-danger">@error('password'){{ $message }} @enderror</span>               
                </div>
                <!--div class="form-group">
                    <label>Is User?</label>
                    <input type="checkbox" class="form-control" name='isUser'> 
                    <span class="text-danger">@error('isUser'){{ $message }} @enderror</span>               
                </div-->
                <button type="submit" class="btn btn-block btn-primary">Sign Up!</button>
                <br>
                <a href="{{ route('auth.login') }}">Sign In to Existing Account</a>
            </form>
        </div> 

    </div>

</div>
    
</body>
</html>