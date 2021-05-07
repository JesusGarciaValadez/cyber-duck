<?php

namespace Tests\Unit\Models;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * An Employee belongs to a Company
     *
     * @return void
     */
    public function test_it_belongs_to_a_company()
    {
        $company = Company::factory()->create();

        $employee = Employee::factory()->create([
            'company_id' => $company->id,
        ]);

        $this->assertInstanceOf(Company::class, $employee->company);
        $this->assertEquals($company->id, $employee->company->id);
    }

    /**
     * An Employee have a full name.
     *
     * @return void
     */
    public function test_it_haves_a_full_name()
    {
        $company = Company::factory()->create();

        $employee = Employee::factory()->create([
            'first_name' => 'first',
            'last_name' => 'last',
            'company_id' => $company->id,
        ]);

        $this->assertEquals('first last', $employee->fullName);
    }
}
