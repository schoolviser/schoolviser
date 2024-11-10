<?php

use Illuminate\Database\Seeder;

use App\Models\Fee\FeeCategory;
use App\Models\Fee\Fee;
use App\Models\Fee\FeePaymentChannel;
use App\MOdels\Fee\IndividualFeeCategory;
use App\MOdels\Fee\IndividualFee;
use App\Models\TermlyRegistration;

use App\Models\Term;
use App\Models\Clazz;

use App\Models\Coa\Revenue;

class FeeSeeder extends Seeder
{
    protected $previousTerm;
    protected $currentTerm;
    protected $clazzs;

    protected $revenue_account;

    public function __construct()
    {
        $this->revenue_account = Revenue::firstOrCreate(['name' => 'tution']);

        $this->previousTerm = Term::previous()->first();
        $this->currentTerm = Term::current()->first();

        $this->clazzs = Clazz::all();

       
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Fee Payment Channels
        FeePaymentChannel::updateOrCreate([
            'name' => 'MTN_UG'
        ]);
        FeePaymentChannel::updateOrCreate([
            'name' => 'AIRTEL_MONEY'
        ]);
        FeePaymentChannel::updateOrCreate([
            'name' => 'FINANCE TRUST'
        ]);
        FeePaymentChannel::updateOrCreate([
            'name' => 'SCHOOL_PAY - MTN_UG'
        ]);
        FeePaymentChannel::updateOrCreate([
            'name' => 'SCHOOL_PAY - AIRTEL_MONEY_UG'
        ]);

        $this->sameFee();

       //$this->one();
        //$this->two();
        //$this->three();
        //$this->four();
        //$this->five();
        //$this->six();

        //$this->newOne();

        IndividualFeeCategory::updateOrCreate(['name' => 'Computer Lab Fine'], [
            'name' => 'Computer Lab Fine'
        ]);

    }

    //S.1 Fees for current and previous term
    protected function one()
    {

        $fee_categories = ['Tuition', 'Medical Fee'];
        $fees = ['300000','20000'];

        for ($i=0; $i < count($fee_categories); $i++) {

            $category = FeeCategory::firstOrCreate(['name' => $fee_categories[$i]],['name' => $fee_categories[$i]]);
            
            
            //S.1 Boys Boarding -> previous Term
            if ($this->previousTerm) {
                # code...
                Fee::create([
                    'term_id' => $this->previousTerm->id,
                    'amount' => $fees[$i],
                    'residence' => 'boarding',
                    'gender' => 'male',
                    'clazz_id' => 1,
                    'new_or_continuing' => 'continuing',
                    'fee_category_id' => $category->id,
                    'account_id' => $this->revenue_account->id
                ]);
            }

            //S.1 Boys Boarding -> current Term
            if ($this->currentTerm) {
                # code...
                Fee::create([
                    'term_id' => $this->currentTerm->id,
                    'amount' => $fees[$i],
                    'residence' => 'boarding',
                    'gender' => 'male',
                    'clazz_id' => 1,
                    'new_or_continuing' => 'continuing',
                    'fee_category_id' => $category->id,
                    'account_id' => $this->revenue_account->id
                ]);
            }
           
        }

    }

    protected function two()
    {

        $fee_categories = ['Tuition', 'Medical Fee'];
        $fees2 = ['350000','20000'];

        
        for ($i=0; $i < count($fee_categories); $i++) {

            $category = FeeCategory::firstOrCreate(['name' => $fee_categories[$i]],['name' => $fee_categories[$i]]);
            
            
            //S.1 Boys Boarding -> previous Term
            if ($this->previousTerm) {
                # code...
                Fee::create([
                    'term_id' => $this->previousTerm->id,
                    'amount' => $fees2[$i],
                    'residence' => 'boarding',
                    'gender' => 'male',
                    'clazz_id' => 2,
                    'new_or_continuing' => 'continuing',
                    'fee_category_id' => $category->id,
                    'account_id' => $this->revenue_account->id
                ]);
            }

            //S.1 Boys Boarding -> current Term
            if ($this->currentTerm) {
                # code...
                Fee::create([
                    'term_id' => $this->currentTerm->id,
                    'amount' => $fees2[$i],
                    'residence' => 'boarding',
                    'gender' => 'male',
                    'clazz_id' => 2,
                    'new_or_continuing' => 'continuing',
                    'fee_category_id' => $category->id,
                    'account_id' => $this->revenue_account->id

                ]);
            }
           
        }

    }


