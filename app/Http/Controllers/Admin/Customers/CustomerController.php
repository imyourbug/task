<?php

namespace App\Http\Controllers\Admin\Customers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Toastr;

class CustomerController extends Controller
{
    public function create()
    {
        return view('admin.customer.add', [
            'title' => 'Thêm khách hàng'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'tel' => 'required|string|regex:/^0\d{9,10}$/',
            'fax' => 'required|string',
        ]);
        try {
            Customer::create($data);
            Toastr::success('Tạo khách hàng thành công', 'Thông báo');
        } catch (Throwable $e) {
            dd($e);
            Toastr::error('Tạo khách hàng thất bại', 'Thông báo');
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|int',
            'name' => 'required|string',
            'address' => 'required|string',
            'tel' => 'required|string|regex:/^0\d{9,10}$/',
            'fax' => 'required|string',
        ]);
        unset($data['id']);
        $update = Customer::where('id', $request->input('id'))->update($data);
        if ($update) {
            Toastr::success(__('message.success.update'), __('title.toastr.success'));
        } else Toastr::error(__('message.fail.update'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function delete($id)
    {
        $delete = Customer::firstWhere('id', $id)->delete();
        if ($delete) {
            Toastr::success(__('message.success.delete'), __('title.toastr.success'));
        } else Toastr::error(__('message.fail.delete'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function index()
    {
        return view('admin.customer.list', [
            'title' => 'Danh sách khách hàng',
            'customers' => Customer::all()
        ]);
    }

    public function show($id)
    {
        return view('admin.customer.edit', [
            'title' => 'Chi tiết khách hàng',
            'customer' => Customer::firstWhere('id', $id)
        ]);
    }

    public function destroy($id)
    {
        try {
            Customer::firstWhere('id', $id)->delete();

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
