<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description ?? settings()['description'] }}">
    <meta name="keywords" content="{{ $keyword ?? settings()['keyword'] }}">
    <meta name="author" content="{{ $author ?? settings()['author'] }}">
    <meta name="robots" content="{{ $robots ?? settings()['robots_index'] ?? 'index, follow' }}">
    <link rel="canonical" href="{{ $canonical_url ?? url()->current() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(!empty(setting('google_search_console')))
    <!-- Google Search Console Verification -->
    <meta name="google-site-verification" content="{{ setting('google_search_console') }}">
    @endif

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="{{ $og_type ?? 'website' }}">
    <meta property="og:url" content="{{ $canonical_url ?? url()->current() }}">
    <meta property="og:title" content="{{ $title ?? settings()['title'] }}">
    <meta property="og:description" content="{{ $description ?? settings()['description'] }}">
    <meta property="og:image" content="{{ $og_image ?? (setting('og_image') ?: settings()['favicon']) }}">
    <meta property="og:site_name" content="{{ settings()['title'] ?? config('app.name') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ $canonical_url ?? url()->current() }}">
    <meta name="twitter:title" content="{{ $title ?? settings()['title'] }}">
    <meta name="twitter:description" content="{{ $description ?? settings()['description'] }}">
    <meta name="twitter:image" content="{{ $og_image ?? (setting('og_image') ?: settings()['favicon']) }}">

    @if(isset($schema_json_ld))
    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {!! json_encode($schema_json_ld, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endif

    <link rel="icon" href="{{ settings()['favicon'] }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ settings()['favicon'] }}" type="image/x-icon">
    <title>{{ $title ?? settings()['title'] }}</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/font-awesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/vendors/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/vendors/chartist.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/vendors/date-picker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/vendors/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/vendors/sweetalert2.css') }}">
    <!-- <link rel="stylesheet" type="text/css" href="/assets/css/vendors/tree.css"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/vendors/jstree.bundle.css') }}" />

    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('/assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/responsive.css') }}">
    <!-- latest jquery-->
    @yield('css')

    <script src="{{ asset('/assets/js/jquery-3.5.1.min.js') }}"></script>
    @if(!empty(setting('custom_head_scripts')))
    {!! setting('custom_head_scripts') !!}
    @endif
  </head>
  <!-- <body onload="startTime()"> -->
  <body>
    <!-- loader starts-->
    <div class="loader-wrapper">
      <div class="loader-index"><span></span></div>
      <svg>
        <defs></defs>
        <filter id="goo">
          <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
          <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"> </fecolormatrix>
        </filter>
      </svg>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      @include('layouts.backend.header')
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        @include('layouts.backend.sidebar')
        <div class="page-body">
          @yield('container')
        </div>
        <!-- footer start-->
        <footer class="footer">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12 footer-copyright text-center">
                <p class="mb-0">Copyright 2022 © Tintapuccino | PT. Esto Kreasi Nusantara  </p>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>

    @php
      $googleAnalyticsId = setting('google_analytics_id') ?: config('services.google_analytics.id');
    @endphp
    @if(!empty($googleAnalyticsId))
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalyticsId }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '{{ $googleAnalyticsId }}');
    </script>
    @endif

    <!-- Bootstrap js-->
    <script src="{{ asset('/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- feather icon js-->
    <script src="{{ asset('/assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('/assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <!-- scrollbar js-->
    <script src="{{ asset('/assets/js/scrollbar/simplebar.js') }}"></script>
    <script src="{{ asset('/assets/js/scrollbar/custom.js') }}"></script>
    <!-- Sidebar jquery-->
    <script src="{{ asset('/assets/js/config.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('/assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('/assets/js/chart/chartist/chartist.js') }}"></script>
    <script src="{{ asset('/assets/js/chart/chartist/chartist-plugin-tooltip.js') }}"></script>
    <script src="{{ asset('/assets/js/chart/knob/knob.min.js') }}"></script>
    <script src="{{ asset('/assets/js/chart/knob/knob-chart.js') }}"></script>
    <script src="{{ asset('/assets/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ asset('/assets/js/chart/apex-chart/stock-prices.js') }}"></script>
    <script src="{{ asset('/assets/js/notify/bootstrap-notify.min.js') }}"></script>
    <!-- <script src="/assets/js/dashboard/default.js"></script> -->
    <script src="{{ asset('/assets/js/notify/index.js') }}"></script>
    <script src="{{ asset('/assets/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{ asset('/assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
    <script src="{{ asset('/assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
    <script src="{{ asset('/assets/js/typeahead/handlebars.js') }}"></script>
    <script src="{{ asset('/assets/js/typeahead/typeahead.bundle.js') }}"></script>
    <script src="{{ asset('/assets/js/typeahead/typeahead.custom.js') }}"></script>
    <script src="{{ asset('/assets/js/typeahead-search/handlebars.js') }}"></script>
    <script src="{{ asset('/assets/js/typeahead-search/typeahead-custom.js') }}"></script>
    <script src="{{ asset('/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('/assets/js/tooltip-init.js') }}"></script>
    <script src="{{ asset('/assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('/assets/js/select2/select2-custom.js') }}"></script>
    <script src="{{ asset('/assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/assets/js/tags.min.js') }}"></script>
    <!-- <script src="/assets/js/tree/jstree.min.js"></script>
    <script src="/assets/js/tree/tree.js"></script> -->
    <script src="{{ asset('/assets/js/jstree/jstree.bundle.js') }}"></script>
    <!-- <script src="/assets/js/sweet-alert/app.js"></script> -->
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{ asset('/assets/js/script.js') }}"></script>
    @yield('javascript')
    <!-- <script src="/assets/js/theme-customizer/customizer.js"></script> -->
    <!-- login js-->
    <!-- Plugin used-->
    @if(!empty(setting('custom_footer_scripts')))
    {!! setting('custom_footer_scripts') !!}
    @endif
  </body>
</html>
