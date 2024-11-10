@if (count($breadcrumb))
<nav aria-label="Page breadcrumb">
  <ol class="breadcrumb">
    @foreach ($breadcrumb as $key => $value)
      <li class="breadcrumb-item text-capitalize"><a href="{{ $value }}">{{ $key }}</a></li>
    @endforeach
  </ol>
</nav>
@endif