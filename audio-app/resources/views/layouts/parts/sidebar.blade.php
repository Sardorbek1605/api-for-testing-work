@php $auth_user = \Illuminate\Support\Facades\Auth::user() @endphp
<aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
    <div class="mdc-drawer__header">
        <a href="/" class="brand-logo">
{{--            <img src="{{ asset('assets/images/main/logo.png') }}" style="width: 100%; height: 50px" alt="logo">--}}
            <img src="https://i.pinimg.com/originals/8c/12/97/8c1297c2ba2928f6d26656b45af8cd44.jpg" style="width: 100%; height: 80px" alt="logo">
        </a>
    </div>
    <div class="mdc-drawer__content">
        <div class="mdc-list-group">
            <nav class="mdc-list mdc-drawer-menu">
                <div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-drawer-link {{ (\Request::route()->getName() == 'dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">home</i>
                        Dashboard
                    </a>
                </div>
                @if($auth_user->hasRole('superadmin'))
                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="{{ route('users.index') }}">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">people</i>
                            Users
                        </a>
                    </div>
                @endif
            </nav>
        </div>
    </div>
</aside>
