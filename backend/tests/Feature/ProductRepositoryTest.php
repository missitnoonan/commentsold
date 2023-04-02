<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    public function test_it_gets_products_list_with_auth(): void
    {
        // would normally build this up with a factory / use test DB seeds, and certainly wouldn't just use an email / pwd
        $login = $this->postJson('/api/login', [
            'email' => 'larhonda.hovis@foo.com',
            'password' => 'cghmpbKXXK',
        ]);

        $content = $login->decodeResponseJson();
        $token = $content['data']['access_token'];

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->getJson('/api/products');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'message_type',
            'request_info' => ['route', 'method', 'date'],
            'data' => ['product_repositories'],
        ]);

        $response_data = $response->decodeResponseJson();
        $product_repositories = $response_data['data']['product_repositories'];
        $this->assertEquals(20, count($product_repositories)); // from default pagination
    }

    public function test_it_gets_inventory_item(): void
    {
        $login = $this->postJson('/api/login', [
            'email' => 'larhonda.hovis@foo.com',
            'password' => 'cghmpbKXXK',
        ]);

        $content = $login->decodeResponseJson();
        $token = $content['data']['access_token'];

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->getJson('/api/products/10852');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'message_type',
            'request_info' => ['route', 'method', 'date'],
            'data',
        ]);

        $response_data = $response->decodeResponseJson();
        $product = $response_data['data'];

        $this->assertEquals(10852, $product['id']);
    }

    public function test_it_receives_unauthorized_when_requesting_unowned_product(): void
    {
        $login = $this->postJson('/api/login', [
            'email' => 'lekisha.dinatale@foo.com',
            'password' => 'MFdqzRnhSb',
        ]);

        $content = $login->decodeResponseJson();
        $token = $content['data']['access_token'];

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->getJson('/api/products/10852');

        $response->assertStatus(401);
    }

    public function test_it_receives_unauthorized_without_token(): void
    {
        $response = $this->getJson('/api/products/10852');
        $response->assertStatus(401);
    }
}
