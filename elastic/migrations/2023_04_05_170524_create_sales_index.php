<?php
declare(strict_types=1);

use Elastic\Adapter\Indices\Mapping;
use Elastic\Adapter\Indices\Settings;
use Elastic\Migrations\Facades\Index;
use Elastic\Migrations\MigrationInterface;

final class CreateSalesIndex implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Index::create('sales', function (Mapping $mapping, Settings $settings) {
            $mapping->long('id');
            $mapping->text('trader_name');
            $mapping->text('trader_phone_number');
            $mapping->keyword('sales_type');
            $mapping->long('created_by');
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Index::dropIfExists('sales');
    }
}
