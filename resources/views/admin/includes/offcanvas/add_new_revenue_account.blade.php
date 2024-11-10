<div class="offcanvas offcanvas-end w-25 rounded-start-4" tabindex="-1" id="newRevenueAccountOffcanvas">
 <div class="offcanvas-header border-bottom">
     <h5 class="offcanvas-title text-uppercase font-12 fw-bold text-primar" id="">
         Create New Revenue Account
     </h5>
     <button
         type="button"
         class="btn-close font-12"
         data-bs-dismiss="offcanvas"
         aria-label="Close"
     ></button>
 </div>
 <form class="offcanvas-body" action="{{ route('accounting.coas.revenue.store') }}" method="POST">
     @csrf
     <div class="row">
         <div class="col-lg-12 mb-1">
             <input type="text" class="form-control" name="code" placeholder="Account Unique Code" />
             <small class="text-danger">{{ $errors->first('code') }}</small>
         </div>
         <div class="col-lg-12 mb-1">
             <input type="text" class="form-control" name="name" placeholder="Account Name" />
             <small class="text-danger">{{ $errors->first('name') }}</small>
         </div>
         <div class="col-lg-12 mb-1">
             <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
             <small class="text-danger">{{ $errors->first('description') }}</small>
         </div>
         <div class="col-lg-12 mb-1">
             <select name="parent" id="" class="form-control">
                 <option value="">Choose Parent Account</option>
                 @foreach ($revenueAccounts as $revenue)
                     <option value="{{ $revenue->id }}">{{ $revenue->name }}</option>
                 @endforeach
             </select>
             <small class="text-danger">{{ $errors->first('description') }}</small>
         </div>
         <div class="col-lg12">
             <button type="submit" class="btn btn-primary w-100 rounded-4 btn-md">Save</button>
         </div>
     </div>
 </form>
</div>