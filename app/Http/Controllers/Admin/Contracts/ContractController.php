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
use DateInterval;
use DateTime;
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

    public function getRangeTime($type, $value, $start, $finish)
    {
        //
        $start = new DateTime($start);
        $finish = new DateTime($finish);
        $result = [];
        switch ($type) {
            case 'date':
                for ($date = $start; $date <= $finish; $date->add(new DateInterval('P1D'))) {
                    if ($date->format('d') == $value) {
                        $result[] = $date->format('Y-m-d');
                    }
                }
                dd($result);
                break;
            case 'day':
                for ($date = $start; $date <= $finish; $date->add(new DateInterval('P1D'))) {
                    $weekday = date("l", strtotime($date->format('Y-m-d')));
                    if ($weekday == $value) {
                        array_push($result, $date->format('Y-m-d'));
                    }
                }
                break;
        }

        return $result;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|int',
            'start' => 'required|date',
            'finish' => 'required|date',
            'content' => 'required|string',
            'task_type' => 'nullable|array',
            // 0 - elec, 1 - water, 2 - air
            'task_type.*' => 'nullable|in:0,1,2',
            'type_elec' => 'nullable|in:date,day',
            'value_elec' => 'nullable',
            'type_water' => 'nullable|in:date,day',
            'value_water' => 'nullable',
            'type_air' => 'nullable|in:date,day',
            'value_air' => 'nullable',
        ]);
        dd($this->getRangeTime($data['type_elec'], $data['value_elec'], $data['start'], $data['finish']));
        try {
            DB::beginTransaction();
            $contract = Contract::create([
                'customer_id' =>  $data['customer_id'],
                'start' =>  $data['start'],
                'finish' =>  $data['finish'],
                'content' =>  $data['content'],
            ]);
            if (!empty($data['task_type'])) {
                foreach ($data['task_type'] as $type) {
                    switch ((int)$type) {
                            // create electric task
                        case 0:
                            $rangeTime = $this->getRangeTime($data['type_elec'], $data['value_elec'], $data['start'], $data['finish']);
                            $data = [];
                            foreach($rangeTime as $time) {
                                $data [] = [
                                    ''
                                ];
                            };
                            break;
                        case 1:
                            break;
                        case 2:
                            break;
                    };
                }
            }
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
