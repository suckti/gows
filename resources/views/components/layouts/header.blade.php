<header class="header">
    <div class="logo-container">
        <a href="../4.1.0" class="logo">
            <img src="img/logo-light.png" width="75" height="35" alt="Porto Admin" />
        </a>

        <div class="d-md-none toggle-menu" data-bs-toggle="collapse" data-bs-target=".tab-navigation">
            <i class="fas fa-bars" aria-label="Toggle Menu"></i>
        </div>

    </div>

    <!-- start: search & user box -->
    <div class="header-right">

        <span class="separator"></span>

        <div id="userbox" class="userbox">
            <a href="#" data-bs-toggle="dropdown">
                <figure class="profile-picture">
                    <img src="{{Auth::user()->avatar ?? asset('img/!logged-user.jpg') }}" alt="Joseph Doe" class="rounded-circle" data-lock-picture="img/!logged-user.jpg" />
                </figure>
                <div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
                    <span class="name">{{Auth::user()->name}}</span>
                    <span class="role">{{Auth::user()->username}}</span>
                </div>

                <i class="fa custom-caret"></i>
            </a>

            <div class="dropdown-menu">
                <ul class="list-unstyled mb-2">
                    <li class="divider"></li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="#"><i class="bx bx-user-circle"></i> My Profile</a>
                    </li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="{{ route('logout') }}"><i class="bx bx-power-off"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: search & user box -->
</header>