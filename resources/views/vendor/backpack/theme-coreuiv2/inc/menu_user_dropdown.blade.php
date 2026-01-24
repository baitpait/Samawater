<li class="nav-item dropdown pr-4">
  {{-- تم إخفاء Avatar بالكامل - سيظهر اسم المستخدم فقط --}}
  <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" style="display: flex; align-items: center; gap: 10px;">
    {{-- لا يوجد avatar --}}
    <span style="color: #333; font-weight: 500; font-size: 14px; font-family: 'Cairo', sans-serif;">
      {{ backpack_user()->name }}
    </span>
    <i class="la la-angle-down" style="font-size: 14px; color: #666;"></i>
  </a>
  <div class="dropdown-menu {{ backpack_theme_config('html_direction') == 'rtl' ? 'dropdown-menu-left' : 'dropdown-menu-right' }} mr-4 pb-1 pt-1">
    @if(config('backpack.base.setup_my_account_routes'))
      <a class="dropdown-item" href="{{ route('backpack.account.info') }}"><i class="la la-user"></i> {{ trans('backpack::base.my_account') }}</a>
      <div class="dropdown-divider"></div>
    @endif
    <a class="dropdown-item" href="{{ backpack_url('logout') }}"><i class="la la-lock"></i> {{ trans('backpack::base.logout') }}</a>
  </div>
</li>

