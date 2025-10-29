<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card custom-card w-25">
            <div class="card-body mx-4 my-2">
                <h4 class="text-center">Register</h4>
                <form method="post" role="form" action="{{ url('/register') }}">
                    @csrf
                    <div class="mt-2">
                        <label for="username">Username</label> 
                        <input type="text" class="mt-1 form-control @error('username') border border-danger @enderror" placeholder="Username" name="username" value="{{ old('username') }}"/>
                        @error('username')
                            <div class="small text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-2">
                        <label for="email">Email</label>  
                        <input type="text" class="mt-1 form-control @error('email') border border-danger @enderror" placeholder="Email" name="email" value="{{ old('email') }}"/>
                        @error('email')
                            <div class="small text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-2">
                        <label for="password">Password</label>  
                        <input type="password" class="mt-1 form-control @error('password') border border-danger @enderror" placeholder="Password" name="password" />
                        @error('password')
                            <div class="small text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-2">
                        <label for="password_confirmation">Confirm Password</label>  
                        <input type="password" class="mt-1 form-control @error('password') border border-danger @enderror" placeholder="Password" name="password_confirmation" />
                    </div>
                    

                    <button class="mt-2 form-control btn btn-success btn-lg">Register</button>
                </form>
                <div class="small mt-2"><a href="{{ url('/login') }}">Have an account? Login.</a></div>
            </div>
        </div>
    </div>
</body>
</html>