<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Display a listing of the reports.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $reports = Report::with('user')->get();
        return response()->json([
            'success' => true,
            'data' => $reports,
        ], 200);
    }

    /**
     * Show the report form for web users.
     *
     * @return \Illuminate\View\View
     */
    public function showForm()
    {
        return view('report.index');
    }

    /**
     * Handle the creation of a new report from web form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'what_happened' => 'required|string',
            'when_happened' => 'nullable|date',
            'report_role' => 'required|in:mahasiswa,staff,dosen',
            'evidence_path' => 'nullable|file|max:2048',
            'predator_role' => 'required|in:mahasiswa,staff,dosen',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->except('evidence_path');

        if ($request->hasFile('evidence_path')) {
            $file = $request->file('evidence_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('evidence', $filename);
            $data['evidence_path'] = $path;
        }

        $report = Report::create($data);

        return redirect()->route('report.index')->with('success', 'Report created successfully.');
    }

    /**
     * Display the specified report.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Report $report): JsonResponse
    {
        $report->load('user');

        return response()->json([
            'success' => true,
            'data' => $report,
        ], 200);
    }
}
