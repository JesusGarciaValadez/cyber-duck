<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Throwable;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('company.index')
            ->with('companies', Company::latest()->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyRequest $request
     * @return Application|Redirector|RedirectResponse
     */
    public function store(CompanyRequest $request)
    {
        Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'logo' => $this->storeLogo($request),
            'website' => $request->website,
        ]);

        return redirect('company', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Company $company
     * @return Application|Factory|View
     */
    public function show(Company $company)
    {
        return view('company.show')
            ->with('company', $company);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Company $company
     * @return Application|Factory|View
     */
    public function edit(Company $company)
    {
        return view('company.edit')
            ->with('company', $company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyRequest $request
     * @param Company $company
     * @return Application|RedirectResponse|Redirector
     * @throws Throwable
     */
    public function update(CompanyRequest $request, Company $company)
    {
        $company->fill([
            'name' => $request->name,
            'email' => $request->email,
            'logo' => $this->storeLogo($request),
            'website' => $request->website,
        ])->saveOrFail();

        return redirect('company', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect('company', 302);
    }

    /**
     * @param CompanyRequest $request
     * @return null|string
     */
    protected function storeLogo(Request $request)
    {
        if (empty($request->logo) || !$request->file('logo')->isValid()) {
            return null;
        }

        $imageName = strtolower(str_replace(' ', '_', $request->name)) . '.' . $request->logo->extension();
        $imagePath = $request->logo->storePubliclyAs('public', $imageName);

        return str_replace('public/', '', $imagePath);
    }
}
