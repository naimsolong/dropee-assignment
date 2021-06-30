<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin | Login</title>
    
    <link rel="stylesheet" href="{{ mix('/vendor/bootstrap/css/bootstrap.css') }}">
</head>
<body>
    <div class="container">
        <div class="card m-5 p-5">
            <form action="/admin/login" method="post" class="card-body" data-ajax="true">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" name="email" value="admin@email.com" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">Default email: admin@email.com</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" value="123456" class="form-control" id="exampleInputPassword1" aria-describedby="passwordHelp">
                    <div id="passwordHelp" class="form-text">Default password: 123456</div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script src="{{ mix('/vendor/dropee/js/form.js') }}"></script>
</body>
</html>