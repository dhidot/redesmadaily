<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('positions.index', [
            'title' => 'Jabatan'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('positions.create', [
            'title' => 'Tambah Data Jabatan'
        ]);
    }

    public function edit(Position $position)
    {
        $ids = request('ids');
        if (!$ids) {
            return redirect()->back();
        }
        $ids = explode('-', $ids);

        $positions = Position::query()
            ->whereIn('id', $ids)
            ->get();

        return view('positions.edit', [
            'title' => 'Edit Data Jabatan',
            'positions' => $positions
        ]);
    }
}
