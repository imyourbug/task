<?php

namespace App\Http\Controllers\Admin\Contracts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Accounts\CreateAccountRequest;
use App\Http\Requests\Admin\Accounts\UpdateAccountRequest;
use App\Models\AirTask;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\ElecTask;
use App\Models\InfoUser;
use App\Models\TaskType;
use App\Models\User;
use App\Models\WaterTask;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;
use Toastr;

class ContractController extends Controller
{
    public function create()
    {
        return view('admin.contract.add', [
            'title' => 'Thêm hợp đồng',
            'customers' => Customer::all(),
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
                switch ((int)$value) {
                    case 0:
                        for ($date = $start; $date <= $finish; $date->add(new DateInterval('P1W'))) {
                            if (!in_array($date->format('Y-m-t'), $result)) {
                                $result[] = $date->format('Y-m-t');
                            }
                        }
                        break;
                    default:
                        for ($date = $start; $date <= $finish; $date->add(new DateInterval('P1D'))) {
                            if ($date->format('d') == $value) {
                                $result[] = $date->format('Y-m-d');
                            }
                        }
                        break;
                }
            case 'day':
                for ($date = $start; $date <= $finish; $date->add(new DateInterval('P1D'))) {
                    $weekday = date('l', strtotime($date->format('Y-m-d')));
                    if ($weekday == $value) {
                        $result[] = $date->format('Y-m-d');
                    }
                }
                break;
        }

        return $result;
    }

    public function createTask($rangeTime, $taskType, $contractId)
    {
        $data = [];
        foreach ($rangeTime as $time) {
            $data[] = [
                'plan_date' => $time,
                'contract_id' => $contractId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        };
        dispatch(function () use ($data, $taskType) {
            $taskType == 0 ?  ElecTask::insert($data) : ($taskType == 1 ?
                WaterTask::insert($data) :  AirTask::insert($data));
        });
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'customer_id' => 'required|numeric',
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

            DB::beginTransaction();
            $contract = Contract::create([
                'name' =>  $data['name'],
                'customer_id' =>  $data['customer_id'],
                'start' =>  $data['start'],
                'finish' =>  $data['finish'],
                'content' =>  $data['content'],
            ]);
            if (!empty($data['task_type'])) {
                DB::disableQueryLog();
                foreach ($data['task_type'] as $type) {
                    $rangeTime = [];
                    switch ((int)$type) {
                            // create electric task
                        case 0:
                            $rangeTime = $this->getRangeTime($data['type_elec'], $data['value_elec'], $data['start'], $data['finish']);
                            break;
                            // create water task
                        case 1:
                            $rangeTime = $this->getRangeTime($data['type_water'], $data['value_water'], $data['start'], $data['finish']);
                            break;
                            // create air task
                        case 2:
                            $rangeTime = $this->getRangeTime($data['type_air'], $data['value_air'], $data['start'], $data['finish']);
                            break;
                    };
                    $this->createTask($rangeTime, $type, $contract->id);
                }
                DB::enableQueryLog();
            }
            DB::commit();

            return [
                'status' => 0,
                'message' => 'Tạo hợp đồng thành công'
            ];
        } catch (Throwable $e) {
            DB::rollBack();

            return [
                'status' => 1,
                'message' => $e->getMessage()
            ];
        }
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|numeric',
            'id' => 'required|numeric',
            'content' => 'required|string',
        ]);
        unset($data['id']);
        $update = Contract::firstWhere('id', $request->input('id'))->update($data);
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
            'contracts' => Contract::with('customer')->get(),
        ]);
    }

    public function show($id)
    {
        return view('admin.contract.edit', [
            'title' => 'Chi tiết hợp đồng',
            'contract' => Contract::firstWhere('id', $id),
            'customers' => Customer::all()
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
