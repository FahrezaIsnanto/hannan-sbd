<?php

namespace App\Http\Controllers;

use App\Models\Supir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SupirController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $supir = DB::select('select * from supir_bus where nama_supir LIKE "%' . $request->search . '%"');
            $supir_deleted = Supir::onlyTrashed()->get(); // returns 5 again

            return view('supir.index', [
                'supir' => $supir,
                'supir_deleted' => $supir_deleted,
            ]);
        } else {
            $supir = DB::table('supir_bus')->whereNull('deleted_at')->get();

            $supir_deleted = Supir::onlyTrashed()->get(); // returns 5 again


            return view('supir.index', [
                'supir' => $supir,
                'supir_deleted' => $supir_deleted,
            ]);
        }
    }

    public function create()
    {
        $bus = DB::select('select * from bus');

        return view('supir.add')
            ->with('bus', $bus);
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'id_supir' => 'required',
            'nama_supir' => 'required',
            'jam_terbang' => 'required',
            'plat' => 'required',
        ]);

        // Menggunakan Query Builder Laravel dan Named Bindings untuk valuesnya
        DB::insert(
            'INSERT INTO supir( nama_supir, jam_terbang,  plat) VALUES ( :nama_supir, :jam_terbang,  :plat)',
            [
                'nama_supir' => $request->nama_supir,
                'jam_terbang' => $request->jam_terbang,
                'plat' => $request->plat,
            ]
        );

        return redirect()->route('supir.index')->with('success', 'supir berhasil disimpan');
    }

    public function edit($id)
    {
        $data = DB::table('supir')->where('id_supir', $id)->first();
        return view('supir.edit')->with('data', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'nama_supir' => 'required',
            'jam_terbang' => 'required',
            'plat' => 'required',
        ]);

        // Menggunakan Query Builder Laravel dan Named Bindings untuk valuesnya
        DB::update(
            'UPDATE supir SET nama_supir = :nama_supir, jam_terbang = :jam_terbang, plat = :plat WHERE id_supir = :id',
            [
                'id' => $id,
                'nama_supir' => $request->nama_supir,
                'jam_terbang' => $request->jam_terbang,
                'plat' => $request->plat,
            ]
        );

        return redirect()->route('supir.index')->with('success', 'Data supir berhasil diubah');
    }

    // public function delete($id)
    // {
    //         // Menggunakan Query Builder Laravel dan Named Bindings untuk valuesnya
    //         DB::delete('DELETE FROM supir WHERE id_supir = :id_supir', ['id_supir' => $id]);

    //     // Menggunakan laravel eloquent
    //     // Supir::where('id_supir', $id)->delete();

    //     return redirect()->route('supir.index')->with('success', 'Data supir berhasil dihapus');
    // }

    public function destroy($id)
    {

        DB::table('supir')
            ->where('id_supir', $id)
            ->update(['deleted_at' => Carbon::now()]);
        return redirect()->route('supir.index')->with('success', 'Data supir berhasil Dihapus');
    }

    public function restore($id)
    {
        Supir::where('id_supir', $id)->withTrashed()->restore();
        return redirect()->back()->with('success', 'Data supir berhasil direstore');
    }

    public function forceDelete($id)
    {
        Supir::where('id_supir', $id)->withTrashed()->forceDelete();
        return redirect()->back()->with('success', 'Data supir berhasil dihapus permanent');
    }
}
