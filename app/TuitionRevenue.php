<?php

namespace App;

use Illuminate\Support\Collection;

use App\Models\Accounting\Coa\Revenue;
use App\Models\Fee\TermlyRegistrationFee;
use App\Models\Fee\Fee;
use App\Models\Fee\FeeDiscount;
use App\Models\Accounting\TermlyAccrualRevenue;
use App\Models\TermlyRegistration;
use App\Support\Models\Any;


class TuitionRevenue
{

    /**
     * Whether to termly or accounting period
     *
     * @var array
     */
    protected $termly = true;

    /**
     * 
     */
    protected $term;


    /**
     * Determine wheather termly or per accounting period.
     *
     * @param string $term_id
     * @return  this
     */
    public function termly($term_id = null)
    {
        $this->termly = true;
        $this->term = ($term_id) ? term($term_id) : term();
        return $this;
    }


    /**
     * TPopulate revenue
*
     * @return array
     */
    public function populate()
    {
        $total = $this->getRevenue();

        if($this->account()){
            if ($this->termly) {
                ($this->term) ? TermlyAccrualRevenue::updateOrCreate(['term_id' => $this->term->id, 'account_id' => $this->account()->id],['amount' => $total, 'term_id' => $this->term->id, 'account_id' => $this->account()->id]) : '';
            } else {
                # code...
            }
            
        }
        return $this;
    }

    /**
     * Get the revenue account for tuition
     */
    public function account()
    {
        return Revenue::tuition()->firstOrCreate(['tuition' => 1],['name' => 'Tuition', 'tuition' => 1]);
    }

    /**
     * 
     */
    private function getRegistrations() : Collection
    {
        if($this->termly){
            return ($this->term) ? TermlyRegistration::ofTerm($this->term->id)->whereHas('feeDiscounts')->with(['feeDiscounts','fees'])->get() : TermlyRegistration::current()->whereHas('feeDiscounts')->with(['feeDiscounts','fees'])->get();
        }
        return TermlyRegistration::whereHas('feeDiscounts')->with(['feeDiscounts','fees'])->get();
    }

    public function getTuition() : Collection
    {
        if($this->termly){
            return ($this->term) ? Fee::ofTerm($this->term->id)->whereHas('students')->withCount(['students'])->with(['category'])->get() : Fee::current()->whereHas('students')->withCount(['students'])->with(['category'])->get();
        }
        return Fee::whereHas('students')->withCount(['students'])->with(['category'])->get();
    }

    public function getDiscounts() : Collection
    {
        return $this->getRegistrations()->map(function($item, $key){
            $fees = $item->fees;
            $discounts = collect($item->feeDiscounts)->map(function($discountItem, $discountKey) use($fees){
                $theFeeDiscount = 0;
                foreach ($fees as $fee) {
                    if ($fee->fee_category_id == $discountItem->fee_category_id) {
                        $theFeeDiscount = ($discountItem->percentage) ? ($discountItem->percentage/100) * $fee->amount : $discountItem->amount;
                    }
                }
                return new Any(['amount' => $theFeeDiscount]);
            });

            return new Any(['amount' => $discounts->sum('amount')]);

        });
    }

    public function getRevenue()
    {
        $revenue = $this->getTuition()->map(function($item, $key){

            return new Any([
                'id' => $item->id,
                'amount' => ($item->amount * $item->students_count),
                'students' => $item->students_count,
                'category' => $item->category->name,
            ]);
        });

        return ($revenue->sum('amount') - $this->getDiscounts()->sum('amount'));
    }
    
}
