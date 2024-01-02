<?php

namespace App\Http\Controllers\Admin\WaterTasks;

use App\Constant\GlobalConstant;
use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\InfoUser;
use App\Models\User;
use App\Models\WaterTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Toastr;

class WaterTaskController extends Controller
{
    public function create()
    {
        return view('admin.watertask.add', [
            'title' => 'Thêm nhiệm vụ',
            'staffs' => User::with('staff')->where('role', GlobalConstant::ROLE_STAFF)->get(),
            'contracts' => Contract::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'asen' => 'required|numeric|min:0',
            'ph' => 'required|numeric|min:0',
            'stiffness' => 'required|numeric|min:0',
            'plan_date' => 'required|date',
            'contract_id' => 'required|numeric',
            'user_id' => 'nullable|numeric',
        ]);
        try {
            WaterTask::create($data);
            Toastr::success('Tạo nhiệm vụ thành công', 'Thông báo');
        } catch (Throwable $e) {
            dd($e);
            Toastr::error('Tạo nhiệm vụ thất bại', 'Thông báo');
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|numeric',
            'asen' => 'required|numeric|min:0',
            'ph' => 'required|numeric|min:0',
            'stiffness' => 'required|numeric|min:0',
            'plan_date' => 'required|date',
            'contract_id' => 'required|numeric',
            'user_id' => 'nullable|numeric',
        ]);
        unset($data['id']);
        $update = WaterTask::where('id', $request->input('id'))->update($data);
        if ($update) {
            Toastr::success(__('message.success.update'), __('title.toastr.success'));
        } else Toastr::error(__('message.fail.update'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function index()
    {
        return view('admin.watertask.list', [
            'title' => 'Danh sách nhiệm vụ',
            'tasks' => WaterTask::with(['contract', 'user'])->get()
        ]);
    }

    public function show($id)
    {
        return view('admin.watertask.edit', [
            'title' => 'Chi tiết nhiệm vụ',
            'task' => WaterTask::firstWhere('id', $id),
            'staffs' => User::with('staff')->where('role', GlobalConstant::ROLE_STAFF)->get(),
            'contracts' => Contract::all()
        ]);
    }

    public function destroy($id)
    {
        try {
            WaterTask::firstWhere('id', $id)->delete();

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
