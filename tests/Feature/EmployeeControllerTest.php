<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\User;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Employee index screen can be rendered.
     *
     * @return void
     */
    public function test_index_screen_can_be_rendered()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        Employee::factory()->create([
            'first_name' => 'first name',
            'last_name' => 'last name',
            'company_id' => $company->id,
            'email' => 'employee@company.com',
            'phone' => '+55 (55) 5555 5555',
        ]);

        $response = $this->actingAs($user)->get('/employee');

        $this->assertAuthenticated();
        $response->assertStatus(200);
        $response->assertSee('first name');
        $response->assertSee('employee@company.com');
    }

    /**
     * Company create screen can be rendered.
     *
     * @return void
     */
    public function test_create_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/employee/create');

        $this->assertAuthenticated();
        $response->assertStatus(200);
        $response->assertSee('Create Employee');
    }

    /**
     * A Company can be stored.
     *
     * @return void
     */
    public function test_a_company_can_be_stored()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $payload = [
            'first_name' => 'Employee',
            'last_name' => 'One',
            'company_id' => $company->id,
            'email' => 'employee1@company.com',
            'phone' => '+55 (55) 5555 5555',
        ];

        $response = $this->actingAs($user)->post('employee', $payload);

        $employee = Employee::first();

        $response->assertStatus(201);
        $response->assertRedirect('employee');
        $this->assertDatabaseHas('employees', $payload);
        self::assertEquals($payload['first_name'], $employee->first_name);
        self::assertEquals($payload['last_name'], $employee->last_name);
        self::assertEquals($payload['email'], $employee->email);
        self::assertEquals($payload['phone'], $employee->phone);
    }

    /**
     * A Company cannot be stored.
     *
     * @return void
     */
    public function test_a_company_cannot_be_stored_when_required_params_are_not_valid()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $payload = [
            'first_name' => 'Employee',
            'last_name' => 'One',
            'company_id' => $company->id,
            'email' => 'employee1@company.com',
            'phone' => '+55 (55) 5555 5555',
        ];

        $response = $this->actingAs($user)->post('/employee', [
            'first_name' => null,
            'last_name' => $payload['last_name'],
            'company_id' => $payload['company_id'],
            'email' => $payload['email'],
            'phone' => $payload['phone'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('employee');
        $this->assertDatabaseMissing('employees', $payload);

        $response = $this->actingAs($user)->post('/employee', [
            'first_name' => $payload['first_name'],
            'last_name' => null,
            'company_id' => $payload['company_id'],
            'email' => $payload['email'],
            'phone' => $payload['phone'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('employee');
        $this->assertDatabaseMissing('employees', $payload);

        $response = $this->actingAs($user)->post('/employee', [
            'first_name' => $payload['first_name'],
            'last_name' => $payload['last_name'],
            'company_id' => null,
            'email' => $payload['email'],
            'phone' => $payload['phone'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('employee');
        $this->assertDatabaseMissing('employees', $payload);

        $response = $this->actingAs($user)->post('/employee', [
            'first_name' => $payload['first_name'],
            'last_name' => $payload['last_name'],
            'company_id' => $payload['company_id'],
            'email' => null,
            'phone' => $payload['phone'],
        ]);
        $response->assertStatus(201);
        $response->assertRedirect('employee');
        $this->assertDatabaseHas('employees', [
            'first_name' => $payload['first_name'],
            'last_name' => $payload['last_name'],
            'company_id' => $payload['company_id'],
            'email' => null,
            'phone' => $payload['phone'],
        ]);

        $response = $this->actingAs($user)->post('/employee', [
            'first_name' => $payload['first_name'],
            'last_name' => $payload['last_name'],
            'company_id' => $payload['company_id'],
            'email' => $payload['email'],
            'phone' => null,
        ]);
        $response->assertStatus(201);
        $response->assertRedirect('employee');
        $this->assertDatabaseHas('employees', [
            'first_name' => $payload['first_name'],
            'last_name' => $payload['last_name'],
            'company_id' => $payload['company_id'],
            'email' => $payload['email'],
            'phone' => null,
        ]);
    }

    /**
     * Company show screen can be rendered.
     *
     * @return void
     */
    public function test_show_screen_can_be_rendered()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $employee = Employee::factory()->create([
            'first_name' => 'first name',
            'last_name' => 'last name',
            'company_id' => $company->id,
            'email' => 'employee@company.com',
            'phone' => '+55 (55) 5555 5555',
        ]);

        $response = $this->actingAs($user)->get('/employee/' . $employee->id);

        $this->assertAuthenticated();
        $response->assertStatus(200);
        $response->assertSee('first name last name');
        $response->assertSee('employee@company.com');
    }

    /**
     * Company edit screen can be rendered.
     *
     * @return void
     */
    public function test_edit_screen_can_be_rendered()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $employee = Employee::factory()->create([
            'first_name' => 'first name',
            'last_name' => 'last name',
            'company_id' => $company->id,
            'email' => 'employee@company.com',
            'phone' => '+55 (55) 5555 5555',
        ]);

        $response = $this->actingAs($user)->get('/employee/' . $employee->id . '/edit');

        $this->assertAuthenticated();
        $response->assertStatus(200);
        $response->assertSee('first name last name');
        $response->assertSee('employee@company.com');
    }

    /**
     * A Company can be updated.
     *
     * @return void
     */
    public function test_a_company_can_be_updated()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $employee = Employee::factory()->create(['company_id' => $company->id]);
        $payload = [
            'first_name' => 'Employee',
            'last_name' => 'Two',
            'company_id' => $company->id,
            'email' => 'employee2@company.com',
            'phone' => '+55 (55) 5555 5555',
        ];

        $response = $this->actingAs($user)->put('/employee/' . $employee->id, $payload);

        $response->assertStatus(201);
        $response->assertRedirect('/employee');
        $this->assertDatabaseHas('employees', $payload);
        self::assertEquals($payload['first_name'], $employee->refresh()->first_name);
        self::assertEquals($payload['last_name'], $employee->refresh()->last_name);
        self::assertEquals($payload['email'], $employee->refresh()->email);
        self::assertEquals($payload['phone'], $employee->refresh()->phone);
    }

    /**
     * A Company cannot be updated.
     *
     * @return void
     */
    public function test_a_company_cannot_be_updated_when_required_params_are_not_valid()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $employee = Employee::factory()->create(['company_id' => $company->id]);
        $payload = [
            'first_name' => 'Employee',
            'last_name' => 'One',
            'company_id' => $company->id,
            'email' => 'employee1@company.com',
            'phone' => '+55 (55) 5555 5555',
        ];

        $response = $this->actingAs($user)->put('/employee/' . $employee->id, [
            'first_name' => null,
            'last_name' => $payload['last_name'],
            'company_id' => $payload['company_id'],
            'email' => $payload['email'],
            'phone' => $payload['phone'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('employee');
        $this->assertDatabaseMissing('employees', $payload);

        $response = $this->actingAs($user)->put('/employee/' . $employee->id, [
            'first_name' => $payload['first_name'],
            'last_name' => null,
            'company_id' => $payload['company_id'],
            'email' => $payload['email'],
            'phone' => $payload['phone'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('employee');
        $this->assertDatabaseMissing('employees', $payload);

        $response = $this->actingAs($user)->put('/employee/' . $employee->id, [
            'first_name' => $payload['first_name'],
            'last_name' => $payload['last_name'],
            'company_id' => null,
            'email' => $payload['email'],
            'phone' => $payload['phone'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('employee');
        $this->assertDatabaseMissing('employees', $payload);

        $response = $this->actingAs($user)->put('/employee/' . $employee->id, [
            'first_name' => $payload['first_name'],
            'last_name' => $payload['last_name'],
            'company_id' => $payload['company_id'],
            'email' => null,
            'phone' => $payload['phone'],
        ]);
        $response->assertStatus(201);
        $response->assertRedirect('employee');
        $this->assertDatabaseHas('employees', [
            'first_name' => $payload['first_name'],
            'last_name' => $payload['last_name'],
            'company_id' => $payload['company_id'],
            'email' => null,
            'phone' => $payload['phone'],
        ]);

        $response = $this->actingAs($user)->put('/employee/' . $employee->id, [
            'first_name' => $payload['first_name'],
            'last_name' => $payload['last_name'],
            'company_id' => $payload['company_id'],
            'email' => $payload['email'],
            'phone' => null,
        ]);
        $response->assertStatus(201);
        $response->assertRedirect('employee');
        $this->assertDatabaseHas('employees', [
            'first_name' => $payload['first_name'],
            'last_name' => $payload['last_name'],
            'company_id' => $payload['company_id'],
            'email' => $payload['email'],
            'phone' => null,
        ]);
    }

    /**
     * An Employee can be deleted.
     *
     * @return void
     */
    public function test_an_employee_can_be_deleted()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $employee = Employee::factory()->create([
            'company_id' => $company->id,
        ]);

        $response = $this->actingAs($user)->delete('/employee/' . $employee->id);

        $response->assertStatus(302);
        $response->assertRedirect('/employee');
        self::assertCount(0, Employee::all());
    }

    /**
     * An non-existent Employee cannot be deleted.
     *
     * @return void
     */
    public function test_an_non_existent_employee_cannot_be_deleted()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        Employee::factory()->create(['company_id' => $company->id]);

        $response = $this->actingAs($user)->delete('/employee/100');

        $response->assertStatus(404);
    }
}
