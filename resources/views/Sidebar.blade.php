<div class="left-sidebar-pro">
    <nav id="sidebar" class="">
        <div class="sidebar-header">
            <a href=""><img class="main-logo" width="28%" src="{{ asset('asset/img/Sma5(1).png') }}"
                    alt="" /></a>
            <strong>
                <a href=""><img src="{{ asset('asset/img/Sma5(1).png') }}" alt="" width="50" /></a>
            </strong>
        </div>
        <div class="left-custom-menu-adp-wrap comment-scrollbar">
            <nav class="sidebar-nav left-sidebar-menu-pro">
                <ul class="metismenu" id="menu1">
                    <li class="{{ Request::is('/') ? 'active' : '' }}">
                        <a title="Sensors" href="{{ route('sensors') }}" aria-expanded="false">
                            <i class="fas fa-microchip"></i> <!-- Ikon sensor -->
                            <span class="mini-click-non">Sensor</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('Maps') ? 'active' : '' }}">
                        <a title="Maps RealTime" href="{{ route('maps') }}" aria-expanded="false">
                            <i class="fas fa-map-marked-alt"></i> <!-- Ikon peta -->
                            <span class="mini-click-non">Maps RealTime</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </nav>
</div>
