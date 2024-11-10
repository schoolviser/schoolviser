<!-- AddFineFeeModal //adds a fee fine to specific student registration -->

<div  class="modal fade" id="addFineFeeModal" tabindex="-1" data-bs-backdrop="static" -bs-keyboard="false"  role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable  modal-sm" role="document">
    <form class="modal-content" action="{{ route('fees.individualfee.store', ['termly_registration_id' => $registration->id]) }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title font-16" id="modalTitleId">
          Add Fine Fee
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body row">
        <div class="col-lg-2">
          <img src="{{ asset($registration->student->photo) }}" alt="" class="img-fluid rounded-circle p-0">
        </div>
        <div class="col-lg-10 ">
          <h6 class="mb-0">{{ $registration->student->first_name.' '.$registration->student->last_name }}</h6>
          <div class="font-12 text-muted">
            <small class="text-capitalize">{{ $registration->student->gender }}</small>
            <span>|</span>
            <small>{{ $registration->clazz->name }}</small>
            <span>|</span>
            <small class="text-capitalize">{{ $registration->residence }}</small>
          </div>
        </div>
        <div class="col-lg-12 mt-3">
          <input type="text" name="amount" class="form-control" value="{{old('amount')}}" data-bs-type="currency" placeholder="Amount" />
          <small class="text-danger">{{ $errors->first('amount') }}</small>
        </div>
        <div class="col-lg-12 mt-3">
          <textarea name="reason" id="" cols="4" rows="2" class="form-control" placeholder="Reason"></textarea>
          <small class="text-danger">{{ $errors->first('reason') }}</small>
        </div>
        <input type="hidden" name="type" value="fine" />
        @inject('fineCategories', 'App\Models\Fee\IndividualFeeCategory')
        @php
            $fines = $fineCategories::fines()->get();
        @endphp
        <div class="col-lg-12 mt-3">
          <select name="category" id="" class="form-control">
            <option value="">Select Category</option>
            @foreach ($fines as $fine)
                <option value="{{$fine->id}}">{{ $fine->name }}</option>
            @endforeach
          </select>
          <small class="text-danger">{{ $errors->first('reason') }}</small>
        </div>
      
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>
