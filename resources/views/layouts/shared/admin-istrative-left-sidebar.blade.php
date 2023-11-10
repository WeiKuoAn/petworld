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
                    <a href="#customer" data-bs-toggle="collapse">
                        <i data-feather="life-buoy"></i>
                        <span> 客戶管理 </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="customer">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('customer.create')}}"  class="{{ request()->is('customer.create') ? 'active' : '' }}">新增客戶</a>
                            </li>
                            <li>
                                <a href="{{ route('customer.group') }}"  class="{{ request()->is('customer.group') ? 'active' : '' }}">客戶群組</a>
                            </li>
                            <li>
                                <a href="{{ route('customer')}}"  class="{{ request()->is('customer') ? 'active' : '' }}">客戶列表</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sale" data-bs-toggle="collapse">
                        <i data-feather="codesandbox"></i>
                        <span> 業務管理 </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sale">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('sales') }}"  class="{{ request()->is('sales') ? 'active' : '' }}">業務管理</a>
                            </li>
                            <li>
                                <a href="{{ route('sale.create') }}"  class="{{ request()->is('sale.create') ? 'active' : '' }}">業務Key單</a>
                            </li>
                            <li>
                                <a href="{{ route('wait.sales') }}"  class="{{ request()->is('wait.sales') ? 'active' : '' }}">業務對帳確認</a>
                            </li>
                        </ul>
                    </div>
                </li>

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
                    <a href="#income" data-bs-toggle="collapse">
                        <i data-feather="trending-up"></i>
                        <span> 收入管理 </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="income">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('income.sujects') }}"  class="{{ request()->is('income.sujects') ? 'active' : '' }}">收入科目</a>
                            </li>
                            <li>
                                <a href="{{ route('incomes') }}"  class="{{ request()->is('incomes') ? 'active' : '' }}">收入管理</a>
                            </li>
                            <li>
                                <a href="{{ route('income.create') }}"  class="{{ request()->is('income.create') ? 'active' : '' }}">收入key單</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#product" data-bs-toggle="collapse">
                        <i data-feather="shopping-cart"></i>
                        <span> 商品管理 </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="product">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('product.category')}}"  class="{{ request()->is('product.category') ? 'active' : '' }}">商品類別</a>
                            </li>
                            <li>
                                <a href="{{ route('product.create') }}"  class="{{ request()->is('product.create') ? 'active' : '' }}">新增商品</a>
                            </li>
                            <li>
                                <a href="{{ route('product') }}"  class="{{ request()->is('product') ? 'active' : '' }}">商品列表</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#other" data-bs-toggle="collapse">
                        <i data-feather="database"></i>
                        <span> 其他管理 </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="other">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('sources') }}"  class="{{ request()->is('sources') ? 'active' : '' }}">來源資料</a>
                            </li>
                            <li>
                                <a href="{{ route('plans') }}"  class="{{ request()->is('plans') ? 'active' : '' }}">方案資料</a>
                            </li>
                            <li>
                                <a href="{{ route('proms') }}"  class="{{ request()->is('proms') ? 'active' : '' }}">後續處理</a>
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

                <li>
                    <a href="#person" data-bs-toggle="collapse">
                        <i data-feather="user"></i>
                        <span> 個人管理 </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="person">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('person.pays') }}"  class="{{ request()->is('person.pays') ? 'active' : '' }}">個人支出</a>
                            </li>
                            <li>
                                <a href="{{ route('user-profile') }}"  class="{{ request()->is('user-profile') ? 'active' : '' }}">個人資料</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->