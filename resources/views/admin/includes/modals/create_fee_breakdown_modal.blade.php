<div id="createFeeBreakdownModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <form class="modal-content" action="{{ route('fees.breakdown.store', ['term_id' => $term->id]) }}" method="POST">
     @csrf
     <div class="modal-header">
       <h5 class="modal-title" id="my-modal-title">Create Fee Particular</h5>
     </div>
     <div class="modal-body row">
       <div class="col-lg-6">
         <label for="year" class="text-small text-muted">Year</label>
         <input type="text" name="year" class="form-control" value="{{ term()->year }}" readonly />
       </div>
       <div class="col-lg-6">
         <label for="term" class="text-muted text-small">Term</label>
         <input type="text" name="term" class="form-control" value="{{ term()->term }}" readonly />
       </div>

       <div class="col-lg-6">
         @inject('feesCategories', '\App\Models\Fee\FeeCategory')
         <label for="term" class="text-muted text-small">Fee</label>
         <select name="fee_category_id" id="" class="form-control">
           @foreach ($feesCategories->all() as $category)
             <option value="{{ $category->id }}">{{ $category->name }}</option>
           @endforeach
         </select>
       </div>

       <div class="col-lg-6">
         <label for="amount" class="text-muted text-small">Amount</label>
         <input type="text" name="amount" class="form-control" data-bs-type="currency" value="{{ old('amount') }}" />
       </div>
       
       <div class="col-lg-6">
         <label for="residence" class="text-small text-muted">Residence</label>
         <select name="residence" id="" class="form-control">
           <option value="boarding">Boarding</option>
           <option value="day">Day</option>
         </select>
       </div>

       <div class="col-lg-6">
         <label for="new_or_continuing" class="text-small text-muted">Entry Status</label>
         <select name="new_or_continuing" id="" class="form-control">
           <option value="new">New</option>
           <option value="continuing">Continuing</option>
         </select>
       </div>

       <div class="col-lg-6">
         <label for="gender" class="text-small text-muted">Gender</label>
         <select name="gender" id="" class="form-control">
           <option value="male">Male</option>
           <option value="female">Female</option>
         </select>
       </div>

       <div class="col-lg-6">
         <label for="class" class="text-muted text-small">Class</label>
         <select class="form-control" name="clazz_id">
           @foreach (clazzs() as $clazz)
               <option value="{{ $clazz->id }}">{{ $clazz->name }}</option>
           @endforeach
         </select>
       </div>




     </div>
     <div class="modal-footer">
       <button type="submit" class="btn btn-sm btn-primary">Create</button>
     </div>
   </form>
 </div>
</div>
