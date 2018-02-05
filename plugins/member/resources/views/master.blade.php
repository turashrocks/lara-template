<div class="container">
    <div class="row profile">
        <div class="col-md-2">
            <div class="profile-sidebar">
                <div class="profile-userpic">
                    <img src="@if (Auth::guard('member')->user()->avatar) {{ url(Auth::guard('member')->user()->avatar) }} @else http://placehold.it/250x250 @endif" class="img-responsive" alt="{{ Auth::guard('member')->user()->name }}">
                </div>
                <div class="text-center">
                    <div class="profile-usertitle-name">
                        <strong>{{ Auth::guard('member')->user()->name }}</strong>
                    </div>

                </div>

                <div class="profile-usermenu">
                    <ul class="collection nav nav-stacked">
                        <li>
                            <a href="{{ route('public.member.overview') }}" class="collection-item @if (Route::currentRouteName() == 'public.member.overview') active @endif">{{ __('Overview') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('public.member.edit') }}" class="collection-item @if (Route::currentRouteName() == 'public.member.edit') active @endif">{{ __('Edit Account') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('public.member.avatar') }}" class="collection-item @if (Route::currentRouteName() == 'public.member.avatar') active @endif">{{ __('Change Avatar') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('public.member.password') }}" class="collection-item @if (Route::currentRouteName() == 'public.member.password') active @endif">{{ __('Change Password') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('public.member.logout') }}" class="collection-item">{{ __('Logout') }}</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-md-10">
            @yield('content')
        </div>
    </div>
</div>