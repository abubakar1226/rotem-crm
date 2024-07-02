<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="{{ route('dashboard') }}">
                <img src="{{ asset('backend/images/brand/logo-white.png') }}" class="header-brand-img desktop-logo" alt="logo">
                <img src="{{ asset('backend/images/brand/logo-1.png') }}" class="header-brand-img toggle-logo" alt="logo">
                <img src="{{ asset('backend/images/brand/logo-2.png') }}" class="header-brand-img light-logo" alt="logo">
                <img src="{{ asset('backend/images/brand/logo-3.png') }}" class="header-brand-img light-logo1" alt="logo">
            </a>
            <!-- LOGO -->
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293L7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/>
                </svg>
            </div>
            <ul class="side-menu">
                <li class="sub-category">
                    <h3>Main</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('dashboard') }}">
                        <i class="side-menu__icon fe fe-home"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <li class="sub-category">
                    <h3>Leads</h3>
                </li>

                @php
                    $uri = Request::is(
                        'leads', 'appointments/index', 'leads/no-response/index', 'leads/no-response-twice/index',
                        'refunds'
                    );
                @endphp

                <li class="slide {{ $uri ? 'is-expanded' : '' }}">
                    <a class="side-menu__item {{ $uri ? 'active is-expanded' : '' }}" data-bs-toggle="slide" href="{{ route('leads.index') }}">
                        <i class="side-menu__icon fe fe-briefcase"></i>
                        <span class="side-menu__label">Leads</span>
                        <i class="angle fe fe-chevron-right"></i>
                    </a>

                    <ul class="slide-menu {{ $uri ? 'open' : '' }}">
                        <li>
                            <a href="{{ route('leads.index') }}" class="slide-item {{ Request::is('leads') ? 'active' : '' }}">
                                All Leads
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('appointments.index') }}" class="slide-item {{ Request::is('appointments/index') ? 'active' : '' }}">
                                Appointments Set
                            </a>
                        </li>
                        <li class="{{ Request::is('leads/no-response/index') || Request::is('leads/no-response-twice/index') ? 'is-expanded' : '' }} sub-slide">
                            <a class="sub-side-menu__item" href="javascript:void(0)" data-bs-toggle="sub-slide">
                                <span class="sub-side-menu__label">No Response</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                <li><a class="sub-slide-item {{ Request::is('leads/no-response/index') ? 'active' : '' }}" href="{{ route('leads.no-response.index') }}">Once</a></li>
                                <li><a class="sub-slide-item {{ Request::is('leads/no-response-twice/index') ? 'active' : '' }}" href="{{ route('leads.no-response-twice.index') }}">Twice</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('refunds.index') }}" class="slide-item {{ Request::is('refunds') ? 'active' : '' }}">
                                Refunds
                            </a>
                        </li>
                    </ul>
                </li>
                @canany(['view_roles'])
                    <li class="sub-category">
                        <h3>Manage</h3>
                    </li>
                    <li class="slide {{ Request::is('appointments/index/*') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item {{ Request::is('appointments/index/*') ? 'active is-expanded' : '' }}" data-bs-toggle="slide" href="{{ route('technicians.index') }}">
                            <i class="side-menu__icon fe fe-users"></i>
                            <span class="side-menu__label">Technicians</span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>

                        <ul class="slide-menu {{ Request::is('appointments/index/*') ? 'open' : '' }}">
                            <li class="{{ Request::is('sub_reports') ? 'is-expanded' : '' }}">
                                <a href="{{ route('sub_reports.index') }}" class="slide-item {{ Request::is('sub_reports') ? 'active' : '' }}">
                                    Sub Reports
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('technicians.index') }}" class="slide-item {{ Request::is('technicians.index') ? 'active' : '' }}">
                                    All Technicians
                                </a>
                            </li>
                            @foreach(\App\Models\Technician::select(['id', 'name'])->get()->toArray() as $technician)
                                <li class="{{ Request::is("appointments/index/{$technician['id']}") ? 'active' : '' }}">
                                    <a href="{{ route('appointments.index', $technician['id']) }}" class="slide-item {{ Request::is("appointments/index/{$technician['id']}") ? 'active' : '' }}">
                                        {{ $technician['name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item has-link {{ Request::is('roles') ? 'active' : '' }}" data-bs-toggle="slide" href="{{ route('roles.index') }}">
                            <i class="side-menu__icon fe fe-check-square"></i>
                            <span class="side-menu__label">Role & Permissions</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
