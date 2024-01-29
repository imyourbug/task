<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaskSolution;
use Illuminate\Http\Request;
use Throwable;

class TaskSolutionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'unit' => 'required|string',
            'kpi' => 'required|numeric',
            'task_id' => 'required|numeric',
            'solution_id' => 'required|numeric',
        ]);
        try {
            TaskSolution::create($data);
            return response()->json([
                'status' => 0,
                'message' => 'Tạo thành công'
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|numeric',
            'unit' => 'required|string',
            'kpi' => 'required|numeric',
            // 'task_id' => 'required|numeric',
            'solution_id' => 'required|numeric',
        ]);
        unset($data['id']);
        try {
            TaskSolution::where('id', $request->input('id'))->update($data);
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

    public function index(Request $request)
    {
        return response()->json([
            'status' => 0,
            'taskSolutions' => TaskSolution::with(['task', 'solution'])->where('task_id', $request->id)->get(),
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'status' => 0,
            'taskSolution' => TaskSolution::with(['task', 'solution'])->firstWhere('id', $id),
        ]);
    }

    public function destroy($id)
    {
        try {
            TaskSolution::firstWhere('id', $id)->delete();

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
