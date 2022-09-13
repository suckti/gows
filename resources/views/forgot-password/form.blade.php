<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gows</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>


    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .m-b-sm {
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #2C5282;
            border: 1px solid #2C5282;
            color: #fff;
            padding: 8px 15px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="flex-center full-height">
        <div class="content">
            <div class="row">
                <form method="post" action="/password-reset">
                    @csrf
                    <div class="col m-b-sm">
                        <label for="password">New Password</label>
                        <input type="hidden" class="form-control" value="{{ $email }}" name="email">
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Enter new password" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="col m-b-sm">
                        <label for="password2">Re-Type Password</label>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Re-Type password" id="password2" required>
                        </div>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </form>
                <!-- </div> -->

            </div>

        </div>
    </div>
</body>

</html>