<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $store = Article::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'author_name' => $request->input('author_name'),
            ]);

            DB::commit();

            return response()->json([
                'data' => $store,
                'message' => 'Berhasil Disimpan',
            ], 200);
        } catch (\Exception $th) {
            DB::rollBack();
            return $th;
        }
    }

    public function edit(Request $request)
    {
        try {
            $id = $request->input('id');
            $data = Article::where('id', $id)->first();

            return response()->json([
                'data' => $data,
                'message' => 'Berhasil',
            ], 200);
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->input('id_edit');
            $data = [
                'title' =>  $request->input('title_edit'),
                'content' =>  $request->input('content_edit'),
                'author_name' =>  $request->input('author_name_edit'),
            ];

            Article::where('id', $id)->update($data);

            DB::commit();
            return response()->json([
                'data' => $data,
                'message' => 'Berhasil Diedit',
            ], 200);
        } catch (\Exception $th) {
            DB::rollBack();
            return $th;
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->input('id');

            $data = Article::where('id', $id)->first();

            return response()->json([
                'id' => $id,
                'data' => $data,
                'message' => 'Berhasil Dihapus',
            ], 200);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->input('id');
            Article::where('id', $id)->delete();

            DB::commit();
            return response()->json([
                'data' => $id,
                'message' => 'Berhasil Dihapus',
            ], 200);
        } catch (\Exception $th) {
            DB::rollBack();
            return $th;
        }
    }

    public function lihat(Request $request)
	{
		try {
			$id = $request->input('id');
			$data = Article::where('id', $id)->first();

			return response()->json([
				'data' => $data,
				'message' => 'Get Data',
			], 200);
		} catch (\Throwable $th) {
			return $th;
		}
	}
}
