<?php

namespace App\Http\Controllers\Admin\TaskTypes;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\TaskType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Toastr;

class TaskTypeController extends Controller
{
    public function create()
    {
        return view('admin.tasktype.add', [
            'title' => 'Thêm loại nhiệm vụ'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);
        try {
            TaskType::create($data);
            Toastr::success('Tạo loại nhiệm vụ thành công', 'Thông báo');
        } catch (Throwable $e) {
            dd($e);
            Toastr::error('Tạo loại nhiệm vụ thất bại', 'Thông báo');
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|int',
            'name' => 'required|string',
        ]);
        unset($data['id']);
        $update = TaskType::where('id', $request->input('id'))->update($data);
        if ($update) {
            Toastr::success(__('message.success.update'), __('title.toastr.success'));
        } else Toastr::error(__('message.fail.update'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function delete($id)
    {
        $delete = TaskType::firstWhere('id', $id)->delete();
        if ($delete) {
            Toastr::success(__('message.success.delete'), __('title.toastr.success'));
        } else Toastr::error(__('message.fail.delete'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function index()
    {
        return view('admin.tasktype.list', [
            'title' => 'Danh sách loại nhiệm vụ',
            'task_types' => TaskType::all()
        ]);
    }

    public function show($id)
    {
        return view('admin.tasktype.edit', [
            'title' => 'Chi tiết loại nhiệm vụ',
            'task_type' => TaskType::firstWhere('id', $id)
        ]);
    }

    public function destroy($id)
    {
        try {
            TaskType::firstWhere('id', $id)->delete();

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
