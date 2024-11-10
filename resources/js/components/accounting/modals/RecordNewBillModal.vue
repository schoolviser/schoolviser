<template>
 <div class="modal fade" id="recordNewBillModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
   <form class="modal-content">
    <div class="modal-header">
     <h5 class="modal-title font-12 fw-bold" id="modalTitleId">New Bill</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body row">
     <div class="col-lg-12">
      <div class="row">

       <div class="col-md-6 col-lg-6">
        <label for="amount" class="text-muted font-12 mb-1">Vendor</label>
        <select name="vendor" id="" class="form-control">
         <option value="">Choose Vendor</option>
         <option value="" v-for="(vendor, index) in vendors" :key="vendor.id">{{ vendor.name }}</option>
        </select>
       </div>

       <div class="col-md-6 col-lg-6">
        <label for="amount" class="text-muted font-12 mb-1">Reference</label>
        <input type="text" name="reference" class="form-control" placeholder="Reference" />
       </div>
      
       <div class="col-md-6 col-lg-6">
        <label for="amount" class="text-muted font-12 mb-1">Due Date</label>
        <input type="date" name="amount" class="form-control" placeholder="Due Date" />
       </div>

       <div class="col-md-6 col-lg-6">
        <label for="amount" class="text-muted font-12 mb-1">Amount</label>
        <input type="text" name="amount" class="form-control" placeholder="Enter Amount Payable" />
       </div>

       <div class="col-md-12">
        <label for="amount" class="text-muted font-12 mb-1">Description</label>
        <textarea name="description" id="" cols="30" rows="2" class="form-control"></textarea>
       </div>

       <div class="col-lg-12 my-3">
         <div class="table-responsive">
          <table class="table table-hover table-striped table-bordered">
            <thead>
              <th></th>
              <th>Item/Description</th>
              <th>Quantity</th>
              <th></th>
            </thead>
            <tbody>
              <tr v-for="(item, index) in items" :key="index">
                <td>{{index + 1}}</td>
                <td><input type="text" name="items[index][name]" class="form-control mt-1" value="" placeholder="Description" /></td>
                <td><input type="text" name="items[index][quantity]" class="form-control mt-1" value="" placeholder="Quantity" /></td>
                <td><input type="text" name="items[index][rate]" class="form-control mt-1" value="" placeholder="Rate" /></td>
                <td>
                  <a href="" @click.prevent="removeItem(index)">Delete</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="mt-2 font-12">
         <a href="" @click.prevent="addItem()">Add Line</a>
        </div>
       </div>

      </div>
     </div>
    </div>
    <div class="modal-footer">
     <button type="button" class="btn btn-primary rounded-4 w-100">Save</button>
    </div>
   </form>
  </div>
 </div>
 </template>

<script>
import axios from 'axios';

export default {
   name: 'AddBillModalForm',

   data(){
    return {
     vendors : Array(),
     items : [0,2,3,4]
    }
   },

   created(){
    this.getVendors();
   },

   methods : {
    async getVendors(){
     await axios.get('/accounting/vendors/all-without-relations', {responseType : 'json'}).then((response) => {
      this.vendors = response.data;
     })
    },

    addItem(){
      this.items.push(1);
    },
    removeItem(index) {
      let v = this.items.splice(index, 1);
      console.log(v);
    },
   }
   
}
</script>
