<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{

    public function store(Request $request, $id)
    {
        Comment::create([
            'user_id'=> Auth::user()->id,
            'comment' => $request->comment,
            'name' => $request->name,
            'article_id' => $id,
        ]);

        return redirect('/blog/detail/' . $id);
    }

    public function edit(Request $request)
    {
        try {
            $id = $request->input('id');
            $data = Comment::where('id', $id)->first();

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
                'name' =>  $request->input('name_edit'),
                'comment' =>  $request->input('comment_edit'),
            ];

            Comment::where('id', $id)->update($data);

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

            $data = Comment::where('id', $id)->first();

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
            Comment::where('id', $id)->delete();

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
}
