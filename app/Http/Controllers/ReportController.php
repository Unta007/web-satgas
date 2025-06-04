<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan formulir untuk membuat laporan baru.
     *
     * @return \Illuminate\View\View
     */
    public function showForm()
    {
        // Pastikan path view 'user.report' menunjuk ke file blade formulir Anda
        return view('user.report');
    }

    /**
     * Menyimpan laporan baru yang dibuat dari formulir web.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'what_happened' => 'required|string|max:60000',
            'where_happened' => 'required|string|max:255',
            'when_happened' => 'required|date',
            'reporter_role' => ['required', Rule::in(['mahasiswa', 'staff', 'dosen', 'lainnya'])],
            'has_witness' => ['required', Rule::in(['yes', 'no'])],
            'witness_name' => 'nullable|string|max:255|required_if:has_witness,yes',
            'witness_relation' => ['nullable', 'string', Rule::in(['teman', 'rekan_kerja', 'keluarga', 'tidak_kenal', 'lainnya']), 'required_if:has_witness,yes'],
            'knows_perpetrator' => ['required', Rule::in(['yes', 'no'])],
            'perpetrator_name' => 'nullable|string|max:255|required_if:knows_perpetrator,yes',
            'perpetrator_role' => [
                'required_if:knows_perpetrator,yes',
                Rule::in(['mahasiswa', 'staff', 'dosen', 'lainnya', 'tidak_diketahui'])
            ],
            'evidence' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'agreement' => 'accepted',
        ];

        $messages = [
            'what_happened.required' => 'Mohon jelaskan apa yang terjadi.',
            'where_happened.required' => 'Mohon isi lokasi kejadian.',
            'when_happened.required' => 'Mohon isi waktu kejadian.',
            'reporter_role.required' => 'Mohon pilih status Anda sebagai pelapor.',
            'has_witness.required' => 'Mohon pilih apakah ada saksi.',
            'witness_name.required_if' => 'Nama saksi wajib diisi jika Anda menyatakan ada saksi.',
            'witness_relation.required_if' => 'Hubungan dengan saksi wajib diisi jika Anda menyatakan ada saksi.',
            'knows_perpetrator.required' => 'Mohon pilih apakah Anda mengetahui identitas terlapor.',
            'perpetrator_name.required_if' => 'Nama terlapor wajib diisi jika Anda mengetahui identitasnya.',
            'perpetrator_role.required_if' => 'Status terlapor wajib diisi jika Anda mengetahui identitasnya.',
            'evidence.required' => 'Mohon unggah bukti pendukung.',
            'evidence.mimes' => 'Format bukti harus berupa: pdf, doc, docx, jpg, jpeg, png.',
            'evidence.max' => 'Ukuran maksimal bukti adalah 2MB.',
            'agreement.accepted' => 'Anda harus menyetujui Pernyataan dan Persetujuan untuk melanjutkan.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only([
            'what_happened',
            'where_happened',
            'when_happened',
            'reporter_role',
            'has_witness',
            'witness_name',
            'witness_relation',
            'knows_perpetrator',
            'perpetrator_name',
            'perpetrator_role'
        ]);

        $data['user_id'] = Auth::id();
        $data['agreement'] = $request->has('agreement');
        $data['status'] = 'unread';

        if ($request->input('has_witness') === 'no') {
            $data['witness_name'] = null;
            $data['witness_relation'] = null;
        }

        if ($request->input('knows_perpetrator') === 'no') {
            $data['perpetrator_name'] = null;
            if (!$request->filled('perpetrator_role')) {
                $data['perpetrator_role'] = 'tidak_diketahui';
            }
        }

        if ($request->hasFile('evidence')) {
            $file = $request->file('evidence');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('evidence_uploads', $filename, 'public'); // Simpan ke disk 'public'
            $data['evidence_path'] = $path;
        } else {
            $data['evidence_path'] = null;
        }

        Report::create($data);

        return redirect()->route('reports.index') // Ganti dengan route yang sesuai, misal halaman "Laporan Saya"
            ->with('success', 'Laporan berhasil dikirim. Kami akan segera menindaklanjutinya.');
    }

    /**
     * Menampilkan detail laporan spesifik untuk pengguna yang membuatnya.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki izin untuk melihat laporan ini.');
        }

        return view('user.show-report', compact('report'));
    }

    /**
     * Mengunduh file bukti untuk laporan spesifik, hanya untuk pemilik laporan.
     *
     * @param  \App\Models\Report  $report
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\RedirectResponse
     */
    public function downloadUserEvidence(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengunduh bukti ini.');
        }

        if (!$report->evidence_path || !Storage::disk('public')->exists($report->evidence_path)) {
            return redirect()->back()->with('error', 'File bukti tidak ditemukan atau tidak dapat diakses.');
        }

        $fileName = basename($report->evidence_path);

        return Storage::disk('public')->download($report->evidence_path, $fileName);
    }
}
