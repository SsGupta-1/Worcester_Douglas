<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>Worcester Douglas Limited</title>
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.css')}}">
		<link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap-grid.css')}}">
		<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/font-awesome.min.css')}}" rel="stylesheet">
		<link href="{{asset('assets/css/selectize.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
		<link href="{{asset('assets/css/jquery-ui.min.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" />
    @toastr_css
  </head>
  <body>