<?php

namespace Tests\Unit\Models;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class CompanyTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A Company has many employees
     *
     * @return void
     */
    public function test_it_has_many_employees()
    {
        $company = Company::factory()->create();

        Employee::factory(5)->create([
            'company_id' => $company->id,
        ]);

        $this->assertInstanceOf(Collection::class, $company->refresh()->employees);
        $this->assertCount(5, $company->refresh()->employees->all());
    }
}
