<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $sql = <<<'SQL'
                CREATE VIEW balance_view AS
                SELECT
                pm.id,
                pm.pharmacy_id,
                pm.name,
                SUM(pm.cash_in_sum) AS cash_in,
                SUM(pm.cash_out_sum) AS cash_out,
                SUM(pm.sale_return_sum) AS sale_return,
                SUM(pm.cost_sum) AS cost,
                SUM(pm.purchase_return_sum) AS purchase_return,
                SUM(pm.pay_salary_sum) AS pay_salary,
                SUM(pm_sale_payments_sum.paid) AS sale_payments,
                SUM(pm_purchase_payments_sum.paid) AS purchase_payments,
                SUM(
                    COALESCE(pm.cash_in_sum, 0) + COALESCE(pm.purchase_return_sum, 0)
                    - COALESCE(pm.cash_out_sum, 0) - COALESCE(pm.sale_return_sum, 0)
                    - COALESCE(pm.cost_sum, 0) + COALESCE(pm.pay_salary_sum, 0)
                    + COALESCE(pm_sale_payments_sum.paid, 0) - COALESCE(pm_purchase_payments_sum.paid, 0)
                ) AS current_balance
                FROM (
                SELECT
                    pm.id,
                    pm.pharmacy_id,
                    pm.name,
                    COALESCE(SUM(ci.amount), 0) AS cash_in_sum,
                    COALESCE(SUM(co.amount), 0) AS cash_out_sum,
                    COALESCE(SUM(sr.returnAmount), 0) AS sale_return_sum,
                    COALESCE(SUM(c.amount), 0) AS cost_sum,
                    COALESCE(SUM(pr.returnAmount), 0) AS purchase_return_sum,
                    COALESCE(SUM(es.paid), 0) AS pay_salary_sum
                FROM
                    payment_methods pm
                LEFT JOIN cash_in_outs ci ON pm.id = ci.payment_method_id AND ci.type = 1
                LEFT JOIN cash_in_outs co ON pm.id = co.payment_method_id AND co.type = 2
                LEFT JOIN sale_returns sr ON pm.id = sr.payment_method_id
                LEFT JOIN costs c ON pm.id = c.payment_method_id
                LEFT JOIN purchase_returns pr ON pm.id = pr.payment_method_id
                LEFT JOIN employee_salaries es ON pm.id = es.payment_method_id
                GROUP BY pm.id, pm.name
                ) pm
                LEFT JOIN (
                SELECT payment_method_id, SUM(paid) AS paid
                FROM sale_payments
                GROUP BY payment_method_id
                ) pm_sale_payments_sum ON pm.id = pm_sale_payments_sum.payment_method_id
                LEFT JOIN (
                SELECT payment_method_id, SUM(paid) AS paid
                FROM purchase_payments
                GROUP BY payment_method_id
                ) pm_purchase_payments_sum ON pm.id = pm_purchase_payments_sum.payment_method_id
                GROUP BY pm.pharmacy_id, pm.id, pm.name;
                SQL;

        // Execute the raw SQL statement
        \DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::statement('DROP VIEW IF EXISTS balance_view;');
    }
};
