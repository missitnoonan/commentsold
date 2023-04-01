<?php

namespace Database\Seeders;

use App\Repositories\InventoryRepository;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $inventory_repository = new InventoryRepository();

            $seed_data_handle = fopen(storage_path('/seed-data/inventory.csv'), 'r');
            $headers = fgetcsv($seed_data_handle);
            $flips_headers = array_flip($headers);

            $inventory_data = [];

            $count = 0;
            $loaded = 0;
            while ($line = fgetcsv($seed_data_handle)) {
                $count++;
                $inventory_data[] = [
                    'id' => $line[$flips_headers['id']],
                    'product_id' => (int) $line[$flips_headers['product_id']],
                    'quantity' => (int) $line[$flips_headers['quantity']],
                    'color' => $line[$flips_headers['color']],
                    'size' => $line[$flips_headers['size']],
                    'weight' => (double) $line[$flips_headers['weight']],
                    'price_cents' => (int) $line[$flips_headers['price_cents']],
                    'sale_price_cents' => (int) $line[$flips_headers['sale_price_cents']],
                    'cost_cents' => (int) $line[$flips_headers['cost_cents']],
                    'sku' => $line[$flips_headers['sku']],
                    'length' => (double) $line[$flips_headers['length']],
                    'width' => (double) $line[$flips_headers['width']],
                    'height' => (double) $line[$flips_headers['height']],
                    'note' => $line[$flips_headers['note']],
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ];

                if (count($inventory_data) >= 500) {
                    $ok = $inventory_repository->load($inventory_data);
                    if ($ok) {
                        $loaded += 500;
                    }
                    $inventory_data = [];
                }
            }

            $ok = $inventory_repository->load($inventory_data);
            if ($ok) {
                $loaded += count($inventory_data);
            }

            echo "Inventory Records: $count \n";
            echo "Inventories Loaded: $loaded \n";
        }
    }
}
