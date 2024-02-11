<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">RESTO PERDANA</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">RP</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Menu</li>
            <li class="nav-item dropdown {{$type_menu==='dashboard' ? 'active' : ''}}">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Utama</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('home') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ route('home') }}">Overview</a>
                    </li>
                </ul>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('users') ? 'active' : (Request::is('users/*') ? 'active' : '') }}'>
                        <a class="nav-link"
                            href="{{ route('users.index') }}">Users</a>
                    </li>
                </ul>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('categories') ? 'active' : (Request::is('categories/*') ? 'active' : '') }}'>
                        <a class="nav-link"
                            href="{{ route('categories.index') }}">Categories</a>
                    </li>
                </ul>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('products') ? 'active' : (Request::is('products/*') ? 'active' : '') }}'>
                        <a class="nav-link"
                            href="{{ route('products.index') }}">Products</a>
                    </li>
                </ul>
            </li>

        </ul>
    </aside>
</div>
