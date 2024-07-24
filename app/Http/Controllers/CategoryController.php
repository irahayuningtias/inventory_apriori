<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\CategoriesExport;
use App\Imports\CategoriesImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //fungsi eloquent menampilkan data menggunakan pagination
            $categories = Category::orderBy('id_category', 'asc')->get();
            return view('kategori.index', compact('categories'));
        } catch (QueryException $e) {
            // Menangani kesalahan duplikasi entri
            if ($e->errorInfo[1] == 1062) {
                return redirect()->route('category')->withErrors('Duplicate entry detected. Please use a unique identifier.');
            }
            
            // Menangani kesalahan referensi foreign key
            if ($e->errorInfo[1] == 1452) {
                return redirect()->route('category')->withErrors('Invalid category reference. Please select a valid category.');
            }

            // Menangani kesalahan lainnya
            return redirect()->route('category')->withErrors('An error occurred: ' . $e->getMessage());
        } catch (ValidationException $e) {
            // Menangani kesalahan validasi
            return redirect()->route('category')->withErrors($e->errors());
        }catch (\Exception $e) {
            // Menangani kesalahan umum
            return redirect()->route('category')->withErrors('An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kategori.add_category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            //melakukan validasi data
            $request->validate([
                'id_category' => 'required',
                'category_name' => 'required'
            ]);

            //fungsi eloquent untuk menambah data
            Category::create($request->all());

            //jika data berhasil ditambahkan, akan kembali ke halaman utama
            return redirect()->route('category')
                ->with('success', 'Kategori Berhasil Ditambahkan');
        } catch (QueryException $e) {
            // Menangani kesalahan duplikasi entri
            if ($e->errorInfo[1] == 1062) {
                return redirect()->route('category.create')->withErrors('Duplicate entry detected. Please use a unique identifier.');
            }
            
            // Menangani kesalahan referensi foreign key
            if ($e->errorInfo[1] == 1452) {
                return redirect()->route('category.create')->withErrors('Invalid category reference. Please select a valid category.');
            }

            // Menangani kesalahan lainnya
            return redirect()->route('category.create')->withErrors('An error occurred: ' . $e->getMessage());
        } catch (ValidationException $e) {
            // Menangani kesalahan validasi
            return redirect()->route('category.create')->withErrors($e->errors());
        }catch (\Exception $e) {
            // Menangani kesalahan umum
            return redirect()->route('category.create')->withErrors('An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id_category)
    {
        $Category = Category::find($id_category);
        return view('kategori.detail_category', compact('Category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_category)
    {
        $Category = Category::find($id_category);
        return view('kategori.edit_category', compact('Category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_category)
    {
        //melakukan validasi data
        $request->validate([
            'id_category' => 'required',
                'category_name' => 'required',
        ]);

        //fungsi eloquent untuk mengupdate data inputan
        Category::find($id_category)->update($request->all());

        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('category')
            ->with('success', 'Kategori Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_category)
    {
        //fungsi eloquent untuk menghapus data
        Category::find($id_category)->delete();
        return redirect()->route('category')
            ->with('success', 'Kategori Berhasil Dihapus');
    }

    public function export()
    {
        return Excel::download(new CategoriesExport, 'category.xlsx');
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
            ]);

            Excel::import(new CategoriesImport, $request->file('file')->store('temp'));

            return redirect()->route('category')->with('success', 'Kategori Berhasil Diimpor');
        } catch (QueryException $e) {
            // Menangani kesalahan duplikasi entri
            if ($e->errorInfo[1] == 1062) {
                return redirect()->route('category')->with('error', 'An error occurred: ' . $e->getMessage());
            }

            // Menangani kesalahan referensi foreign key
            if ($e->errorInfo[1] == 1452) {
                return redirect()->route('category')->with('error', 'Referensi kategori tidak valid. Silahkan pilih kategori yang valid.');
            }

            // Menangani kesalahan lainnya
            return redirect()->route('category')->with('error', 'An error occurred: ' . $e->getMessage());
        
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return redirect()->route('category')->with('validation_errors', $errorMessages);
        } catch (\Maatwebsite\Excel\Exceptions\NoTypeDetectedException $e) {
            return redirect()->route('categoryt')->with('error', 'Tipe file tidak valid. Silahkan unggah file Excel yang valid.');
        } catch (\Exception $e) {
            return redirect()->route('category')->with('error', 'Error importing products: ' . $e->getMessage());
        }
    }
}
