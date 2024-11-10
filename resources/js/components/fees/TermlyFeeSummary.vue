<!--Website Root Component-->
<template>
<div class="row mb-2">

 <!-- Expected Fees-->
<div class="col-sm-6 col-lg-4 mb-2">
  <div class="card border-success rounded">
    <div class="card-body py-3">
      <div>
        <h6 class="text-muted text-uppercase font-12 fst-italic">Expected Fees</h6>
      </div>
      <h5 class="text-success fw-bold mb-1"><small class="font-10">UGX </small> 
        <a href="" class="text-success">{{ expectedFees }}</a>
      </h5>
      <small class="px-2 py-1 bg-warning font-10 fw-bold fst-italic rounded-5">ff</small>

    </div>
  </div>
</div>

<div class="col-sm-6 col-lg-4">
  <div class="card border-danger rounded">
    <div class="card-body py-3">
      <div>
        <h6 class="text-muted text-uppercase font-12">Previous Balances</h6>
      </div>
      <h5 class="fw-bold mb-1"><small class="font-10 text-success">UGX</small> {{ previousBalance }}</h5>
      <small class="px-2 py-1 bg-warning font-10 fst-italic rounded-5">
        <a href="" class="text-dark">Balances Carried Forword</a>
      </small>
      <small class="px-2 py-1 bg-warning font-10 fst-italic rounded-5 mx-1">
        <a href="" class="text-dark">This is a liability</a>
      </small>

    </div>
  </div>
</div>



<div class="col-sm-6 col-lg-4">
  <div class="card border-primary rounded">
    <div class="card-body py-3">
      <div>
        <h6 class="text-muted text-uppercase font-12">Collected Fees</h6>
      </div>
      <h5 class="text-success fw-bold mb-1"><small class="font-10">UGX</small> {{ collectedFees }}</h5>
      <small class="px-2 py-1 text-dark bg-warning font-10 fst-italic rounded-5">
        <a href="" class="text-dark">Transactions</a>
      </small>
    </div>
  </div>
</div>

<div class="col-sm-6 col-lg-4">
  <div class="card border-primary rounded">
    <div class="card-body py-3">
      <div>
        <h6 class="text-muted text-uppercase font-12">Discounts</h6>
      </div>
      <h5 class="text-success fw-bold mb-1"><small class="font-10">UGX</small> {{ feesDiscounts }}</h5>
      <small class="px-2 py-1 text-dark bg-warning font-10 fst-italic rounded-5">
        <a href="" class="text-dark">Transactions</a>
      </small>
    </div>
  </div>
</div>





</div>
</template>

<script>
import axios from 'axios';


export default {
   name: 'TermlyFeeSummary',
   data(){
    return {
      expectedFees : 0,
      collectedFees : 0,
      previousBalance : 0,
      feesDiscounts : 0
    }
   },

   mounted(){
      this.getTermlyFeeSummary();
   },

   methods : {
    async getTermlyFeeSummary(){
      await axios.get('/fees/summary').then((response) => {
        this.expectedFees = response.data.expectedFees;
        this.collectedFees = response.data.collectedFees;
        this.previousBalance = response.data.previousBalance;
        this.feesDiscounts = response.data.feesDiscounts;
        console.log(response);
      })

      await axios.get('/images/logo.svg').then((response) => {
        console.log(response.data);
      });
    }
   }
}
</script>