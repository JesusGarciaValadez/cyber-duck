<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Company index screen can be rendered.
     *
     * @return void
     */
    public function test_index_screen_can_be_rendered()
    {
        $user = User::factory()->create();
        Company::factory()->create([
            'name' => 'Company One',
            'email' => 'company@company.com',
        ]);

        $response = $this->actingAs($user)->get('/company');

        $this->assertAuthenticated();
        $response->assertStatus(200);
        $response->assertSee('Company One');
        $response->assertSee('company@company.com');
    }

    /**
     * Company create screen can be rendered.
     *
     * @return void
     */
    public function test_create_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/company/create');

        $this->assertAuthenticated();
        $response->assertStatus(200);
        $response->assertSee('Create Company');
    }

    /**
     * A Company can be stored.
     *
     * @return void
     */
    public function test_a_company_can_be_stored()
    {
        Storage::fake();

        $user = User::factory()->create();
        $payload = [
            'name' => 'Company One',
            'email' => 'admin@company.com',
            'logo' => UploadedFile::fake()->image('logo.jpg', 100, 100),
            'website' => 'http://www.company-one.com',
        ];

        $response = $this->actingAs($user)->post('company', $payload);

        $company = Company::first();

        $response->assertStatus(201);
        $response->assertRedirect('company');
        $this->assertDatabaseHas('companies', [
            'name' => $payload['name'],
            'email' => $payload['email'],
            'logo' => 'company_one.jpg',
            'website' => $payload['website'],
        ]);
        self::assertEquals($payload['name'], $company->refresh()->name);
        self::assertEquals($payload['email'], $company->refresh()->email);
        self::assertEquals('company_one.jpg', $company->refresh()->logo);
        self::assertEquals($payload['website'], $company->refresh()->website);
        Storage::disk()->assertExists('/public/company_one.jpg');
    }

    /**
     * A Company cannot be stored.
     *
     * @return void
     */
    public function test_a_company_cant_be_stored_when_name_is_not_valid()
    {
        $user = User::factory()->create();
        $payload = [
            'name' => 'Company One',
            'email' => 'admin@company.com',
            'logo' => UploadedFile::fake()->image('logo.jpg', 100, 100),
            'website' => 'http://www.company-one.com',
        ];

        $response = $this->actingAs($user)->post('/company', [
            'name' => null,
            'email' => $payload['email'],
            'logo' => $payload['logo'],
            'website' => $payload['website'],
        ]);
        $response->assertStatus(302);

        $response = $this->actingAs($user)->post('/company', [
            'name' => $payload['name'],
            'email' => null,
            'logo' => $payload['logo'],
            'website' => $payload['website'],
        ]);
        $response->assertStatus(201);

        $response = $this->actingAs($user)->post('/company', [
            'name' => $payload['name'],
            'email' => $payload['email'],
            'logo' => null,
            'website' => $payload['website'],
        ]);
        $response->assertStatus(201);

        $response = $this->actingAs($user)->post('/company', [
            'name' => $payload['name'],
            'email' => $payload['email'],
            'logo' => $payload['logo'],
            'website' => null,
        ]);
        $response->assertStatus(201);
    }

    /**
     * Company show screen can be rendered.
     *
     * @return void
     */
    public function test_show_screen_can_be_rendered()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create([
            'name' => 'Company name',
            'email' => 'company@company.com',
        ]);

        $response = $this->actingAs($user)->get('/company/' . $company->id);

        $this->assertAuthenticated();
        $response->assertStatus(200);
        $response->assertSee('Company Name');
        $response->assertSee('company@company.com');
    }

    /**
     * Company edit screen can be rendered.
     *
     * @return void
     */
    public function test_edit_screen_can_be_rendered()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create([
            'name' => 'Company name',
            'email' => 'company@company.com',
        ]);

        $response = $this->actingAs($user)->get('/company/' . $company->id . '/edit');

        $this->assertAuthenticated();
        $response->assertStatus(200);
        $response->assertSee('Company name');
        $response->assertSee('company@company.com');
    }

    /**
     * A Company can be updated.
     *
     * @return void
     */
    public function test_a_company_can_be_updated()
    {
        Storage::fake();

        $user = User::factory()->create();
        $company = Company::factory()->create([
            'name' => 'Company One',
            'email' => 'admin@company-one.com',
            'logo' => UploadedFile::fake()->image('company_one.png', 150, 150),
            'website' => 'https://www.company-one.com',
        ]);
        $payload = [
            'name' => 'Company Two',
            'email' => 'admin@company-two.com',
            'logo' => UploadedFile::fake()->image('company_two.jpg', 100, 100),
            'website' => 'https://www.company-two.com',
        ];

        $response = $this->actingAs($user)->put('/company/' . $company->id, $payload);

        $response->assertStatus(201);
        $response->assertRedirect('/company');
        $this->assertDatabaseHas('companies', [
            'name' => $payload['name'],
            'email' => $payload['email'],
            'logo' => $payload['logo']->name,
            'website' => $payload['website'],
        ]);
        self::assertEquals($payload['name'], $company->refresh()->name);
        self::assertEquals($payload['email'], $company->refresh()->email);
        self::assertEquals($payload['logo']->name, $company->refresh()->logo);
        self::assertEquals($payload['website'], $company->refresh()->website);
        Storage::disk()->assertExists('/public/company_two.jpg');
    }

    /**
     * A Company cannot be updated.
     *
     * @return void
     */
    public function test_a_company_cannot_be_updated_when_the_name_is_not_valid()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['name' => 'Company One']);
        $payload = [
            'name' => 'Company One',
            'email' => 'admin@company.com',
            'logo' => UploadedFile::fake()->image('logo.jpg', 100, 100),
            'website' => 'http://www.company-one.com',
        ];

        $response = $this->actingAs($user)->put('/company/' . $company->id, [
            'name' => null,
            'email' => $payload['email'],
            'logo' => $payload['logo'],
            'website' => $payload['website'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('company');

        $response = $this->actingAs($user)->put('/company/' . $company->id, [
            'name' => $payload['name'],
            'email' => null,
            'logo' => $payload['logo'],
            'website' => $payload['website'],
        ]);
        $response->assertStatus(201);

        $response = $this->actingAs($user)->put('/company/' . $company->id, [
            'name' => $payload['name'],
            'email' => $payload['email'],
            'logo' => null,
            'website' => $payload['website'],
        ]);
        $response->assertStatus(201);

        $response = $this->actingAs($user)->put('/company/' . $company->id, [
            'name' => $payload['name'],
            'email' => $payload['email'],
            'logo' => $payload['logo'],
            'website' => null,
        ]);
        $response->assertStatus(201);
    }

    /**
     * A Company can be deleted.
     *
     * @return void
     */
    public function test_a_company_can_be_deleted()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();

        $response = $this->actingAs($user)->delete('/company/' . $company->id);

        $response->assertStatus(302);
        $response->assertRedirect('/company');
        self::assertCount(0, Company::all());
    }

    /**
     * A Company cant be deleted.
     *
     * @return void
     */
    public function test_a_company_cannot_be_deleted_when_a_register_does_not_exists()
    {
        $user = User::factory()->create();
        Company::factory()->create();

        $response = $this->actingAs($user)->delete('/company/100');

        $response->assertStatus(404);
    }

    /**
     * A pdf file can't be stored.
     *
     * @return void
     */
    public function test_a_different_file_than_an_image_cannot_be_stored()
    {
        $user = User::factory()->create();
        $payload = [
            'name' => 'Company One',
            'email' => 'admin@company.com',
            'logo' => UploadedFile::fake()->create('logo.pdf', 100, 'application/pdf'),
            'website' => 'http://www.company-one.com',
        ];

        $response = $this->actingAs($user)->post('/company', $payload);

        $response->assertStatus(302);
        $response->assertRedirect('company');
        $this->assertDatabaseMissing('companies', [
            'name' => 'Company One',
            'email' => 'admin@company.com',
            'website' => 'http://www.company-one.com',
        ]);
    }
}
