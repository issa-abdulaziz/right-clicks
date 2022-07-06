<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;

class DepartmentController extends Controller
{

    public function index()
    {
        $departments = Department::all();
        return view('department.index', compact('departments'));
    }

    public function store(DepartmentRequest $request)
    {
        Department::create([
            'name' => $request->name,
        ]);
        return redirect()->route('department.index')->with('success', 'Department Added Successfully');
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $department->update([
            'name' => $request->name,
        ]);
        return redirect()->route('department.index')->with('success', 'Department Updated Successfully');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('department.index')->with('success', 'Department Deleted Successfully');
    }
}
