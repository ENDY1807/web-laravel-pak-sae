<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ArtikelController extends Controller
{
    /**
     * Menampilkan daftar semua artikel di panel admin.
     */
    public function index()
    {
        $artikel = Artikel::orderBy('Tanggal', 'desc')->get();

        return view('admin.data_artikel', compact('artikel'));
    }

    /**
     * Menyimpan artikel baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Id'      => 'nullable|integer|unique:artikel,Id',
            'id'      => 'nullable|integer',
            'Judul'   => 'nullable|string|max:100',
            'judul'   => 'nullable|string|max:100',
            'Isi'     => 'nullable|string',
            'isi'     => 'nullable|string',
            'Tanggal' => 'nullable|date',
            'tanggal' => 'nullable|date',
            'Link'    => 'nullable|url|max:255',
            'link'    => 'nullable|url|max:255',
            'Image'   => 'nullable',
            'image'   => 'nullable',
        ]);

        $judul   = $request->input('Judul') ?? $request->input('judul');
        $isi     = $request->input('Isi') ?? $request->input('isi');
        $tanggal = $request->input('Tanggal') ?? $request->input('tanggal') ?? date('Y-m-d');
        $link    = $request->input('Link') ?? $request->input('link');
        $id      = $request->input('Id') ?? $request->input('id');

        // Handling upload gambar jika ada file yang diunggah
        $imageName = 'default.png';
        if ($request->hasFile('Image')) {
            $file = $request->file('Image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/images'), $imageName);
        } elseif ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/images'), $imageName);
        } elseif ($request->filled('Image')) {
            $imageName = $request->input('Image');
        } elseif ($request->filled('image')) {
            $imageName = $request->input('image');
        }

        $data = [
            'Judul'   => $judul,
            'Isi'     => $isi,
            'Tanggal' => $tanggal,
            'Link'    => $link,
            'Image'   => $imageName,
        ];

        if (!empty($id)) {
            $data['Id'] = (int) $id;
        }

        Artikel::create($data);

        return redirect()->route('data_artikel')->with('success', 'Artikel berhasil ditambahkan!');
    }

    /**
     * Memperbarui artikel yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);

        $request->validate([
            'Judul'   => 'nullable|string|max:100',
            'judul'   => 'nullable|string|max:100',
            'Isi'     => 'nullable|string',
            'isi'     => 'nullable|string',
            'Tanggal' => 'nullable|date',
            'tanggal' => 'nullable|date',
            'Link'    => 'nullable|url|max:255',
            'link'    => 'nullable|url|max:255',
            'Image'   => 'nullable',
            'image'   => 'nullable',
        ]);

        $judul   = $request->input('Judul') ?? $request->input('judul') ?? $artikel->Judul;
        $isi     = $request->input('Isi') ?? $request->input('isi') ?? $artikel->Isi;
        $tanggal = $request->input('Tanggal') ?? $request->input('tanggal') ?? $artikel->Tanggal;
        $link    = $request->input('Link') ?? $request->input('link') ?? $artikel->Link;

        // Cek jika ada unggahan gambar baru
        $imageName = $artikel->Image;
        if ($request->hasFile('Image')) {
            $file = $request->file('Image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/images'), $imageName);
        } elseif ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/images'), $imageName);
        } elseif ($request->filled('Image')) {
            $imageName = $request->input('Image');
        } elseif ($request->filled('image')) {
            $imageName = $request->input('image');
        }

        $artikel->update([
            'Judul'   => $judul,
            'Isi'     => $isi,
            'Tanggal' => $tanggal,
            'Link'    => $link,
            'Image'   => $imageName,
        ]);

        return redirect()->route('data_artikel')->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Menghapus artikel dari database.
     */
    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);

        // Hapus file gambar jika ada dan bukan file bawaan
        if ($artikel->Image && !in_array($artikel->Image, ['detik.png', 'kompas.png', 'Liputan6.png', 'profile.jpg', 'default.png'])) {
            $imagePath = public_path('storage/images/' . $artikel->Image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $artikel->delete();

        return redirect()->route('data_artikel')->with('success', 'Artikel berhasil dihapus!');
    }
}
