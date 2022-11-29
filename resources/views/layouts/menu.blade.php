<li class="nav-item {{ Request::is('dashboard*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('home') }}">
        <i class="fa fa-home"></i>
        <span>Dashboard</span>
    </a>
</li>
<li class="nav-item {{ Request::is('lead-category*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('lead-category.index') }}">
        <i class="fa fa-align-justify"></i>
        <span>Lead Category</span>
    </a>
</li>
<li class="nav-item {{ Request::is('leads*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('leads.index') }}">
        <i class="fa fa-align-justify"></i>
        <span>Leads</span>
    </a>
</li>
<li class="nav-item {{ Request::is('lead-contacts*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('lead-contacts.index') }}">
        <i class="fa fa-align-justify"></i>
        <span>Lead Contacts</span>
    </a>
</li>
<li class="nav-item {{ Request::is('lead-email-templates*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('lead-email-templates.index') }}">
        <i class="fa fa-align-justify"></i>
        <span>Lead Email Templates</span>
    </a>
</li>
