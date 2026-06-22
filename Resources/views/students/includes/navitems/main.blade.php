@rolecan('can_manage_students_info')
<li class="list-group-item border-0">
    <a href="#students" class="nav-link d-flex align-items-center" data-bs-toggle="collapse" aria-expanded="false" aria-controls="students">
        <i class="fa fa-graduation-cap" aria-hidden="true"></i>
        <span class="menu-title text-muted">{{ (config('schoolviser.type') == 'primary') ? 'Pupils' : 'Manage Students' }}</span>

    </a>
    <ul class="nav collapse" id="students">

        @if (config('schoolviser.type') == 'primary' || config('schoolviser.type') == 'secondary')
        <li class="child-item"><a href="{{ route('students.overview') }}">Overview</a></li>
        <li class="child-item"><a href="{{ route('students') }}">{{ (config('schoolviser.type') == 'primary') ? 'Pupils' : 'Students' }}</a></li>
        <li class="child-item"><a href="{{ route('students.create') }}">Add {{ (config('schoolviser.type') == 'primary') ? 'Pupil' : 'Student' }}</a></li>
        @else
        <li class="child-item"><a href="{{ route('students.overview') }}">Overview</a></li>
        <li class="child-item"><a href="{{ route('students') }}">View Students</a></li>
        <li class="child-item"><a href="{{ route('students.create') }}">Add New Student</a></li>
        <li class="child-item"><a href="{{ route('students.create') }}">Register Student</a></li>
        <li class="child-item"><a href="{{ route('students.unregistered') }}">Unregistred Students</a></li>
        @endif


        <!-- Premium Links -->
        @if (config('schoolviser.package') == 'premium')
        <li class="child-item"><a href="">Import Students</a></li>
        @endif
    </ul>
</li>
@endrolecan
