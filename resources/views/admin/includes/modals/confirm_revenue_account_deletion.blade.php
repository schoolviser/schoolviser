<div
 class="modal fade"
 id="{{ 'deleteRevenueAccountModal'.$revenue->id }}"
 tabindex="-1"
 data-bs-backdrop="static"
 data-bs-keyboard="false"
 
 role="dialog"
 aria-labelledby="modalTitleId"
 aria-hidden="true"
>
 <div
  class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
  role="document"
 >
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title mb-0" id="modalTitleId">
     Confirm You Action
    </h5>
    <button
     type="button"
     class="btn-close"
     data-bs-dismiss="modal"
     aria-label="Close"
    ></button>
   </div>
   <div class="modal-body">
    Are you sure you want to delete revenue account {{ $revenue->name }}
   </div>
   <div class="modal-footer">
    <button
     type="button"
     class="btn btn-secondary"
     data-bs-dismiss="modal"
    >
     Close
    </button>
    <a href="{{ route('accounting.revenue.delete', ['id' => $revenue->id]) }}" class="btn btn-primary">Delete</a>
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
