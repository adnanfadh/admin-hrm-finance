<!doctype html>
  <html lang="en">
    <head>
      <base href="">
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="description" content="Updates and statistics" />
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta name="csrf-token" content="{{ csrf_token() }}">


      {{-- <title>{{ $title ?? config('app.name') }}</title> --}}
      <title>{{ Request::path() }}</title>

      {{-- Style --}}
      @stack('prepend-style')
      @include('includes.style')
      @stack('addon-style')

    </head>
    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

      {{-- header --}}
      @include('includes.header')

      {{-- sidebar --}}
      @include('includes.sidebar')

      {{-- navbar --}}
      @include('includes.navbar')

      <!--begin::Entry-->
			<div class="d-flex flex-column-fluid bg-gray">

        {{-- Page Content --}}
        @yield('content')


      </div>
			<!--end::Entry-->

      {{-- footer --}}
      @include('includes.footer')

      {{-- Script --}}
      @stack('prepend-script')
      @include('includes.script')
      @stack('addon-script')
    </body>
  </html>
