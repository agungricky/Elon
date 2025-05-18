<div class="header-advance-area">
    <div class="header-top-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="header-top-wraper">
                        <div class="row">
                            <div class="col-lg-1 col-md-0 col-sm-1 col-xs-12">
                                <div class="menu-switcher-pro">
                                    <button type="button" id="sidebarCollapse"
                                        class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                                        <i class="fa fa-bars"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-11 col-md-5 col-sm-12 col-xs-12">
                                <div class="header-right-info" style="margin-right: 20px !important;">
                                    <ul class="nav navbar-nav mai-top-nav header-right-menu">
                                        <li class="nav-item">
                                            <a href="#" data-toggle="dropdown" role="button"
                                                aria-expanded="false" class="nav-link dropdown-toggle">
                                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQyeynfqeriAIx5x2Po5IJakUUTrRyRWf1PnA&s"
                                                    alt="" />
                                                <span class="admin-name">ELON</span>
                                                {{-- <i class="fa fa-angle-down edu-icon edu-down-arrow"></i> --}}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu start -->
    <div class="mobile-menu-area">
        <div class="mobile-menu">
            <span class="banner-text">Ecology Monitoring</span>
            <span class="menu-toggle" onclick="document.getElementById('menu').classList.toggle('show')">&#9776;</span>
        </div>
        <div id="menu" class="menu-items">
            <a href="{{ route('sensors') }}">Sensors</a>
            |
            <a href="{{ route('maps') }}">Maps</a>
        </div>
    </div>

    <style>
        .mobile-menu-area {
            background-color: #2c3e50;
            color: white;
            padding: 10px 20px;
        }

        .mobile-menu {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mobile-menu .banner-text {
            font-size: 18px;
            font-weight: bold;
        }

        .menu-toggle {
            font-size: 24px;
            cursor: pointer;
            display: none;
        }

        .menu-items {
            display: none;
            flex-direction: column;
            background-color: #34495e;
            padding: 10px;
            margin-top: 10px;
        }

        .menu-items a {
            color: white;
            padding: 8px 10px;
            text-decoration: none;
        }

        .menu-items a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            .menu-items.show {
                display: flex;
            }
        }
    </style>

    <div class="content"></div>
</div>
