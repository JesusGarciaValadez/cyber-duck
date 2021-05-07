<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Throwable;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('employee.index')
            ->with('employees', Employee::latest()->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('employee.create')
            ->with('companies', Company::orderBy('created_at', 'desc')->get(['id', 'name']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EmployeeRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(EmployeeRequest $request)
    {
        Employee::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'company_id' => $request->company_id,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect('employee', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Employee $employee
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function show(Employee $employee)
    {
        return view('employee.show')
            ->with('employee', $employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Employee $employee
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Employee $employee)
    {
        return view('employee.edit')
            ->with('employee', $employee)
            ->with('companies', Company::orderBy('created_at', 'desc')->get(['id', 'name']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmployeeRequest $request
     * @param Employee $employee
     * @return Application|RedirectResponse|Redirector
     * @throws Throwable
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        $employee->fill([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'company_id' => $request->company_id,
            'email' => $request->email,
            'phone' => $request->phone,
        ])->saveOrFail();

        return redirect('employee', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Employee $employee
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect('employee', 302);
    }
}
