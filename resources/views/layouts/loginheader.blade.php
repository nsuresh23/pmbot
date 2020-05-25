<head>
    <meta charset="UTF-8">
    <title> RAZOR - Login </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ url('/css/all.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .has-feedback label ~ .form-control-feedback {
            top:0px;
        }
        label.error{
          color: #a94442;
          font-size:14px;
          font-weight: 500;
        }
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>