<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">
            <img src="{{asset('assets/images/users/user-9.jpg')}}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown">James Kennedy</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>個人資訊</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>變更密碼</span>
                    </a>

                    <!-- item-->
                    {{-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock me-1"></i>
                        <span>Lock Screen</span>
                    </a> --}}

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted">Admin Head</p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title">主要</li>

                <li>
                    <a href="{{ route('index') }}">
                        <i data-feather="home"></i>
                        <span> 線上打卡 </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.info') }}">
                        <i data-feather="airplay"></i>
                        <span> 當月總表 </span>
                    </a>
                </li>

                
                <li class="menu-title mt-2">Apps</li>
                <li>
                    <a href="#pay" data-bs-toggle="collapse">
                        <i data-feather="trending-down"></i>
                        <span> 支出管理 </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="pay">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('pay.sujects') }}"  class="{{ request()->is('pay.sujects') ? 'active' : '' }}">支出科目</a>
                            </li>
                            <li>
                                <a href="{{ route('pays') }}"  class="{{ request()->is('pays') ? 'active' : '' }}">支出管理</a>
                            </li>
                            <li>
                                <a href="{{ route('pay.create') }}"  class="{{ request()->is('pay.create') ? 'active' : '' }}">支出Key單</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#rpg" data-bs-toggle="collapse">
                        <i data-feather="file-text"></i>
                        <span> 報表管理 </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="rpg">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('rpg01') }}"  class="{{ request()->is('rpg01') ? 'active' : '' }}">方案報表</a>
                            </li>
                            <li>
                                <a href="{{ route('rpg04') }}"  class="{{ request()->is('rpg04') ? 'active' : '' }}">金紙銷售報表</a>
                            </li>
                            <li>
                                <a href="{{ route('rpg13') }}"  class="{{ request()->is('rpg13') ? 'active' : '' }}">金紙賣出報表</a>
                            </li>
                            <li>
                                <a href="{{ route('rpg16') }}"  class="{{ request()->is('rpg16') ? 'active' : '' }}">安葬服務報表</a>
                            </li>
                            <li>
                                <a href="{{ route('rpg17') }}"  class="{{ request()->is('rpg17') ? 'active' : '' }}">後續服務報表</a>
                            </li>
                            <li>
                                <a href="{{ route('rpg02') }}"  class="{{ request()->is('rpg02') ? 'active' : '' }}">支出報表</a>
                            </li>
                            <li>
                                <a href="{{ route('rpg05') }}"  class="{{ request()->is('rpg05') ? 'active' : '' }}">日營收報表</a>
                            </li>
                            <li>
                                <a href="{{ route('rpg09') }}"  class="{{ request()->is('rpg09') ? 'active' : '' }}">月營收報表</a>
                            </li>
                            <li>
                                <a href="{{ route('rpg11') }}"  class="{{ request()->is('rpg11') ? 'active' : '' }}">年度營收報表</a>
                            </li>
                        </ul>
                    </div>
                </li>


            </li>

                
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->