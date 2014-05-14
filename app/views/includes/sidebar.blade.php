<div class="sidebar content-box" style="display: block;">
    <ul class="nav">
        <!-- Main menu -->
        <li class="{{ Request::is('events') ? 'current' : '' }}"><a href="{{ URL::to('events') }}"><i class="glyphicon glyphicon-calendar"></i> Events</a></li>
        <li class="{{ Request::is('decks') ? 'current' : '' }}"><a href="{{ URL::to('decks') }}"><i class="glyphicon glyphicon-stats"></i> Decks</a></li>
        <li class="{{ Request::is('cards') ? 'current' : '' }}"><a href="{{ URL::to('cards') }}"><i class="glyphicon glyphicon-picture"></i> Cards</a></li>
        <li class="submenu">
            <a href="#">
                <i class="glyphicon glyphicon-list"></i> Other Stuff
                <span class="caret pull-right"></span>
            </a>
            <!-- Sub menu -->
            <ul>
                @if (Auth::check())
                <li><a href="{{ URL::route('user/profile') }}">Profile</a></li>
                <li><a href="{{ URL::route('user/logout') }}">Logout</a></li>
                @else
                <li><a href="{{ URL::route('user/login') }}">Log in or Sign up</a></li>
                @endif
            </ul>
        </li>
    </ul>
</div>