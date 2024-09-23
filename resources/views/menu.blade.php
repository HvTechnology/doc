<div class="nk-sidebar">           
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">

            <a class="has-arrow" href="{{ route('dashboard') }}" aria-expanded="false">
                <h4> <i class="icon-speedometer menu-icon"></i><span class="nav-text">  Dashboard</span></h4>
            </a>

            <a class="has-arrow" href="{{ route('pazienti') }}" aria-expanded="false">
                <h4> <i class="icon-user menu-icon"></i><span class="nav-text">  Pazienti</span></h4>
            </a>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <h4><i class="icon-globe-alt menu-icon"></i><span class="nav-text">Impostazioni</span></h4>
                </a>
                <ul aria-expanded="false">
                    <li><a href="/dashboard/schedule"><h4>Orario di lavoro</h4></a></li>
                       <li><a href="/vacation"> <h4>Ferie</h4></a></li>
                </ul>
            </li>
          
        </ul>
    </div>
</div>