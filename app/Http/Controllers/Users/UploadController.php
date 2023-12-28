<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Sheets;
use Toastr;


class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $user_id = Auth::id();
        $check_doing_task = Task::where('user_id', $user_id)->where('status', 0)->get();
        if ($check_doing_task->count() > 0) {
            Toastr::error(__('message.fail.add'), __('title.toastr.fail'));
            return redirect()->back();
        }
        $type = $request->input('code_freeship', '');
        $sheet = Sheets::spreadsheet(env('LINK_SHEET', '1qErf8Hu4gZWHLiqU6t7hL7ZuLTe7yZ3vW8pj0hI1lGE'))
            ->sheet(env('SHEET_NAME', 'Demo'))->get();
        $sheet->pull(0);
        $values = Sheets::all();
        $tasks = Task::select('id_task')->get()->toArray();
        unset($values[0]);
        foreach ($values as $v) {
            if (!in_array($v[0], array_column($tasks, 'id_task')) && $v[14] == 0 && Str::slug($v[12]) == $type) {
                Task::create([
                    'id_task' => $v[0],
                    'name' => $v[1],
                    'password' => $v[2],
                    'cod' => $v[3],
                    'receiver' => $v[4],
                    'phone_receiver' => $v[5],
                    // 'phone_otp' => $v[6],
                    'address' => $v[7],
                    'ward' => $v[8],
                    'district' => $v[9],
                    'province' => $v[10],
                    'link' => $v[11],
                    'code' => $v[12],
                    'wage' => $v[13],
                    'user_id' => $user_id
                ]);
                Toastr::success(__('message.success.add'), __('title.toastr.success'));

                return redirect()->back();
            }
        }
        Toastr::error(__('message.fail.add'), __('title.toastr.fail'));
        return redirect()->back();
    }
}
