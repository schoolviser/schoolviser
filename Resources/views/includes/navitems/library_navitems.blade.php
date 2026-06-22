<li class="nav-item">
 <a class="nav-link" href="{{route('library')}}">Library</a>
</li>

@if (role_has_permission(auth()->user()->role_id, $libraryPermissions::CAN_VIEW_LIBRARY_BOOKS))
<li class="nav-item">
  <a class="nav-link" href="{{route('library.items.books')}}">Books</a>
</li>
@endif

<li class="nav-item">
  <a class="nav-link" href="{{route('library')}}">New Book</a>
</li>

<li class="nav-item">
  <a class="nav-link" href="{{route('library.publishers')}}">Publishers</a>
</li>
<hr class="my-2" />

  <li class="nav-item">
      <a class="nav-link" href="{{route('library.members')}}">Members</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{route('library.members.register.student')}}">Register Member</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{route('library.members')}}">Blocked Members</a>
</li>
<hr class="my-2" />
            
<li class="nav-item">
    <a class="nav-link" href="{{route('library.members')}}">Library Settings</a>
</li>