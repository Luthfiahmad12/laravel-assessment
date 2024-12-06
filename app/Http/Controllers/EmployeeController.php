<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Employee::query()
            ->lazyById(200, column: 'id')
            ->map(function ($employee) {
                $skills = json_decode($employee->skills);
                $employee->skills = implode(", ", $skills);
                return $employee;
            });

        return view('employee.index', [
            'employees' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'avatar' => 'required',
            'hire_date' => 'required|date',
            'skills' => 'required',
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'failed',
                'errors' => $validator->errors()
            ], 422);
        } else {
            $data = $validator->validated();
            Employee::create($data);
            return response()->json([
                'message' => 'success'
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        if (!filter_var($employee->avatar, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($employee->avatar);
        }
        $employee->delete();
        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function uploadTemp(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('temp', 'public');
            return response()->json(['path' => $path], 200);
        }
        return response()->json(['error' => 'File not uploaded'], 400);
    }

    public function deleteTemp(Request $request)
    {
        $filePath = $request->get('path');
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            return response()->json(['message' => 'File deleted'], 200);
        }
        return response()->json(['error' => 'File not found'], 404);
    }
}
