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
                {{-- <li>
                    <a href="{{ route('dashboard.info') }}">
                        <i data-feather="airplay"></i>
                        <span> 當月總表 </span>
                    </a>
                </li> --}}

                

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
                                <a href="{{ route('person.sales') }}"  class="{{ request()->is('person.sales') ? 'active' : '' }}">業務管理</a>
                            </li>
                            <li>
                                <a href="{{ route('sale.create') }}"  class="{{ request()->is('sale.create') ? 'active' : '' }}">業務Key單</a>
                            </li>
                            <li>
                                <a href="{{ route('person.wait.sales') }}"  class="{{ request()->is('person.wait.sales') ? 'active' : '' }}">業務對帳確認</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#visit" data-bs-toggle="collapse">
                        <i data-feather="github"></i>
                        <span> 拜訪管理 </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="visit">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('hospitals')}}"  class="{{ request()->is('hospitals') ? 'active' : '' }}">醫院紀錄</a>
                            </li>
                            <li>
                                <a href="{{route('etiquettes')}}"  class="{{ request()->is('etiquettes') ? 'active' : '' }}">禮儀社紀錄</a>
                            </li>
                            <li>
                                <a href="{{route('reproduces')}}"  class="{{ request()->is('reproduces') ? 'active' : '' }}">繁殖場紀錄</a>
                            </li>
                            <li>
                                <a href="{{route('dogparks')}}"  class="{{ request()->is('dogparks') ? 'active' : '' }}">狗園紀錄</a>
                            </li>
                            <li>
                                <a href="{{route('salons')}}"  class="{{ request()->is('salons') ? 'active' : '' }}">美容院紀錄</a>
                            </li>
                            <li>
                                <a href="{{route('others')}}"  class="{{ request()->is('others') ? 'active' : '' }}">其他業者紀錄</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#contract" data-bs-toggle="collapse">
                        <i data-feather="folder"></i>
                        <span> 合約管理 </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="contract">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('contracts') }}"  class="{{ request()->is('contracts') ? 'active' : '' }}">合約管理</a>
                            </li>
                            <li>
                                <a href="{{ route('contract.create') }}"  class="{{ request()->is('contract.create') ? 'active' : '' }}">新增合約</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#holiday" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> 人事管理 </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="holiday">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('personnel.leave_days') }}"  class="{{ request()->is('personnel.leave_days') ? 'active' : '' }}">請假核准</a>
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
                            <li>
                                <a href="{{ route('product.restock') }}"  class="{{ request()->is('product.restock') ? 'active' : '' }}">商品進貨</a>
                            </li>
                            <li>
                                <a href="{{ route('product.inventorys') }}"  class="{{ request()->is('product.inventorys') ? 'active' : '' }}">庫存盤點</a>
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
                                <a href="{{ route('rpg17') }}"  class="{{ request()->is('rpg17') ? 'active' : '' }}">安葬服務報表</a>
                            </li>
                            <li>
                                <a href="{{ route('rpg16') }}"  class="{{ request()->is('rpg16') ? 'active' : '' }}">後續服務報表</a>
                            </li>
                            <li>
                                <a href="{{ route('rpg04') }}"  class="{{ request()->is('rpg04') ? 'active' : '' }}">金紙銷售報表</a>
                            </li>
                            <li>
                                <a href="{{ route('rpg13') }}"  class="{{ request()->is('rpg13') ? 'active' : '' }}">金紙賣出報表</a>
                            </li>
                            <li>
                                <a href="{{ route('rpg07') }}"  class="{{ request()->is('rpg07') ? 'active' : '' }}">團火查詢</a>
                            </li>
                            <li>
                                <a href="{{ route('rpg09') }}"  class="{{ request()->is('rpg09') ? 'active' : '' }}">每月營收報表</a>
                            </li>
                            <li>
                                <a href="{{ route('rpg15') }}"  class="{{ request()->is('rpg15') ? 'active' : '' }}">專員各單量統計</a>
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
                                <a href="{{ route('person.leave_days') }}"  class="{{ request()->is('person.leave_days') ? 'active' : '' }}">個人假單</a>
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