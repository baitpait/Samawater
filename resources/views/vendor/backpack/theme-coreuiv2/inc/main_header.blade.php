<header class="{{ backpack_theme_config('classes.header') }}">
  <div class="d-flex align-items-center" style="padding: 0.75rem 1.5rem;">
    {{-- Sidebar Toggle Button --}}
    <button 
      id="sidebarToggle" 
      class="sidebar-toggle-btn" 
      type="button" 
      aria-label="إخفاء/إظهار القائمة"
      title="إخفاء/إظهار القائمة"
    >
      <i class="las la-bars"></i>
    </button>
    
    {{-- Project Name --}}
    <a class="navbar-brand ml-3" href="{{ url(backpack_theme_config('home_link')) }}" title="{{ backpack_theme_config('project_name') }}">
      <span style="color: #6f6af8; font-weight: 700; font-family: 'Cairo', sans-serif;">
        {{ backpack_theme_config('project_name') }}
      </span>
    </a>
    
    {{-- Spacer --}}
    <div class="flex-grow-1"></div>
    
    {{-- User Menu --}}
    @include(backpack_view('inc.menu'))
  </div>
</header>
