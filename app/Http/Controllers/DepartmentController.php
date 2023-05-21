<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('departments.index', [
            'title' => 'Departemen'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departments.create', [
            'title' => 'Tambah Data Departemen / Divisi'
        ]);
    }

    public function edit()
    {
        $ids = request('ids');
        if (!$ids)
            return redirect()->back();
        $ids = explode('-', $ids);

        $departments = Department::query()
            ->whereIn('id', $ids)
            ->get();

        return view('departments.edit', [
            'title' => 'Edit Data Departemen / Divisi',
            'departments' => $departments
        ]);
    }
}
