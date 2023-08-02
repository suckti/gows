<div class="tab-navigation collapse">
    <nav>
        <ul class="nav nav-pills">
            <li class="{{ request()->routeIs('dashboard') ? 'nav-expanded' : '' }}">
                <a class="nav-link" href="{{route('dashboard')}}">
                    <i class="fas fa-home" aria-hidden="true"></i>Home
                </a>
            </li>
            <li class="{{ request()->routeIs('challenge') ? 'nav-expanded' : '' }}">
                <a class="nav-link" href="{{route('challenge')}}">
                    <i class="fas fa-fire-flame-curved" aria-hidden="true"></i>Challenge
                </a>
            </li>
            <li class="">
                <a class="nav-link" href="{{route('activity')}}">
                    <i class="fas fa-list" aria-hidden="true"></i>Activities
                </a>
            </li>
        </ul>
    </nav>
</div>