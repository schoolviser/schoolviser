@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Accounting Settings')

@section('pageheaderDescription', 'Your Accounting Settings')

@section('pageheader-controls')
@endsection

@section('content')

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <form class="card-body">
        <div class="form-check">
          <input id="my-input" class="form-check-input mt-2" type="checkbox" name="" value="true" {{ (option('use_expense_accounts_as_expense_categories', 0)) ? 'checked' : '' }}>
          <label for="my-input" class="form-check-label font-14 text-muted">Use expense accounts as expense categories. <br /><small class="text-muted font-12">This will be used during creation of expenses.</small></label>
        </div>
        <hr />
      </form>
    </div>
  </div>
</div>

@endsection
