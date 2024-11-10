@extends(config('schoolviser.admin_layout', 'admin.layouts.master'))


@section('title', 'Vendors')

@section('pageheader', 'Vendors')
@section('pageheaderDescription', 'Manage Vendor Information')

@section('pageheader-controls')
<a href="" class="px-2 py-1 rounded-4  font-12 border border-primary text-primary" data-bs-toggle="offcanvas" data-bs-target="#Id2">Add New Vendor</a>
@endsection

    
@section('content')

<div class="row mt-4">


  <form class="col-lg-12">
    
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead>
          <th>
            <input class="form-check-input" type="checkbox" name="" id="checkAll">
          </th>
          <th>ID</th>
          <th>Compacy Name</th>
          <th>Email</th>
          <th>Outstanding Bills</th>
          <th></th>
        </thead>
        <tbody>
          @foreach ($vendors as $vendor)
          <tr class="">
            <td class="">
              <input id="{{ 'check'.$vendor->id }}" class="form-check-input" type="checkbox" name="vendors[]" value="{{ $vendor->id }}" />
            </td>
            <td>{{ $loop->index + 1 }}</td>
            <td>
              <span>{{ $vendor->name }}</span><br />
              <a href="{{ route('accounting.vendors.show', ['id' => $vendor->id]) }}" class="font-10 fst-italic">{{ $vendor->first_name.' '.$vendor->last_name }}</a>
            </td>
            <td>{{ $vendor->email }}</td>
            <td> UGX {{ number_format(20000000, 2) }}</td>
            <td>
              <a href="" class="btn btn-primary btn-sm px-2 rounded-4 font-10">Add Bill</a>
              <a href="" class="btn btn-danger btn-sm px-2 rounded-4 font-10" data-bs-toggle="modal" data-bs-target="{{ '#confirmVendorDeletionModal'.$vendor->id }}">Delete</a>
              
              <div
                class="modal fade"
                id="{{'confirmVendorDeletionModal'.$vendor->id}}"
                tabindex="-1"
                data-bs-backdrop="static"
                data-bs-keyboard="false"
                
                role="dialog"
                aria-labelledby="modalTitleId"
                aria-hidden="true"
              >
                <div
                  class="modal-dialog modal-dialog-scrollable modal-md"
                  role="document"
                >
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title font-12" id="modalTitleId">
                        Confirm Vendor Deletion
                      </h5>
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                      ></button>
                    </div>
                    <div class="modal-body">
                      <span>Are you sure you wnat to delete {{ $vendor->name }}</span><br />
                      <span>The bills asociated with this vendor will be delete too</span>
                    </div>
                    <div class="modal-footer">
                      <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                      >
                        Close
                      </button>
                      <a href="{{ route('accounting.vendors.delete', ['id' => $vendor->id]) }}" class="btn btn-danger px-2 rounded-4">Delete Vendor</a>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Optional: Place to the bottom of scripts -->
              <script>
                const myModal = new bootstrap.Modal(
                  document.getElementById("modalId"),
                  options,
                );
              </script>
              
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    
  </form>

  <div class="col-lg-4">
    <div class="p-3">
      <span class="text-muted fst-italic">Total Outstanding Bills</span>
      <h2 class="fw-bold pt-lg-2" style="text-decoration: underline;"><small>UGX </small>{{ number_format(30000, 2) }}</h2>
    </div>
  </div>
  

  
</div>
@endsection
