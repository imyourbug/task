<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Sheets;
use Toastr;

class TaskController extends Controller
{
    public function create()
    {
        return view('user.task.add', [
            'title' => 'Add task'
        ]);
    }

    public function update($id, Request $request)
    {
        $id_order = $request->id_order ?? 0;
        $task = Task::firstWhere('id', $id);
        $update = $task->update([
            'status' => 1,
            'id_order' => $id_order,
        ]);
        // update result in gg sheet api
        // 1qErf8Hu4gZWHLiqU6t7hL7ZuLTe7yZ3vW8pj0hI1lGE
        $sheet = Sheets::spreadsheet(env('LINK_SHEET', '1qErf8Hu4gZWHLiqU6t7hL7ZuLTe7yZ3vW8pj0hI1lGE'))->sheet(env('SHEET_NAME', 'Demo'))->get();
        $header = $sheet->pull(0);
        $values = Sheets::all();
        // clear data sheet
        $sheet = Sheets::spreadsheet(env('LINK_SHEET', '1qErf8Hu4gZWHLiqU6t7hL7ZuLTe7yZ3vW8pj0hI1lGE'))->sheet(env('SHEET_NAME', 'Demo'))->clear();
        // write header sheet
        Sheets::sheet(env('SHEET_NAME', 'Demo'))->append([$values[0]]);
        unset($values[0]);
        $index = -1;
        foreach ($values as $key => $v) {
            if ($v[0] == $task->id_task) {
                $index = $key;
            }
        }
        if ($index != -1) {
            $values[$index][14] = 1;
            $values[$index][15] = $id_order;
        }

        // write data sheet
        Sheets::sheet(env('SHEET_NAME', 'Demo'))->append([...$values]);
        // add wage
        $add_wage = Auth::user()->increment('balance', (int)$task->wage);

        if ($update && $add_wage) {
            Toastr::success(__('message.success.update'), __('title.toastr.success'));
        } else Toastr::error(__('message.fail.update'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function display($id)
    {
        $update = Task::firstWhere('id', $id)
            ->update([
                'is_display_otp' => 1
            ]);
        $sheet = Sheets::spreadsheet(env('LINK_SHEET', '1qErf8Hu4gZWHLiqU6t7hL7ZuLTe7yZ3vW8pj0hI1lGE'))->sheet(env('SHEET_NUMBER_PHONE', 'Numberphone'))->get();
        $header = $sheet->pull(0);
        $values = Sheets::all();
        foreach ($values as $v) {
            if ($v[1] == 0) {
                return response()->json([
                    'status' => 0,
                    'number_phone' => $v[0],
                ]);
            }
        }

        return response()->json([
            'status' => 1,
            'message' => 'Đã hết số điện thoại lấy OTP',
        ]);
    }

    public function destroy($id)
    {
        $delete = Task::firstWhere('id', $id)->delete();
        if ($delete) {
            Toastr::success(__('message.success.delete'), __('title.toastr.success'));
        } else Toastr::error(__('message.fail.delete'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function index()
    {
        $id = Auth::id();

        return view('user.task.list', [
            'title' => 'Danh sách',
            'tasks' => Task::where('user_id', $id)->orderByDesc('created_at')->get()
        ]);
    }

    public function download()
    {
        $storagePath = storage_path('app/public/excel/' . env('NEW_FILE_INPUT', 'new_input.xlsx'));

        if (file_exists($storagePath)) {
            return response()->download($storagePath);
        }
    }

    public function getQuantityByType(Request $request)
    {
        $sheet = Sheets::spreadsheet(env('LINK_SHEET', '1qErf8Hu4gZWHLiqU6t7hL7ZuLTe7yZ3vW8pj0hI1lGE'))->sheet(env('SHEET_NAME', 'Demo'))->get();
        $header = $sheet->pull(0);
        $values = Sheets::all();
        $count = 0;
        $tasks = Task::select('id_task')->get()->toArray();
        foreach ($values as $v) {
            if (!in_array($v[0], array_column($tasks, 'id_task')) && Str::slug($v[12]) == $request->type && $v[14] == 0) {
                $count++;
            }
        }

        return response()->json([
            'quantity' => $count,
        ]);
    }

    public function getOTP(Request $request)
    {
        $number_phone = $request->number_phone;
        $response = Http::withHeaders([
            'x-api-key' => env('API_KEY_OTP', 'jhxhfdvx08d1zdy32j6cc1udxh5set'),
        ])
            ->get(env('URL_GET_SMS_BY_NUMBER_PHONE', 'https://apigsm.shop/v1/api/sms/') . $number_phone);
        $result = json_decode($response->body());
        if (!$result || count($result->messages) == 0) {
            return response()->json([
                'status' => 1,
                'message' => 'Số điện thoại chưa có tin nhắn OTP'
            ]);
        }
        $otp =  '';
        // if (preg_match("/QUY KHACH KHONG GUI MA OTP CHO BAT KY AI/", $result->messages[0]->content)) {
        // }
        $otp = $result->messages[0]->otp;

        return response()->json([
            'status' => 0,
            'otp' => $otp ?? '',
        ]);
    }

    public function updateOTP(Request $request)
    {
        $task = Task::firstWhere('id', $request->id);
        $otp = $request->otp;
        $number_phone = $request->number_phone;
        $task->update([
            'otp' => $otp,
            'phone_otp' => $number_phone,
        ]);
        // update gg sheet
        // update result in gg sheet api
        $sheet = Sheets::spreadsheet(env('LINK_SHEET', '1qErf8Hu4gZWHLiqU6t7hL7ZuLTe7yZ3vW8pj0hI1lGE'))->sheet(env('SHEET_NAME', 'Demo'))->get();
        $header = $sheet->pull(0);
        $values = Sheets::all();
        // clear data sheet
        $sheet = Sheets::spreadsheet(env('LINK_SHEET', '1qErf8Hu4gZWHLiqU6t7hL7ZuLTe7yZ3vW8pj0hI1lGE'))->sheet(env('SHEET_NAME', 'Demo'))->clear();
        // write header sheet
        Sheets::sheet(env('SHEET_NAME', 'Demo'))->append([$header]);
        unset($values[0]);
        $new_values = [];
        foreach ($values as $key => $v) {
            if (!isset($v[15])) {
                $v[15] = '';
            }
            if ($v[0] == $task->id_task) {
                // update number phone get otp sheet 1
                $v[6] = $number_phone;
                // update otp sheet 1
                $v[16] = $otp;
            }
            if (!isset($v[16])) {
                $v[16] = '';
            }
            array_push($new_values, $v);
        }

        // write data sheet
        Sheets::sheet(env('SHEET_NAME', 'Demo'))->append([...$new_values]);

        // update sheet 2
        $this->updateStatusNumberPhoneGetOTP($number_phone ?? '');

        return response()->json([
            'status' => 0,
        ]);
    }

    public function updateStatusNumberPhoneGetOTP(string $number_phone)
    {
        // update gg sheet
        // update result in gg sheet api
        $sheet = Sheets::spreadsheet(env('LINK_SHEET', '1qErf8Hu4gZWHLiqU6t7hL7ZuLTe7yZ3vW8pj0hI1lGE'))->sheet(env('SHEET_NUMBER_PHONE', 'Numberphone'))->get();
        $header = $sheet->pull(0);
        $values = Sheets::all();
        // clear data sheet
        $sheet = Sheets::spreadsheet(env('LINK_SHEET', '1qErf8Hu4gZWHLiqU6t7hL7ZuLTe7yZ3vW8pj0hI1lGE'))->sheet(env('SHEET_NUMBER_PHONE', 'Numberphone'))->clear();
        // write header sheet
        Sheets::sheet(env('SHEET_NUMBER_PHONE', 'Numberphone'))->append([$header]);
        unset($values[0]);
        $new_values = [];
        foreach ($values as $v) {
            if ($v[0] == $number_phone) {
                // update status number phone get otp sheet 2 to done
                $v[1] = 1;
            }
            array_push($new_values, $v);
        }
        // write data sheet
        Sheets::sheet(env('SHEET_NUMBER_PHONE', 'Numberphone'))->append([...$new_values]);
    }
}
