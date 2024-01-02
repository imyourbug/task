<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\AirTask;
use App\Models\ElecTask;
use App\Models\Task;
use App\Models\WaterTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Sheets;
use Throwable;
use Toastr;

class TaskController extends Controller
{
    public function index()
    {
        $id = Auth::id();

        return view('user.task.list', [
            'title' => 'Danh sách nhiệm vụ',
            'electasks' => ElecTask::where('user_id', $id)->orderByDesc('created_at')->get(),
            'airtasks' => AirTask::where('user_id', $id)->orderByDesc('created_at')->get(),
            'watertasks' => WaterTask::where('user_id', $id)->orderByDesc('created_at')->get(),
        ]);
    }

    public function taskToday()
    {
        $id = Auth::id();
        $today = now()->format('Y-m-d');
        $electasks = ElecTask::where('plan_date', $today)
            ->where('user_id', $id)
            ->orderByDesc('created_at')
            ->get();
        $airtasks = AirTask::where('plan_date', $today)
            ->where('user_id', $id)
            ->orderByDesc('created_at')
            ->get();
        $watertasks = WaterTask::where('plan_date', $today)
            ->where('user_id', $id)
            ->orderByDesc('created_at')
            ->get();

        return view('user.task.list', [
            'title' => 'Nhiệm vụ hôm nay: ' . now()->format('d-m-Y'),
            'electasks' => $electasks,
            'airtasks' => $airtasks,
            'watertasks' => $watertasks,
        ]);
    }

    public function updateElecTask(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|numeric',
                'amount' => 'required|numeric|min:0',
            ]);
            unset($data['id']);
            ElecTask::where('id', $request->input('id'))->update($data);

            return response()->json([
                'status' => 0,
                'message' => 'Cập nhật thành công'
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateWaterTask(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|numeric',
                'asen' => 'required|numeric|min:0',
                'stiffness' => 'required|numeric|min:0',
                'ph' => 'required|numeric|min:0',
            ]);
            // dd($data);
            unset($data['id']);
            WaterTask::where('id', $request->input('id'))->update($data);

            return response()->json([
                'status' => 0,
                'message' => 'Cập nhật thành công'
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateAirTask(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|numeric',
                'dissolve' => 'required|numeric|min:0',
                'fine_dust' => 'required|numeric|min:0',
            ]);
            unset($data['id']);
            AirTask::where('id', $request->input('id'))->update($data);

            return response()->json([
                'status' => 0,
                'message' => 'Cập nhật thành công'
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function download()
    {
        $storagePath = storage_path('app/public/excel/' . env('NEW_FILE_INPUT', 'new_input.xlsx'));

        if (file_exists($storagePath)) {
            return response()->download($storagePath);
        }
    }
}
