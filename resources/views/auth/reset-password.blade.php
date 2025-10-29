<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset your password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card custom-card w-25">
            <div class="card-body mx-4 my-2">
                <h4 class="text-center">Reset your password</h4>
                <form action="{{ route('password.update') }}" method="post">
                    @csrf 

                    <input type="hidden" name="token" value="{{ $token }}">

                    {{-- Email --}}
                    <div class="mb-4 px-4 pt-4">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control @error('email') border border-danger @enderror" value="{{ old('email') }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-4 px-4">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control @error('password') border border-danger @enderror">
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="mb-4 px-4">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control @error('password') border border-danger @enderror">
                    </div>

                    {{-- Submit Button --}}
                    <div class="mb-4 px-4">
                        <button class="btn btn-primary form-control">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>