<!DOCTYPE html>
<html>
<head>
    <title>Soupe</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container"></div>

        <nav class="navbar">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ URL::to('events') }}">NAME</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="{{ URL::to('events') }}">Events</a></li>
                <li><a href="{{ URL::to('decks') }}">Decks</a></li>
                <li><a href="{{ URL::to('cards') }}">Cards</a></li>
                <li><a href="{{ URL::to('events/create') }}">Submit an Event</a>
            </ul>
        </nav>

        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif

        @yield('content') <!-- Page content loaded from other pages goes here !-->
    </div>
    
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    </body>
</html>