<div
 class="modal fade"
 id="{{ 'withdrawMoneyToBankModal'.$bank->id }}"
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
  <form class="modal-content" method="POST" action="{{ route('accounting.banks.withdrawals.withdraw', ['bank_id' => $bank->id]) }}">
   @csrf
   <div class="modal-header">
    <h5 class="modal-title" id="modalTitleId">
     {{ 'Withdraw Money From '.$bank->name }}
    </h5>
    <a
     class="btn-close"
     data-bs-dismiss="modal"
     aria-label="Close"
    ></a>
   </div>
   <div class="modal-body row">
    <div class="col-lg-12 mb-1">
     <input type="date" name="date" class="form-control" placeholder="Date" />
     <small class="text-danger">{{ $errors->first('date') }}</small>
    </div>
    <div class="col-lg-12 mb-1">
     <input type="text" class="form-control" name="amount" placeholder="Amount (Ushs)" data-bs-type="currency" />
     <small class="text-danger">{{ $errors->first('amount') }}</small>
    </div>
    <div class="col-lg-12 mb-1">
     <input type="text" name="transaction_id" placeholder="Reference Code" class="form-control">
     <small class="text-danger">{{ $errors->first('transaction_id') }}</small>
    </div>
   </div>
   <div class="modal-footer">
    <button
     type="button"
     class="btn btn-secondary btn-sm"
     data-bs-dismiss="modal"
    >
     Close
    </button>
    <button type="submit" class="btn btn-primary btn-sm">Add</button>
   </div>
  </form>
 </div>
</div>

<!-- Optional: Place to the bottom of scripts -->
<script>
 const myModal = new bootstrap.Modal(
  document.getElementById("modalId"),
  options,
 );
</script>