<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::all();

        $data = $materials->map(function ($item) {
            return [
                'id' => $item->material_id,
                'judul' => $item->title,
                'deskripsi' => $item->description,
                'link' => $item->googleDriveLink,
                'created_at' => $item->created_at,
                'kategori' => $item->category ?? 'Fotografi',
            ];
        });

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'link' => 'required'
        ]);

        try {
            $material = Material::create([
                'title' => $request->judul,
                'description' => $request->deskripsi,
                'googleDriveLink' => $request->link,
            ]);

            return response()->json(['success' => true, 'data' => $material], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $material->update([
            'title' => $request->judul,
            'description' => $request->deskripsi,
            'googleDriveLink' => $request->link
        ]);

        return response()->json(['success' => true, 'message' => 'Materi berhasil diupdate']);
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return response()->json(['success' => true, 'message' => 'Materi dihapus']);
    }
}
