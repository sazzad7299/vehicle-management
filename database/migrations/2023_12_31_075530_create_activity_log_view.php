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
                CREATE VIEW activity_log_view AS
                SELECT
                    activity_logs.id AS log_id, -- Specify alias for the activity_logs.id column
                    activity_logs.user_id,
                    activity_logs.activity_type,
                    activity_logs.activity,
                    activity_logs.extra_info,
                    users.name AS user_name,
                    pharmacies.company_name AS pharmacy_name,
                    activity_logs.created_at
                FROM
                    activity_logs
                    JOIN users ON activity_logs.user_id = users.id
                    LEFT JOIN pharmacies ON activity_logs.pharmacy_id = pharmacies.id;
                SQL;

        // Execute the raw SQL statement
        \DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::statement('DROP VIEW IF EXISTS activity_log_view;');
    }
};
