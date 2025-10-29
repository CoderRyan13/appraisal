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
    <div class="card custom-card w-25 m-4 p-4">
        <h4 class="mb-4">Please verify your email through the email we've sent you.</h4>
    
        <div class="mb-2">Didn't get the email?</div>
        <form action="{{ route('verification.send') }}" method="post">
            @csrf 
            <button class="btn btn-primary">Send again</button>
        </form>
    </div>
</body>
</html>