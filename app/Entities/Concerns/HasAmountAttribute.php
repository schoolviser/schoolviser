<?php

namespace App\Entities\Concerns;

use Illuminate\Database\Eloquent\Model;

trait HasAmountAttribute
{
 
 public function setAmountAttribute($value)
 {
     $this->attributes['amount'] = str_replace(',', '', $value);
 }

 public function getAmountAttribute($value)
 {
     return  str_replace(',', '', $this->attributes['amount']);
 }

 public function setRateAttribute($value)
 {
     $this->attributes['rate'] = str_replace(',', '', $value);
 }

 public function getRateAttribute($value)
 {
     return  str_replace(',', '', $this->attributes['rate']);
 }

}