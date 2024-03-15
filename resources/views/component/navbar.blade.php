<header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 py-2 px-3 fs-6 text-white" href="#">App Kasir</a>

    <ul class="navbar-nav flex-row">
        @auth
            <li class="nav-item text-nowrap d-flex align-items-center">
                <span class="text-white d-none d-md-inline">{{ Auth::user()->username }}</span>
                <img class="rounded-circle mx-md-2 ms-1"
                    src="https://tse1.mm.bing.net/th?id=OIP.ms_ni44c-_TBsdHzF0W5awHaHa&pid=Api&P=0&h=180" alt=""
                    style="width: 2em; height: 2em;">
            </li>
        @endauth
        <li class="nav-item text-nowrap d-md-none">
            <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                aria-label="Toggle navigation">
                <svg class="bi">
                    <use xlink:href="#list" />
                </svg>
            </button>
        </li>
    </ul>
</header>
