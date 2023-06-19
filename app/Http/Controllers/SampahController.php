<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Sampah;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Exception;

class SampahController extends Controller
{
    use SoftDeletes;

    public function index(Request $request)
    {
        try {
            $limit = $request->get('limit', 10);
            $search_nomor_rumah = $request->get('search_nomor_rumah');

            if ($search_nomor_rumah) {
                $sampahs = Sampah::where('nomor_rumah', 'like', "%$search_nomor_rumah%")->paginate($limit);
            } else {
                $sampahs = Sampah::paginate($limit);
            }

            return ApiFormatter::createAPI(200, 'success', $sampahs);
        } catch (Exception $e) {
            return ApiFormatter::createAPI(500, 'error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'kepala_keluarga' => 'required',
                'nomor_rumah' => 'required',
                'rt_rw' => 'required',
                'total_karung_sampah' => 'required',
                'tanggal_pengangkutan' => 'required'
            ]);

            $kriteria = $request->total_karung_sampah > 3 ? 'collapse' : 'standar';

            $sampah = Sampah::create([
                'kepala_keluarga' => $request->kepala_keluarga,
                'nomor_rumah' => $request->nomor_rumah,
                'rt_rw' => $request->rt_rw,
                'total_karung_sampah' => $request->total_karung_sampah,
                'tanggal_pengangkutan' => $request->tanggal_pengangkutan,
                'kriteria' => $kriteria
            ]);

            $hasil = Sampah::find($sampah->id);

            if ($hasil) {
                return ApiFormatter::createAPI(200, 'success', $hasil);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $e) {
            return ApiFormatter::createAPI(400, 'error', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $sampah = Sampah::find($id);

            if ($sampah) {
                return ApiFormatter::createAPI(200, 'success', $sampah);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (\Exception $e) {
            return ApiFormatter::createAPI(400, 'error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'kepala_keluarga' => 'required',
                'nomor_rumah' => 'required',
                'rt_rw' => 'required',
                'total_karung_sampah' => 'required',
                'tanggal_pengangkutan' => 'required'
            ]);

            $sampah = Sampah::find($id);

            $kriteria = $request->total_karung_sampah > 3 ? 'collapse' : 'standar';

            $sampah->update([
                'kepala_keluarga' => $request->kepala_keluarga,
                'nomor_rumah' => $request->nomor_rumah,
                'rt_rw' => $request->rt_rw,
                'total_karung_sampah' => $request->total_karung_sampah,
                'tanggal_pengangkutan' => $request->tanggal_pengangkutan,
                'kriteria' => $kriteria
            ]);

            $dataTerbaru = Sampah::where('id', $sampah->id)->first();
            if ($dataTerbaru) {
                return ApiFormatter::createAPI(200, 'success', $dataTerbaru);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (\Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $sampah = Sampah::find($id);
            $cekBerhasil = $sampah->delete();

            if ($cekBerhasil) {
                return ApiFormatter::createAPI(200, 'success', 'Data terhapus!');
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $e) {
            return ApiFormatter::createAPI(400, 'error', $e->getMessage());
        }
    }

    public function trash()
    {
        try {
            $sampah = Sampah::onlyTrashed()->get();
            if ($sampah) {
                return ApiFormatter::createAPI(200, 'success', $sampah);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (\Exception $e) {
            return ApiFormatter::createAPI(400, 'error', $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $sampah = Sampah::withTrashed()->where('id', $id)->first();
            $sampah->restore();
            if ($sampah) {
                return ApiFormatter::createAPI(200, 'success', $sampah);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (\Exception $e) {
            return ApiFormatter::createAPI(400, 'error', $e->getMessage());
        }
    }

    public function permanentDelete($id)
    {
        try {
            $sampah = Sampah::onlyTrashed()->where('id', $id);
            $proses = $sampah->forceDelete();
            if ($proses) {
                return ApiFormatter::createAPI(200, 'success', 'Data dihapus permanen!');
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (\Exception $e) {
            return ApiFormatter::createAPI(400, 'error', $e->getMessage());
        }
    }
}
