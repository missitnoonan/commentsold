<?php

namespace Database\Seeders;

use App\Repositories\InventoryRepository;
use App\Repositories\OrderRepository;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $order_repository = new OrderRepository();

            $seed_data_handle = fopen(storage_path('/seed-data/orders.csv'), 'r');
            $headers = fgetcsv($seed_data_handle);
            $flips_headers = array_flip($headers);

            $orders_data = [];

            $count = 0;
            $loaded = 0;
            while ($line = fgetcsv($seed_data_handle)) {
                $count++;
                $orders_data[] = [
                    'id' => $line[$flips_headers['id']],
                    'product_id' => (int) $line[$flips_headers['product_id']],
                    'street_address' => $line[$flips_headers['street_address']],
                    'apartment' => $line[$flips_headers['apartment']],
                    'city' => $line[$flips_headers['city']],
                    'state' => $line[$flips_headers['state']],
                    'country_code' => $line[$flips_headers['country_code']],
                    'phone_number' => $line[$flips_headers['phone_number']],
                    'email' => $line[$flips_headers['email']],
                    'name' => $line[$flips_headers['name']],
                    'order_status' => $line[$flips_headers['id']],
                    'payment_ref' => $line[$flips_headers['id']],
                    'transaction_id' => $line[$flips_headers['id']],
                    'payment_amt_cents' => (int) $line[$flips_headers['payment_amt_cents']],
                    'ship_charged_cents' => (int )$line[$flips_headers['ship_charged_cents']],
                    'subtotal_cents' => (int) $line[$flips_headers['subtotal_cents']],
                    'total_cents' => (int) $line[$flips_headers['total_cents']],
                    'shipper_name' => $line[$flips_headers['shipper_name']],
                    'payment_date' => $line[$flips_headers['payment_date']],
                    'shipped_date' => $line[$flips_headers['shipped_date']],
                    'tracking_number' => $line[$flips_headers['shipped_date']],
                    'tax_total_cents' => (int) $line[$flips_headers['shipped_date']],
                    'created_at' => $line[$flips_headers['shipped_date']],
                    'updated_at' => $line[$flips_headers['shipped_date']],
                ];

                if (count($orders_data) >= 100) {
                    $ok = $order_repository->load($orders_data);
                    if ($ok) {
                        $loaded += 100;
                    }
                    $orders_data = [];
                }
            }

            $ok = $order_repository->load($orders_data);
            if ($ok) {
                $loaded += count($orders_data);
            }

            echo "Order Records: $count \n";
            echo "Orders Loaded: $loaded \n";
        }
    }
}