    protected function three()
    {

        $fee_categories = ['Tuition', 'Medical Fee'];
        $fees_amount3 = ['400000','20000'];


         
        for ($i=0; $i < count($fee_categories); $i++) {

            $category = FeeCategory::firstOrCreate(['name' => $fee_categories[$i]],['name' => $fee_categories[$i]]);
            
            
            //S.3 Boys Boarding -> previous Term
            if ($this->previousTerm) {
                # code...
                Fee::create([
                    'term_id' => $this->previousTerm->id,
                    'amount' => $fees_amount3[$i],
                    'residence' => 'boarding',
                    'gender' => 'male',
                    'clazz_id' => 3,
                    'new_or_continuing' => 'continuing',
                    'fee_category_id' => $category->id,
                    'account_id' => $this->revenue_account->id
                ]);
            }

            //S.3 Boys Boarding -> current Term
            if ($this->currentTerm) {
                # code...
                Fee::create([
                    'term_id' => $this->currentTerm->id,
                    'amount' => $fees_amount3[$i],
                    'residence' => 'boarding',
                    'gender' => 'male',
                    'clazz_id' => 3,
                    'new_or_continuing' => 'continuing',
                    'fee_category_id' => $category->id,
                    'account_id' => $this->revenue_account->id

                ]);
            }
           
        }


    }

    protected function four()
    {

        $fee_categories = ['Tuition', 'Medical Fee'];
        $fees_amount4 = ['500000','20000'];


         
        for ($i=0; $i < count($fee_categories); $i++) {

            $category = FeeCategory::firstOrCreate(['name' => $fee_categories[$i]],['name' => $fee_categories[$i]]);
            
            
            //S.1 Boys Boarding -> previous Term
            if ($this->previousTerm) {
                # code...
                Fee::create([
                    'term_id' => $this->previousTerm->id,
                    'amount' => $fees_amount4[$i],
                    'residence' => 'boarding',
                    'gender' => 'male',
                    'clazz_id' => 4,
                    'new_or_continuing' => 'continuing',
                    'fee_category_id' => $category->id
                ]);
            }

            //S.1 Boys Boarding -> current Term
            if ($this->currentTerm) {
                # code...
                Fee::create([
                    'term_id' => $this->currentTerm->id,
                    'amount' => $fees_amount4[$i],
                    'residence' => 'boarding',
                    'gender' => 'male',
                    'clazz_id' => 4,
                    'new_or_continuing' => 'continuing',
                    'fee_category_id' => $category->id
                ]);
            }
           
        }


    }

    protected function five()
    {

        $fee_categories = ['Tuition', 'Medical Fee'];
        $fees_amount5 = ['700000','20000'];


         
        for ($i=0; $i < count($fee_categories); $i++) {

            $category = FeeCategory::firstOrCreate(['name' => $fee_categories[$i]],['name' => $fee_categories[$i]]);
            
            
            //S.1 Boys Boarding -> previous Term
            if ($this->previousTerm) {
                # code...
                Fee::create([
                    'term_id' => $this->previousTerm->id,
                    'amount' => $fees_amount5[$i],
                    'residence' => 'boarding',
                    'gender' => 'male',
                    'clazz_id' => 5,
                    'new_or_continuing' => 'continuing',
                    'fee_category_id' => $category->id
                ]);
            }

            //S.1 Boys Boarding -> current Term
            if ($this->currentTerm) {
                # code...
                Fee::create([
                    'term_id' => $this->currentTerm->id,
                    'amount' => $fees_amount5[$i],
                    'residence' => 'boarding',
                    'gender' => 'male',
                    'clazz_id' => 5,
                    'new_or_continuing' => 'continuing',
                    'fee_category_id' => $category->id
                ]);
            }
           
        }


    }

