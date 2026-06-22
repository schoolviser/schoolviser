@secondary
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
    
    <span class="menu-link">
        <span class="menu-title">Manage Students</span>
        <span class="menu-arrow d-lg-none"></span>
    </span>

    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px">
        
        <div class="menu-item">
            <a class="menu-link" href="{{ route('students.index') }}">
                <span class="menu-icon">
                    <i class="bi bi-user fs-1"></i>
                </span>
                <span class="menu-title">View Students</span>
            </a>
        </div>

        <div class="menu-item">
            <a class="menu-link" href="{{ route('students.create') }}">
                <span class="menu-icon">
                    <i class="bi bi-user fs-1"></i>
                </span>
                <span class="menu-title">Add Student</span>
            </a>
        </div>

    </div>
</div>
@endsecondary                              