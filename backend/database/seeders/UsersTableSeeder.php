<?php

namespace Database\Seeders;

use App\Repositories\UserRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $user_repository = new UserRepository();

            $user = new \App\Models\User();
            $user->name = 'Andrew Bielecki';
            $user->email = 'ambielecki@gmail.com';
            $user->password = \Illuminate\Support\Facades\Hash::make(config('app.default_password'));
            $user->super_admin = 1;
            $user->save();

            $seed_data_handle = fopen(storage_path('/seed-data/users.csv'), 'r');
            $headers = fgetcsv($seed_data_handle);
            $flips_headers = array_flip($headers);

            $user_data = [];

            $count = 0;
            $loaded = 0;
            while ($line = fgetcsv($seed_data_handle)) {
                $count++;
                $user_data[] = [
                    'id' => $line[$flips_headers['id']],
                    'name' => $line[$flips_headers['name']],
                    'email' => $line[$flips_headers['email']],
                    'password' => Hash::make($line[$flips_headers['password_plain']]),
                    'super_admin' => (int) $line[$flips_headers['superadmin']],
                    'shop_name' => $line[$flips_headers['shop_name']],
                    'card_brand' => $line[$flips_headers['card_brand']],
                    'card_last_four' => $line[$flips_headers['card_last_four']],
                    'trial_ends_at' => $line[$flips_headers['trial_ends_at']],
                    'shop_domain' => $line[$flips_headers['shop_domain']],
                    'is_enabled' => (int) $line[$flips_headers['is_enabled']],
                    'billing_plan' => $line[$flips_headers['billing_plan']],
                    'updated_at' => $line[$flips_headers['updated_at']],
                    'created_at' => $line[$flips_headers['created_at']],
                ];

                if (count($user_data) >= 500) {
                    $ok = $user_repository->load($user_data);
                    if ($ok) {
                        $loaded += 500;
                    }
                    $user_data = [];
                }
            }

            $ok = $user_repository->load($user_data);
            if ($ok) {
                $loaded += count($user_data);
            }

            echo "User Records: $count \n";
            echo "Users Loaded: $loaded \n";

//            $user = new \App\Models\User();
//            $user->first_name = 'Testy';
//            $user->last_name = 'McTersterson';
//            $user->email = 'testy@test.com';
//            $user->password = \Illuminate\Support\Facades\Hash::make('foobarfizzbuzz');
//            $user->is_admin = 0;
//            $user->save();
        }
    }
}
