<?php

use Illuminate\Database\Seeder;

use App\Models\Requisition\Requisition;
use App\Models\Expense\Expense;
use App\Models\Expense\ExpenseCategory;

use App\Models\Coa;

class RequisitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $expenses_categories = config('defaults.expense_categories');

        $requisition = new Requisition;

        $requisition->date = now();
        $requisition->description = 'just another req';
        $requisition->type = 'purchase';
        $requisition->sent_for_approval = 1;
        $requisition->accounting_period_id = period()->id;
        $requisition->department_id = 1;
        $requisition->requested_by = 1;


        $requisition->save();

        $requisition->items()->create([
            'name' => 'Laptop Screen',
            'quantity' => '1',
            'rate' => '2245678'
        ]);

        $requisition->items()->create([
            'name' => 'Repair Labor',
            'quantity' => '1',
            'rate' => '100000'
        ]);

        foreach ($expenses_categories as $category) {
            $hello = ExpenseCategory::create([
                'name' => $category
            ]);
            Coa::create([
                'name' => $category,
                'type' => 'expense',
            ]);
        }

        $expense = new Expense;
        $expense->date = now();
        $expense->description = 'Just test of expenses';
        $expense->requisition_id = $requisition->id;
        $expense->amount = '2345678';
        $expense->accounting_period_id = period()->id;
        $expense->account_id = 1;

        $expense->save();
    }
}
