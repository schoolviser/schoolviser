@extends(config('schoolviser.admin_layout'))

@section('title', 'Settings | Classes')

@section('module-page-heading', 'Update Clazz Details')
@section('pageheaderDescription', 'Manage your classes')

@section('module-links')

@endsection

@section('requiredJs')

@endsection
    
@section('content')

<form action="{{route('settings.clazzs.update', ['id' => $clazz->id])}}" method="POST" class="row">
  @csrf

  <div class="col-lg-4">
    <label for="">Class</label>
    <input type="text" class="form-control mb-2" value="{{ old('name') ?? $clazz->name }}" name="name" placeholder="Class Name" />
  </div>

  <div class="col-lg-4">
    <label for="">Abbr</label>
    <input type="text" class="form-control mb-2" value="{{ old('abbr') ?? $clazz->abbr }}" name="abbr" placeholder="Class Short Name" />
  </div>

  <div class="col-lg-4">
    <label for="">Level</label>
    <select name="level" id="" class="form-control">
      <option value="ordinary" {{ ($clazz->level == 'ordinary') ? 'selected' : '' }}>{{ (config('schoolviser.type') == 'primary') ? 'Lower Class' : 'Ordinary' }}</option>
      <option value="advanced" {{ ($clazz->level == 'advanced') ? 'selected' : '' }}>{{ (config('schoolviser.type') == 'primary') ? 'Upper CLass' : 'Advanced' }}</option>
    </select>
  </div>

  <button class="w-100 btn btn-primary btn-md rounded-5 my-3" type="submit">Update</button>

</form>

@endsection


