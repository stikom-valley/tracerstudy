<?php

namespace App\Http\Controllers\Frontend;

use App\User;
use App\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $experiences = Experience::select('id', 'company_name', DB::raw('COUNT(user_id) as total_user'))
            ->groupBy('company_name')
            ->get();

        return view('frontend.dashboard.experiences.index')
            ->with(['experiences' => $experiences]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::where('role_id', 3)->get();
        return view('frontend.dashboard.experiences.create', ['users' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'pilih_alumni' => 'required',
            'nama_perusahaan' => 'required',
            'lama_berkerja' => 'required|date',
            'berhenti_bekerja' => 'nullable|date|after:lama_bekerja',
            'sekarang' => 'nullable',
            'jabatan' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required'
        ];

        $ruleMessages = [
            'nama_perusahaan.required' => 'Nama perusahaan harus diisi',
            'lama_berkerja.required' => 'Lama bekerja harus diisi',
            'jabatan.required' => 'Jabatan harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'deskripsi.required' => 'Deskripsi harus diisi'
        ];

        $this->validate($request, $rules, $ruleMessages);
        $exper = new Experience();
        $exper->company_name = $request->get('nama_perusahaan');
        $exper->job_title = $request->get('jabatan');
        $exper->start_date = date("Y-m-d", strtotime($request->get('lama_berkerja')));
        if ($request->get('berhenti_bekerja')) {
            $exper->end_date = date("Y-m-d", strtotime($request->get('berhenti_bekerja')));
        }
        if ($request->get('sekarang')) {
            $exper->is_present = 1;
        } else {
            $exper->is_present = 0;
        }
        $exper->description = $request->get('deskripsi');
        $exper->location = $request->get('alamat');
        $exper->user_id = $request->get('pilih_alumni');
        $exper->save();
        return redirect()->route('experience.create')->with('success', 'Riwayat pekerjaan berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $exper = Experience::where('user_id', $id)->get();
        return view('frontend.dashboard.experiences.show', ['exper' => $exper, 'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $exper = Experience::findOrFail($id);
        $user = User::findOrFail($exper->user_id);
        return view('frontend.dashboard.experiences.edit', ['exper' => $exper, 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'nama_perusahaan' => 'required',
            'lama_berkerja' => 'required|date',
            'berhenti_bekerja' => 'nullable|date|after:lama_bekerja',
            'sekarang' => 'nullable',
            'jabatan' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required'
        ];

        $ruleMessages = [
            'nama_perusahaan.required' => 'Nama perusahaan harus diisi',
            'lama_berkerja.required' => 'Lama bekerja harus diisi',
            'berhenti_bekerja.nullable:lama_kerja' => 'Berhenti bekerja',
            'jabatan.required' => 'Jabatan harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'deskripsi.required' => 'Deskripsi harus diisi'
        ];

        $this->validate($request, $rules, $ruleMessages);
        $exper = Experience::findOrFail($id);
        $exper->company_name = $request->get('nama_perusahaan');
        $exper->job_title = $request->get('jabatan');
        $exper->start_date = date("Y-m-d", strtotime($request->get('lama_berkerja')));
        if ($request->get('berhenti_bekerja')) {
            $exper->end_date = date("Y-m-d", strtotime($request->get('berhenti_bekerja')));
            $exper->is_present = 0;
        }
        if ($request->get('sekarang')) {
            $exper->is_present = 1;
            $exper->end_date = null;
        }
        $exper->description = $request->get('deskripsi');
        $exper->location = $request->get('alamat');
        $exper->save();


        return redirect()->route('experience.show', [$exper->user_id])->with('success', 'Riwayat pekerjaan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $exper = Experience::find($id);
            $exper->delete();
            return response()->json(['message' => 'sukses']);
        }
    }
}