    protected function six()
    {

        $fee_categories = ['Tuition', 'Medical Fee'];
        $fees_amount6 = ['800000','20000'];


        
        for ($i=0; $i < count($fee_categories); $i++) {

            $category = FeeCategory::firstOrCreate(['name' => $fee_categories[$i]],['name' => $fee_categories[$i]]);
            
            
            //S.1 Boys Boarding -> previous Term
            if ($this->previousTerm) {
                # code...
                Fee::create([
                    'term_id' => $this->previousTerm->id,
                    'amount' => $fees_amount6[$i],
                    'residence' => 'boarding',
                    'gender' => 'male',
                    'clazz_id' => 6,
                    'new_or_continuing' => 'continuing',
                    'fee_category_id' => $category->id
                ]);
            }

            //S.1 Boys Boarding -> current Term
            if ($this->currentTerm) {
                # code...
                Fee::create([
                    'term_id' => $this->currentTerm->id,
                    'amount' => $fees_amount6[$i],
                    'residence' => 'boarding',
                    'gender' => 'male',
                    'clazz_id' => 6,
                    'new_or_continuing' => 'continuing',
                    'fee_category_id' => $category->id
                ]);
            }
           
        }

    }

    
    //S.1 Fees for current and previous term
    protected function newOne()
    {

        $fee_categories = ['Tuition', 'Medical Fee'];
        $fees = ['320000','20000'];

        for ($i=0; $i < count($fee_categories); $i++) {

            $category = FeeCategory::firstOrCreate(['name' => $fee_categories[$i]],['name' => $fee_categories[$i]]);

            //New Students current Term
            if ($this->currentTerm) {
                # code...
                Fee::create([
                    'term_id' => $this->currentTerm->id,
                    'amount' => $fees[$i],
                    'residence' => 'boarding',
                    'gender' => 'male',
                    'clazz_id' => 1,
                    'new_or_continuing' => 'new',
                    'fee_category_id' => $category->id
                ]);
            }
           
        }

    }

    protected function sameFee()
    {
        if(count($this->clazzs) > 0){

            $tuition = FeeCategory::firstOrCreate(['name' => 'Tuition']);
            $medical = FeeCategory::firstOrCreate(['name' => 'Medical Fee']);

            collect($this->clazzs)->map(function($item, $key) use($tuition, $medical){
                //Borading New & COntiniung
                $this->createFee($this->currentTerm->id, $tuition->id, 300000, 'boarding', $item->id, 'new', 'male');
                $this->createFee($this->currentTerm->id, $tuition->id, 300000, 'boarding', $item->id, 'new', 'female');
                $this->createFee($this->currentTerm->id, $medical->id, 20000, 'boarding', $item->id, 'new', 'male');
                $this->createFee($this->currentTerm->id, $medical->id, 20000, 'boarding', $item->id, 'new', 'female');
                $this->createFee($this->currentTerm->id, $tuition->id, 300000, 'boarding', $item->id, 'continuing', 'male');
                $this->createFee($this->currentTerm->id, $tuition->id, 300000, 'boarding', $item->id,'continuing', 'female');
                $this->createFee($this->currentTerm->id, $medical->id, 20000, 'boarding', $item->id, 'continuing', 'male');
                $this->createFee($this->currentTerm->id, $medical->id, 20000, 'boarding', $item->id, 'continuing', 'female');
                 //Day New & COntiniung
                 $this->createFee($this->currentTerm->id, $tuition->id, 250000, 'day', $item->id, 'new', 'male');
                 $this->createFee($this->currentTerm->id, $tuition->id, 250000, 'day', $item->id, 'new', 'female');
                 $this->createFee($this->currentTerm->id, $medical->id, 20000, 'day', $item->id, 'new', 'male');
                 $this->createFee($this->currentTerm->id, $medical->id, 20000, 'day', $item->id, 'new', 'female');
                 $this->createFee($this->currentTerm->id, $tuition->id, 250000, 'day', $item->id, 'continuing', 'male');
                 $this->createFee($this->currentTerm->id, $tuition->id, 250000, 'day', $item->id, 'continuing', 'female');
                 $this->createFee($this->currentTerm->id, $medical->id, 20000, 'day', $item->id, 'continuing', 'male');
                 $this->createFee($this->currentTerm->id, $medical->id, 20000, 'day', $item->id, 'continuing', 'female');
            });

        }
    }

    protected function createFee($term_id, $fee_category_id, $amount, $residence, $clazz_id, $entry, $gender)
    {
        Fee::create([
            'term_id' => $term_id,
            'amount' => $amount,
            'residence' => $residence,
            'gender' => $gender,
            'clazz_id' => $clazz_id,
            'new_or_continuing' => $entry,
            'fee_category_id' => $fee_category_id
        ]);
    }
}
