<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Welcome | {{ env('APP_NAME') }}</title>
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('backend.layouts.css')
    @stack('css')
    <style>
        #layouts {
            position: fixed;
            height: 100%;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 9999;
            background-color: rgb(0 0 0 / 17%);
        }
    </style>
</head>

<body>
    <section class="section-py first-section-pt">
        <div class="container">
            <div class="row mx-0 gy-3 px-lg-5 mt-15">
                <!-- Pro -->
                <div class="col-12 col-lg-8 mx-auto text-center mb-3">
                    <h4 class="mt-2">Thank You! 😇</h4>
                  @if (Session::has('message'))
                        <p class="alert alert-info">{{ Session::get('message') }}</p>
                    @endif
                    <p>Your Transaction id is <a href="javascript:void(0)">{{ $order_details->transaction_id }}</a> </p>
                    <a href="{{ url('/') }}" class="btn btn-success btn-sm"> Back To Dashboard</a>
                </div>
            </div>
        </div>
    </section>
    @include('backend.layouts.js')
    @stack('js')
</body>
</html>
