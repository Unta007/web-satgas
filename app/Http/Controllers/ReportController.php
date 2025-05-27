<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; // Penting untuk validasi 'in' dan 'required_if'

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
            'what_happened' => 'required|string|max:60000', // Max length bisa disesuaikan
            'where_happened' => 'required|string|max:255',
            'when_happened' => 'required|date',
            'reporter_role' => ['required', Rule::in(['mahasiswa', 'staff', 'dosen', 'lainnya'])],
            'has_witness' => ['required', Rule::in(['yes', 'no'])],
            'witness_name' => 'nullable|string|max:255|required_if:has_witness,yes',
            'witness_relation' => ['nullable', 'string', Rule::in(['teman', 'rekan_kerja', 'keluarga', 'tidak_kenal', 'lainnya']), 'required_if:has_witness,yes'],
            'knows_perpetrator' => ['required', Rule::in(['yes', 'no'])],
            'perpetrator_name' => 'nullable|string|max:255|required_if:knows_perpetrator,yes',
            'perpetrator_role' => [ // Mengganti predator_role
                'required_if:knows_perpetrator,yes', // Wajib jika identitas terlapor diketahui
                Rule::in(['mahasiswa', 'staff', 'dosen', 'lainnya', 'tidak_diketahui'])
            ],
            'evidence' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048', // Max 2MB
            'agreement' => 'accepted', // Untuk checkbox 'required'
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
            'what_happened', 'where_happened', 'when_happened', 'reporter_role',
            'has_witness', 'witness_name', 'witness_relation',
            'knows_perpetrator', 'perpetrator_name', 'perpetrator_role'
        ]);

        $data['user_id'] = Auth::id();
        // Untuk checkbox, $request->has() mengembalikan true jika dicentang (value '1' atau 'on')
        // Jika kolom 'agreement' di database adalah boolean, ini akan disimpan sebagai 1 (true) atau 0 (false).
        $data['agreement'] = $request->has('agreement');

        // Menangani field kondisional agar null jika tidak relevan
        if ($request->input('has_witness') === 'no') {
            $data['witness_name'] = null;
            $data['witness_relation'] = null;
        }

        if ($request->input('knows_perpetrator') === 'no') {
            $data['perpetrator_name'] = null;
            // Jika 'knows_perpetrator' adalah 'no', 'perpetrator_role' mungkin tidak dikirim
            // atau bisa diisi 'tidak_diketahui' dari form jika logikanya begitu.
            // Validasi 'required_if' sudah menangani ini, tapi pastikan $data konsisten.
            if (!$request->filled('perpetrator_role') && $request->input('knows_perpetrator') === 'no') {
                 $data['perpetrator_role'] = 'tidak_diketahui'; // Atau null jika lebih sesuai dengan DB Anda
            }
        }


        if ($request->hasFile('evidence')) {
            $file = $request->file('evidence');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('evidence_uploads', $filename, 'local'); // Penyimpanan privat
            $data['evidence_path'] = $path;
        } else {
            // Jika validasi 'evidence' adalah 'required', blok ini tidak akan tercapai.
            // Jika 'evidence' diubah menjadi 'nullable' di masa depan:
            $data['evidence_path'] = null;
        }

        Report::create($data);

        // Arahkan ke rute yang menampilkan form lagi dengan pesan sukses,
        // atau ke halaman 'home', atau halaman 'terima kasih' khusus.
        return redirect()->route('reports.index') // Menggunakan nama rute untuk menampilkan form
                         ->with('success', 'Laporan berhasil dikirim. Kami akan segera menindaklanjutinya.');
    }


    // --- Metode untuk API atau Admin Dashboard (sesuaikan jika perlu) ---

    /**
     * Menampilkan daftar laporan (mungkin untuk Admin).
     * @return \Illuminate\Http\JsonResponse | \Illuminate\View\View
     */
    public function index()
    {
        // Contoh jika untuk Admin Web (perlu rute dan view admin terpisah)
        // $reports = Report::with('user')->latest()->paginate(15);
        // return view('admin.reports.index', compact('reports'));

        // Versi API yang ada:
        $reports = Report::with('user')->latest()->get();
        return response()->json([
            'success' => true,
            'data' => $reports,
        ], 200);
    }

    /**
     * Menampilkan detail laporan spesifik (mungkin untuk Admin).
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\JsonResponse | \Illuminate\View\View
     */
    public function show(Report $report)
    {
        // Contoh jika untuk Admin Web:
        // $report->load('user');
        // return view('admin.reports.show', compact('report'));

        // Versi API yang ada:
        $report->load('user');
        return response()->json([
            'success' => true,
            'data' => $report,
        ], 200);
    }
}
