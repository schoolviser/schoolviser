@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Fixed Asset Settings')
@section('pageheaderDescription', 'Create Asset Types')

@section('pageheader-controls')

<div class="d-inline px-2">|</div>
<a class="font-12 font-weight-bold" href="{{ route('settings.asset.types.create') }}">Asset Type</a>

@endsection

@section('content')
<div class="row">

 <div class="col-lg-12">
   @if (session('created'))
       <div class="alert alert-success py-2 font-12 text-center" role="alert">
         {{session('created')}}
       </div>
   @endif
 </div>

 <div class="offset-lg-3 col-lg-6">
  <div class="card rounded-4">
   <form class="card-body row" action="{{route('settings.asset.types.store')}}" method="POST">
    @csrf

    <div class="col-lg-6">
     <label for="name" class="font-12 mb-1 text-muted">Name</label>
     <input type="text" name="name" placeholder="Asset Type" value="{{ old('name') }}" class="form-control name" id="name" />
     <small class="text-danger font-12">{{ $errors->first('name') }}</small>
    </div>

    <div class="col-lg-12">
     <label for="description" class="font-12 text-muted mb-1">Description</label>
     <textarea name="description" id="" cols="1" rows="1" class="form-control">{{ old('description') }}</textarea>
     <small class="text-danger font-12">{{ $errors->first('description') }}</small>
    </div>

    <div class="col-lg-6">
     <label for="assetAccount" class="font-12 mb-1 text-muted">Asset Account (Default Account)</label>
     <select name="asset_account" id="" class="form-control">
      <option value="">Choose Asset Account</option>
      @foreach ($assetAccounts as $account)
          <option value="{{ $account->id }}">{{ $account->name }}</option>
      @endforeach
     </select>
     <small class="text-danger font-12">{{ $errors->first('asset_account') }}</small>
    </div>

    <div class="col-lg-6">
     <label for="expenseAccount" class="font-12 mb-1 text-muted">Expense Account (Default Account)</label>
     <select name="expense_account" id="" class="form-control">
      <option value="">Choose Expense Account</option>
      @foreach ($expenseAccounts as $account)
          <option value="{{ $account->id }}">{{ $account->name }}</option>
      @endforeach
     </select>
     <small class="text-danger font-12">{{ $errors->first('asset_account') }}</small>
    </div>

    <div class="col-lg-6">
     <label for="usefulLife" class="font-12 mb-1 text-muted">Useful Life (Years)</label>
     <input type="text" name="useful_life" placeholder="Useful Life" value="{{ old('useful_life') }}" class="form-control useful-life" id="usefulLife" />
     <small class="text-danger font-12">{{ $errors->first('useful_life') }}</small>
    </div>

    <div class="col-lg-6">
     <label for="depreciationMethod" class="font-12 mb-1 text-muted">Depreciation Method</label>

     <select name="depreciation_method" class="form-control depreciation-method" id="depreciationMethod">
      <option value="">Choose Depreciation Method</option>
      <option value="slm">Straight Line Method</option>
      <option value="ddbm">Doouble Declining Method</option>
     </select>
     <small class="text-danger font-12">{{ $errors->first('depreciation_method') }}</small>
    </div>

    <div class="col-lg-6">
     <label for="expenseAccount" class="font-12 mb-1 text-muted">Depreciation Account</label>
     <select name="depreciation_account" id="" class="form-control">
      <option value="">Choose Depreciation Account</option>
      @foreach ($expenseAccounts as $account)
          <option value="{{ $account->id }}">{{ $account->name }}</option>
      @endforeach
     </select>
     <small class="text-danger font-12">{{ $errors->first('depreciation_account') }}</small>
    </div>

    <div class="col-lg-12 my-3">
     <button type="submit" class="btn btn-md btn-primary rounded-4 w-100">Save Asset Type</button>
    </div>

   </form>
  </div>
 </div>
</div>
@endsection
