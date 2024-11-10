<?php

use Illuminate\Database\Seeder;

use App\Models\Budget\Budget;
use App\Models\Budget\ExpenseProjection;
use App\Models\Coa;
use App\Models\Expense\Expense;


class BudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $budget = new Budget;
        $budget->description = '2023-2024 budget';
        $budget->accounting_period_id = period()->id;

        $budget->save();

        $account = Coa::updateOrCreate([
            'name' => 'Staff Welfare',
            'type' => 'expense'
        ]);

        $projection = new ExpenseProjection;
        $projection->account_id = $account->id;
        $projection->budget_id = $budget->id;
        $projection->amount = '200000000';

        $projection->save();

        $expense = new Expense;
        $expense->date = now();
        $expense->description = 'Test Budget Projection Expense';
        $expense->amount = '70000000';
        $expense->accounting_period_id = period()->id;
        $expense->account_id = $account->id;

        $expense->save();
    }
}
