<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function edit()
    {
        return view('employer.company', ['company' => auth()->user()->company]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'website' => 'nullable|url|max:200',
            'location' => 'nullable|string|max:120',
            'description' => 'nullable|string|max:3000',
        ]);

        $request->user()->company->update($data);

        return back()->with('success', 'Company profile saved.');
    }
}
