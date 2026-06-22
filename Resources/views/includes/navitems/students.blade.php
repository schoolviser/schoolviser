<li class="nav-item text-muted text-uppercase" style="font-weight: 600; font-size: 9px;">
  Manage Students
</li>

<li class="nav-item">
  <a class="nav-link" href="{{ route('students', ['year' => term()->year ?? '2023', 'term' => term()->term ?? '1']) }}">Students Info</a>
</li>
<li class="nav-item">
  <a class="nav-link" href="">Parents</a>
</li>
