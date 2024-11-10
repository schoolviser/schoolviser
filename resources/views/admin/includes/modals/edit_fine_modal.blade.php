
<!-- Modal Body -->
<div
 class="modal fade"
 id="{{'editFineModal'.$fine->id}}"
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
  <form class="modal-content" method="POST" action="{{ route('fees.individualfee.update', ['id' => $fine->id]) }}">
   @csrf
   <div class="modal-header">
    <h5 class="modal-title" id="modalTitleId">
     Update Fine
    </h5>
    <button
     type="button"
     class="btn-close"
     data-bs-dismiss="modal"
     aria-label="Close"
    ></button>
   </div>
   <div class="modal-body row">
    
    <div class="col-lg-12 mt-3">
      <input type="text" name="amount" class="form-control" value="{{number_format((old('amount') ?? $fine->amount), 2)}}" data-bs-type="currency" placeholder="Amount" />
      <small class="text-danger">{{ $errors->first('amount') }}</small>
    </div>
    <div class="col-lg-12 mt-3">
      <textarea name="reason" id="" cols="4" rows="2" class="form-control" placeholder="Reason">{{ old('reason') ?? $fine->reason }}</textarea>
      <small class="text-danger">{{ $errors->first('reason') }}</small>
    </div>
    <input type="hidden" name="type" value="fine" />
    <!-- Get Fine Categories -->
    @inject('fineCategories', 'App\Models\Fee\IndividualFeeCategory')
    @php
        $fineCategories = $fineCategories::fines()->get();
    @endphp
    <div class="col-lg-12 mt-3">
      <select name="category" id="" class="form-control">
        <option value="">Select Category</option>
        @foreach ($fineCategories as $fineCategory)
            <option value="{{$fineCategory->id}}" {{ ($fine->individual_fee_category_id == $fineCategory->id) ? 'selected' : '' }}>{{ $fineCategory->name }}</option>
        @endforeach
      </select>
      <small class="text-danger">{{ $errors->first('reason') }}</small>
    </div>
  
  </div>
   <div class="modal-footer">
    <button
     type="button"
     class="btn btn-secondary"
     data-bs-dismiss="modal"
    >
     Close
    </button>
    <button type="submit" class="btn btn-primary">Update</button>
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
