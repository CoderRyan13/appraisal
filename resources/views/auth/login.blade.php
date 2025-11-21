<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card custom-card w-25">
            <div class="card-body mx-4 my-2">
                <h4 class="text-center">Login</h4>
                <form method="post" role="form" action="{{ url('/login') }}">
                    @csrf
                    <div class="mt-2">
                        <label for="email">Email</label>  
                        <input type="text" class="mt-1 form-control @error('email') border border-danger @enderror" placeholder="Email" name="email" value="{{ old('email') }}"/>
                        @error('email')
                            <div class="small text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-2">
                        <label for="password">Password</label>  
                        <a href="{{ route('password.request') }}" class="float-end text-success">Forget password?</a>
                        <input type="password" class="mt-1 form-control @error('password') border border-danger @enderror" placeholder="Password" name="password" />
                        @error('password')
                            <div class="small text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-2">
                        <input type="checkbox" name="remember">
                        <label for="remember">Remember me</label>
                    </div>

                    @error('failed')
                        <div class="small text-danger">{{ $message }}</div>
                    @enderror

                    <button class="mt-2 form-control btn btn-success btn-lg">Login</button>
                </form>
                <div class="small mt-2"><a href="{{ url('/register') }}">Don't have an account?</a></div>
            </div>
        </div>
    </div>
</body>
</html>