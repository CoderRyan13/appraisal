<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Request a password reset email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card custom-card w-25">
            <div class="card-body mx-4 my-2">
                <h4 class="text-center">Request a password reset email</h4>
                <form action="{{ route('password.request') }}" method="post">
                    @csrf 
                    {{-- Email --}}
                    <div class="mb-4 px-4 pt-4">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control @error('email') border border-danger @enderror" value="{{ old('email') }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="mb-4 px-4">
                        <button class="btn btn-primary form-control">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>