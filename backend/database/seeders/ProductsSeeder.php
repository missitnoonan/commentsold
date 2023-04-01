<?php

namespace Database\Seeders;
use App\Repositories\ProductRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $product_repository = new ProductRepository();

        // Not DRY at all, but seeders are one offs in this case
        $seed_data_handle = fopen(storage_path('/seed-data/products.csv'), 'r');
        $headers = fgetcsv($seed_data_handle);
        $flips_headers = array_flip($headers);

        $product_data = [];

        $count = 0;
        $loaded = 0;
        while ($line = fgetcsv($seed_data_handle)) {
            $count++;
            $product_data[] = [
                'id' => $line[$flips_headers['id']],
                'product_name' => $line[$flips_headers['product_name']],
                'description' => $line[$flips_headers['description']],
                'style' => $line[$flips_headers['style']],
                'brand' => $line[$flips_headers['brand']],
                'url' => $line[$flips_headers['url']],
                'product_type' => $line[$flips_headers['product_type']],
                'shipping_price' => (int) $line[$flips_headers['shipping_price']],
                'note' => $line[$flips_headers['note']],
                'admin_id' => (int) $line[$flips_headers['admin_id']],
                'updated_at' => $line[$flips_headers['updated_at']],
                'created_at' => $line[$flips_headers['created_at']],
            ];

            if (count($product_data) >= 500) {
                $ok = $product_repository->load($product_data);
                if ($ok) {
                    $loaded += 500;
                }
                $product_data = [];
            }
        }

        $ok = $product_repository->load($product_data);
        if ($ok) {
            $loaded += count($product_data);
        }

        echo "Product Records: $count \n";
        echo "Products Loaded: $loaded \n";
    }
}
