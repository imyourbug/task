<?php

namespace App\Http\Controllers\Admin\Contracts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Accounts\CreateAccountRequest;
use App\Http\Requests\Admin\Accounts\UpdateAccountRequest;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\InfoUser;
use App\Models\TaskType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Toastr;

class ContractController extends Controller
{
    public function create()
    {
        return view('admin.contract.add', [
            'title' => 'Thêm hợp đồng',
            'customers' => Customer::all(),
            'tasktypes' => TaskType::all(),
        ]);
    }

    public function store(CreateAccountRequest $request)
    {
        $tel_or_email = $request->input('tel_or_email');
        $check = Contract::where(is_numeric($tel_or_email) ? 'name' : 'email', $tel_or_email)
            ->get();
        if ($check->count() > 0) {
            Toastr::error('Hợp đồng đã có người đăng ký!', __('title.toastr.fail'));

            return redirect()->back();
        }
        try {
            DB::beginTransaction();
            $Contract = Contract::create([
                is_numeric($tel_or_email) ? 'name' : 'email' =>  $tel_or_email,
                'password' => Hash::make($request->input('password'))
            ]);
            switch ((int) $request->role) {
                case 0:
                    InfoContract::create([
                        'name' =>  $tel_or_email,
                        'contract_id' => $Contract->id
                    ]);
                    break;
                case 2:
                    Customer::create([
                        'name' =>  $tel_or_email,
                        'contract_id' => $Contract->id
                    ]);
                    break;
                default:
                    break;
            };
            Toastr::success('Tạo hợp đồng thành công', 'Thông báo');
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            Toastr::error('Tạo hợp đồng thất bại', 'Thông báo');
        }

        return redirect()->back();
    }

    public function update(UpdateAccountRequest $request)
    {
        $data = $request->validated();
        unset($data['id']);
        $update = Contract::where('id', $request->input('id'))->update($data);
        if ($update) {
            Toastr::success(__('message.success.update'), __('title.toastr.success'));
        } else Toastr::error(__('message.fail.update'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function delete($id)
    {
        $delete = Contract::firstWhere('id', $id)->delete();
        if ($delete) {
            Toastr::success(__('message.success.delete'), __('title.toastr.success'));
        } else Toastr::error(__('message.fail.delete'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function index()
    {
        return view('admin.contract.list', [
            'title' => 'Danh sách hợp đồng',
            'contracts' => Contract::all(),
        ]);
    }

    public function show($id)
    {
        return view('admin.contract.edit', [
            'title' => 'Chi tiết hợp đồng',
            'contract' => Contract::firstWhere('id', $id)
        ]);
    }

    public function destroy($id)
    {
        try {
            Contract::firstWhere('id', $id)->delete();

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
