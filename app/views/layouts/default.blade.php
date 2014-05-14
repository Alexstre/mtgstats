<!doctype html>
<html>
<head>
    @include('includes.head')
</head>

<body>
    @include('includes.header')


    <div id="content" class="row">
        <div class="col-md-2">
            @include('includes.sidebar')
        </div>

        <div class="col-md-10">
            @yield('content')
        </div>
    </div>

    <!-- this includes the JS, @parent to add more !-->
    @include('includes.footer')
    @yield('bottom')

</body>
</html>