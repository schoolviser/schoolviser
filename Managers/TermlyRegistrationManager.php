<?php

namespace App\Managers;

use App\Models\TermlyRegistration;

use App\Support\Models\Any;
use App\Models\Fee\PreviousBalance;


class TermlyRegistrationManager
{
   public $termlyRegistration;

   public function __construct(TermlyRegistration $termlyRegistration) 
   {
      $this->termlyRegistration = $termlyRegistration;
   }

   public function setRegistration($registration)
   {
      $this->termlyRegistration = $registration;
      return $this;
   }

   public function previousRegistrations()
   {
      $registration = $this->termlyRegistration;

      return TermlyRegistration::whereHas('student', function($studentQuery) use($registration){
       $studentQuery->whereId($registration->student_id);
      })->whereHas('term', function($termQuery) use($registration){
         $termQuery->where('start_date', '<', $registration->term->start_date);
      })->with(['fees', 'feeDiscounts', 'individualFees', 'payments', 'previousBalance', 'startPreviousBalance'])->get();
   }

   public function previousTermlyRegistrationFeeSummaries()
   {
      $previousRegistrations = $this->previousRegistrations();

      return (count($previousRegistrations)) ? collect($previousRegistrations)->map(function($registration, $key){
         //calculate the discounts
         $fees = $registration->fees;
         $discounts = collect($registration->feeDiscounts)->map(function($discountItem, $discountKey) use($fees){
               $theFeeDiscount = 0;
               foreach ($fees as $fee) {
                  if ($fee->fee_category_id == $discountItem->fee_category_id) {
                     $theFeeDiscount = ($discountItem->percentage) ? ($discountItem->percentage/100) * $fee->amount : $discountItem->amount;
                  }
               }
               return new Any(['amount' => $theFeeDiscount]);
         });

         $payments = $registration->payments->sum('amount');
         $individualFees = $registration->individualFees->sum('amount');
         $termlyFees = ($registration->startPreviousBalance) ? ($registration->fees->sum('amount') + $registration->startPreviousBalance->amount + $individualFees) : ($registration->fees->sum('amount') + $individualFees);

         return new Any([
            'registration' => new Any([
               'id' => $registration->id
            ]),
            'feeDiscounts' => $discounts->sum('amount'),
            'fees' => $registration->fees->sum('amount'),
            'payments' => $payments,
            'individualFees' => $individualFees,
            'amountPayable' => ($termlyFees - $payments)
         ]);


      }) : [];
   }

   public function populatePreviousFeeBalance() : void
   {
      $previousTermlyRegistrationFeeSummaries = $this->previousTermlyRegistrationFeeSummaries();

      if (count($previousTermlyRegistrationFeeSummaries)) {
       # code...
       foreach ($previousTermlyRegistrationFeeSummaries as $summary) {
         # code...
         ($summary->amountPayable > 0) ? PreviousBalance::updateOrCreate(['termly_registration_id' => $this->termlyRegistration->id], [
            'amount' => $summary->amountPayable,
            'type' => 'termly'
         ]) : '';

         ($summary->amountPayable < 0) ? PreviousBalance::updateOrCreate(['termly_registration_id' => $this->termlyRegistration->id], [
            'amount' => $summary->amountPayable,
            'type' => 'termly'
         ]) : '';
        
       }
      }

     
   }

}