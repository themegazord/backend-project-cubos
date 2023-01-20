<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class InstallmentTest extends TestCase
{
    protected $payload = [
        'users_id' => '5',
        'id_billing' => '124578',
        'debtor' => 'Gustavo de Camargo Campos',
        'emission_date' => '2023-01-19',
        'due_date' => '2023-01-25',
        'amount' => '50',
        'paid_amount' => '0',
    ];

    protected $user;

    public function test_request_to_see_all_installments_without_authentication()
    {
        $response = $this->json('GET', '/api/installments');
        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_request_to_see_all_installments_with_authentication() {
        $this->user= User::factory()->create();
        $response = $this->actingAs($this->user)->json('GET', 'api/installments');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            [
                'id',
                'users_id',
                'id_billing',
                'status',
                'debtor',
                'emission_date',
                'due_date',
                'overdue_payment',
                'amount',
                'paid_amount',
                'user'
            ]
        ]);
    }

    public function test_request_using_query_params_in_endpoint() {
        $this->user = User::factory()->create();
        $response = $this->actingAs($this->user)->json('GET', 'api/installments?filter=users_id:=:2');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            [
                'id',
                'users_id',
                'id_billing',
                'status',
                'debtor',
                'emission_date',
                'due_date',
                'overdue_payment',
                'amount',
                'paid_amount',
                'user'
            ]
        ]);
    }

    public function test_create_installments() {
        DB::delete('delete from installments where id_billing = :id_billing', ['id_billing' => $this->payload['id_billing']]);
        $this->user= User::factory()->create();
        $response = $this->actingAs($this->user)->json('POST', 'api/installments', $this->payload);
        $response->assertStatus(201);
        $response->assertJson(['msg' => 'Installment has been created']);
    }

    public function test_show_installments_not_exists() {
        $this->user = User::factory()->create();
        $response = $this->actingAs($this->user)->json('GET', 'api/installments/1000');
        $response->assertStatus(404);
        $response->assertJson(['error' => 'Installment not exists']);
    }

    public function test_show_existing_installments() {
        $this->user = User::factory()->create();
        $response = $this->actingAs($this->user)->json('GET', 'api/installments/1');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'users_id',
            'id_billing',
            'status',
            'debtor',
            'emission_date',
            'due_date',
            'overdue_payment',
            'amount',
            'paid_amount',
            'user'
        ]);
    }

    public function test_update_not_existing_installments() {
        $this->user = User::factory()->create();
        $this->payload['_method'] = 'PUT';
        $response = $this->actingAs($this->user)->json('POST', 'api/installments/1000', $this->payload);
        $response->assertStatus(404);
        $response->assertJsonFragment([
            'error' => 'Installment not exists'
        ]);
    }

    public function test_update_existing_installments_with_status_open() {
        $this->user = User::factory()->create();
        $id = DB::select('select id from installments where id_billing = :id_billing', ['id_billing' => $this->payload['id_billing']])[0]->id;
        $this->payload['_method'] = 'PUT';
        $response = $this->actingAs($this->user)->json('POST', 'api/installments/' . $id, $this->payload);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'users_id',
            'id_billing',
            'emission_date',
            'due_date',
            'amount',
            'paid_amount',
            'status'
        ]);
    }


    public function test_update_existing_installments_with_status_partial() {
        $this->user = User::factory()->create();
        $id = DB::select('select id from installments where id_billing = :id_billing', ['id_billing' => $this->payload['id_billing']])[0]->id;
        $this->payload['_method'] = 'PUT';
        $this->payload['paid_amount'] = '25';
        $response = $this->actingAs($this->user)->json('POST', 'api/installments/' . $id, $this->payload);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'users_id',
            'id_billing',
            'emission_date',
            'due_date',
            'amount',
            'paid_amount',
            'status'
        ]);
    }


    public function test_update_existing_installments_with_status_payed() {
        $this->user = User::factory()->create();
        $id = DB::select('select id from installments where id_billing = :id_billing', ['id_billing' => $this->payload['id_billing']])[0]->id;
        $this->payload['_method'] = 'PUT';
        $this->payload['paid_amount'] = '50';
        $response = $this->actingAs($this->user)->json('POST', 'api/installments/' . $id, $this->payload);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'users_id',
            'id_billing',
            'emission_date',
            'due_date',
            'amount',
            'paid_amount',
            'status'
        ]);
    }

    public function test_see_all_installment_to_user() {
        $this->user = User::factory()->create();
        $response = $this->actingAs($this->user)->json('GET', 'api/user/installments/2');
        $response->assertStatus(200);
        $response->assertJsonStructure([['id', 'id_billing', 'status', 'debtor', 'emission_date', 'due_date', 'overdue_payment', 'amount', 'paid_amount']]);
    }
}
