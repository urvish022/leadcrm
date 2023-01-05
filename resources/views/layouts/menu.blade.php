<li class="nav-item {{ Request::is('dashboard*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('home') }}">
        <i class="fa fa-home"></i>&nbsp;
        <span>Dashboard</span>
    </a>
</li>
<li class="nav-item {{ Request::is('lead-category*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('lead-category.index') }}">
        <i class="fa fa-align-justify"></i>&nbsp;
        <span>Niche Category</span>
    </a>
</li>
<li class="nav-item {{ Request::is('leads*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('leads.index') }}">
        <i class="fa fa-building"></i>&nbsp;
        <span>Companies</span>
    </a>
</li>
<li class="nav-item {{ Request::is('lead-contacts*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('lead-contacts.index') }}">
        <i class="fa fa-address-book"></i>&nbsp;
        <span>Contacts</span>
    </a>
</li>
<li class="nav-item {{ Request::is('scheduler*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('scheduler.index') }}">
        <i class="fa fa-calendar"></i>&nbsp;
        <span>Scheduler</span>
    </a>
</li>
<li class="nav-item {{ Request::is('ai*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('ai.index') }}">
        <i class="fa fa-search"></i>&nbsp;
        <span>AI Notes</span>
    </a>
</li>
<li class="nav-item {{ Request::is('lead-email-templates*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('lead-email-templates.index') }}">
        <i class="fa fa-envelope"></i>&nbsp;
        <span>Email Templates</span>
    </a>
</li>
<li class="nav-item {{ Request::is('settings*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('settings.index') }}">
        <i class="fa fa-gear"></i>&nbsp;
        <span>Settings</span>
    </a>
</li>
