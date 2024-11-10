<template>
 <div class="row">
   <!-- Revenue -->
   <div class="col-12 col-lg-4 mb-3">
      <div class="card rounded-3 border border-primary">
         <div class="card-body p-3 d-flex">
         <a class="" href="">
            <img :src="revenueIcon" class="w-50" alt=""/>
         </a>
         <div class="px-3">
         <small class="mb-0 mt-2 fw-light fs-5 bg-light px-3 rounded-5"><i>Revenue</i></small>
         <h1 class="mb-0 font-20 fw-bold">10000</h1>
         <small>
            Feb 2024 - Feb 2025
         </small>

         </div>
         </div>
      </div>
   </div>
   <!-- Expenses -->
   <div class="col-12 col-lg-4 mb-3">
      <div class="card rounded-3 border border-primary">
         <div class="card-body p-3 d-flex">
         <router-link :to="{ name : 'accounting.expenses' }">
            <img :src="expenseIcon" class="w-50" alt=""/>
         </router-link>
         <div class="px-3">
         <small class="mb-0 mt-2 fw-light fs-5 bg-light px-3 rounded-5"><i>Expenses</i></small>
         <small class="mb-0 mt-2 fw-light fs-5 bg-light px-3 rounded-5 mx-3">
            <a href=""  data-bs-toggle="modal" data-bs-target="#expenseSummaryModal">hello</a>
         </small>
         <h1 class="mb-0 font-20 fw-bold">100,100,200,000.00</h1>
         <small>
            Feb 2024 - Feb 2025
         </small>
         </div>
         </div>
      </div>
   </div>

 </div>

 <!-- Expense Summaries Modal -->
 <div
   class="modal fade"
   id="expenseSummaryModal"
   tabindex="-1"
   role="dialog"
   aria-labelledby="modalTitleId"
   aria-hidden="true"
 >
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="modalTitleId">
               Modal title
            </h5>
            <button
               type="button"
               class="btn-close"
               data-bs-dismiss="modal"
               aria-label="Close"
            ></button>
         </div>
         <div class="modal-body">
            <div class="container-fluid">Add rows here</div>
         </div>
         <div class="modal-footer">
            <button
               type="button"
               class="btn btn-secondary"
               data-bs-dismiss="modal"
            >
               Close
            </button>
            <button type="button" class="btn btn-primary">Save</button>
         </div>
      </div>
   </div>
 </div>
 
</template>
 
<script>
export default {
   name: 'Overview',

   data(){
      return {
         revenueIcon : document.querySelector("meta[name='base-url']").getAttribute('content') + '/images/bill.png',
         expenseIcon : document.querySelector("meta[name='base-url']").getAttribute('content') + '/images/expense.png',
         expenseSummaries : Array()
      }
   }

}
</script>