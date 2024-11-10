<template>
 <div
  class="modal fade"
  id="recordNewExpenseModal"
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
   <form class="modal-content" @submit.prevent="submit">
    <div class="modal-header">
     <h5 class="modal-title font-16 mb-0" id="modalTitleId">
      New Expense
     </h5>
     <button
      type="button"
      class="btn-close"
      data-bs-dismiss="modal"
      aria-label="Close"
     ></button>
    </div>
    <div class="modal-body row">

      <div class="col-lg-12">
        <small class="text-danger">{{ errors.message }}</small>
      </div>
     <div class="col-lg-6">
       <label for="date" class="font-12 text-muted">Expense Date</label>
       <input type="date" name="date" class="form-control mt-1" placeholder="Expense Date" v-model="form.date" />
       <small class="text-danger font-12">{{ errors.date }}</small>
     </div>

     <div class="col-lg-6">
      <label for="category" class="font-12 text-muted">Expense Category</label>
      <select name="category" id="category" class="form-select mt-1 form-control" v-model="form.category">
        <option value="1" selected>Choose Expense Category</option>
      </select>
      <small class="text-danger font-12">{{ errors.category }}</small>
    </div>

    <div class="col-lg-12">
      <label for="description" class="font-12 text-muted">Description (Comments)</label>
      <textarea name="description" id="" cols="5" rows="2" class="form-control mt-1" placeholder="Expense Description" v-model="form.description"></textarea>
      <small class="text-danger font-12">{{ errors.description }}</small>
    </div>

    <div class="col-lg-6">
      <label for="amount" class="font-12 text-muted">Grand Total (UGX)</label>
      <input type="text" name="amount"  class="form-control mt-1" v-model="form.amount" placeholder="Grand Total" />
      <small class="text-danger font-12">{{ errors.amount }}</small>
    </div>

    </div>
    <div class="modal-footer">
     <button type="submit" class="btn btn-md btn-primary rounded-4 w-100">Save</button>
    </div>
   </form>
  </div>
 </div>
 
 </template>
 
 <script>
import axios from 'axios';

 
 export default {
  name: 'RecordNewExpenseModal',

  data(){
   return {
    expenseCategories : Array(),
    form : {
     date : '',
     description : '',
     category : '',
     amount : '0.00'
    },
    errors : {
      message : '',
      date : '',
      category : '',
      amount : '',
      description : ''
    }
   }
  },

  methods : {
   async submit(){
    await axios.post('/accounting/expenses/record/store', this.form).then((response) => {
     alert(response.data.message);
    }).catch((error) => {
      console.log(error.response)
      if(error.response.status == 422){
        this.errors.message = error.response.data.message;
        this.errors.date = error.response.data.errors.date[0];
        this.errors.category = error.response.data.errors.category[0];
      }
    });
   }
  }
 
 }
 </script>