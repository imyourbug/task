<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Map;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Toastr;

class MapController extends Controller
{
    public function create()
    {
        return view('admin.map.add', [
            'title' => 'Thêm sơ đồ'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'nullable|string',
            'position' => 'nullable|string',
            'number' => 'required|numeric|min:1',
            'area' => 'required|string',
            'target' => 'nullable|string',
            'image' => 'nullable|string',
            'description' => 'nullable|string',
            'active' => 'required|in:0,1',
        ]);
        // dd($data);
        $dataInsert = [];
        $number = (int)$data['number'];
        unset($data['number']);
        for ($i = 0; $i < $number; $i++) {
            $dataInsert[] = $data;
        }
        try {
            Map::insert($dataInsert);
            Toastr::success('Tạo sơ đồ thành công', 'Thông báo');
        } catch (Throwable $e) {
            dd($e);
            Toastr::error('Tạo sơ đồ thất bại', 'Thông báo');
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|numeric',
            'code' => 'required|string',
            'position' => 'nullable|string',
            'area' => 'nullable|string',
            'target' => 'nullable|string',
            'image' => 'nullable|string',
            'description' => 'nullable|string',
            'active' => 'required|in:0,1',
        ]);
        unset($data['id']);
        $update = Map::where('id', $request->input('id'))->update($data);
        if ($update) {
            Toastr::success(__('message.success.update'), 'Thông báo');
        } else Toastr::error(__('message.fail.update'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'status' => 0,
                'maps' => Map::all(),
            ]);
        }

        return view('admin.map.list', [
            'title' => 'Danh sách sơ đồ',
            'maps' => Map::all(),
            'setting' => Setting::firstWhere('key', 'map')
        ]);
    }

    public function show($id)
    {
        return view('admin.map.edit', [
            'title' => 'Chi tiết sơ đồ',
            'map' => Map::firstWhere('id', $id)
        ]);
    }

    public function destroy($id)
    {
        try {
            Map::firstWhere('id', $id)->delete();

            return response()->json([
                'status' => 0,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }
}
