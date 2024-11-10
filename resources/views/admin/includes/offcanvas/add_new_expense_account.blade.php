<div class="offcanvas offcanvas-end rounded-start-4" tabindex="-1" id="newExpenseAccountOffcanvas">
 <div class="offcanvas-header border-bottom">
     <h4 class="offcanvas-title  fw-bold text-capitalize" id="">
         add New Expense Account
     </h4>
     <button
         type="button"
         class="btn-close"
         data-bs-dismiss="offcanvas"
         aria-label="Close"
     ></button>
 </div>
 <form class="offcanvas-body" action="{{ route('accounting.coas.expenses.store') }}" method="POST">
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
                 @foreach ($expenseAccounts as $expense)
                     <option value="{{ $expense->id }}">{{ $expense->name }}</option>
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