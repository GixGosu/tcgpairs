<!DOCTYPE html>
@section('css')
<link rel="stylesheet" type="text/css" href="{{  asset('/node_modules/bootstrap-css-only/css/bootstrap.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{  asset('/node_modules/font-awesome/css/font-awesome.min.css') }}"/>
@show

<body class="layout-default">
  @yield('header')
  <div id="vue-app">
    @yield('body')
  </div>
  @yield('footer')
  @yield('scripts')
</body>
</html>
