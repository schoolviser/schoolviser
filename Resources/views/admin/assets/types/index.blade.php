@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Asset Section')
@section('pageheaderDescription', 'Define Your Asset Types')

@section('pageheader-controls')
<a href="{{ route('assets.add') }}" class="px-3 py-1 rounded-5  font-12 border border-primary text-primary text-muted">Add Asset Type</a>
<a href="{{ route('assets.add') }}" class="px-2 py-1 rounded-4  font-12 border border-primary text-primary">Import Add Asset</a>
@endsection
@section('where-am-i')
<a href="{{route('dashboard')}}" class="font-10 py-1 px-2 rounded-4 my-1 fw-light text-dark">Dashboard</a>
<a href="" class="font-10 py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('assets')}}" class="font-10 py-1 px-2 rounded-4 my-1">Assets</a>
<a href="" class="font-10 py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('assets.types')}}" class="font-10 py-1 px-2 rounded-4 my-1">Asset Types</a>
@endsection

@section('content')

<div class="row mt-">
  <div class="col-lg-12">
    @if (count($assetTypes) > 0)
        <div class="table-responsive rounded-3 shadow-sm">
          <table class="table table-bordered table-hover table-striped">
            <thead>
              <th>SN</th>
              <th>Asset Type</th>
              <th>Categories</th>
              <th>Actions</th>
            </thead>
            <tbody>
              @foreach ($assetTypes as $type)
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td><span class="bg-light py-1 px-2 rounded-5">{{ $type->name }}</span> <br /> <small class="font-10 text-muted">{{ $type->description }}</small></td>
                    <td>
                      {{ $type->assets_count }}
                    </td>
                    <td class="">
                      @foreach ($type->categories as $category)
                      <span class="bg-light py-1 px-2 rounded-5 border border-primary font-12 fw-light">{{ $category->name }}</span>
                      <a href="{{ route('assets.categories.destroy', ['id' => $category->id]) }}" class="py-1 px-2 rounded-5 border border-danger text-danger font-12">Delete</a>
                      <a href="" class="py-1 px-2 rounded-5 border border-primary text-primary font-12">Edit</a>
                      <br /><br />
                      @endforeach
                    </td>
                    <td>
                      <div class="btn-group">
                        <button type="button" class="text-primary pl-3 font-12 mx-lg-1 border border-primary rounded-5 px-2 py-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span>Action</span>
                        </button>
                        <div class="dropdown-menu border border-dark rounded-3">
                          <a class="dropdown-item font-12 text-primary" href="#">Edit</a>
                          <a class="dropdown-item font-12 text-danger" href="{{ route('assets.types.destroy', ['id' => $type->id]) }}">Delete</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item font-12" href="{{ route('assets.types.items', ['id' => $type->id]) }}">View Items</a>
                          <a class="dropdown-item font-12" href="#">Export Items</a>
                        </div>
                      </div>
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="py-2 my-2">
          {{ $assetTypes->links() }}
        </div>
    @else
        
    @endif
  </div>
</div>

@endsection
