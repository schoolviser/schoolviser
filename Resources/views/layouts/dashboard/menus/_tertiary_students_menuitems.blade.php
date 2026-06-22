@tertiary
<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
    
    <span class="menu-link">
        <span class="menu-title">Manage Students</span>
        <span class="menu-arrow d-lg-none"></span>
    </span>

    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px">
        
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{ route('tertiary.students.overview') }}">
                <span class="menu-title">Overview</span>
            </a>
            <!--end:Menu link-->
        </div>
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{ route('tertiary.students.index') }}">
                <span class="menu-title">View Students</span>
            </a>
            <!--end:Menu link-->
        </div>
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{ route('tertiary.students.create') }}">
                <span class="menu-title">Add Student</span>
            </a>
            <!--end:Menu link-->
        </div>
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link" href="{{ route('tertiary.students.index') }}">
                <span class="menu-title">Search Students</span>
            </a>
            <!--end:Menu link-->
        </div>
    </div>
</div>
@endtertiary                              