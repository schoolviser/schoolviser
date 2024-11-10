<template>
<div class="row">
   <div class="col-lg-12">
      <div class="table-responsive">
      <table class="table table-stripped table-hover table-bordered">
        <thead>
          <tr>
            <th>SN</th>
            <th>From (Vendor)</th>
            <th>Status</th>
            <th>Reference</th>
            <th>Date</th>
            <th>Due Date</th>
            <th>Paid</th>
            <th>Due</th>
            <th>...</th>
          </tr>
        </thead>
        <tbody id="">
          <tr v-for="(bill, index) in bills" :key="bill.id">
            <td>{{index + 1}}</td>
            <td>{{bill.vendor}}</td>
            <td>{{bill.status}}</td>
            <td>{{bill.reference}}</td>
            <td>{{bill.date}}</td>
            <td>{{bill.due_date}}</td>
            <td>
               <a href="" class="font-12 py-1 px-2 bg-white mx-1 text-danger border border-danger rounded-4">Delete</a>
               <a href="" class="font-12 py-1 px-2 bg-white mx-1 text-success border border-success rounded-4">Edit</a>
            </td>
         </tr>
        </tbody>
      </table>
    </div>
   </div>
</div>

<AddBillModalForm />
</template>

<script>

export default {
   name: 'Bills',

   data(){
      return {
         bills : Array()
      }
   },

   created(){
      this.getBills();
   },

   methods : {
      async getBills(){
         await axios.get('/accounting/bills', {responseType : 'json'}).then((response) => {
            console.log(response.data);
            this.bills = response.data.bills;
         })
      }
   }

}
</script>