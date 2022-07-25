<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Snippet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SnippetController extends Controller
{
    public function index()
    {
        try {

            $snippet = Snippet::all();
            if (is_null($snippet)) {
                return response()->json([
                    'status' => false,
                    'message' => 'alert',
                    'errors' => 'Snippet Not Found'
                ], 401);
            }

            return response()->json([
                'status' => true,
                'snippet' => $snippet
            ], 201);
        } catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'content' => 'required',
                    'snippet' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $snippet = Snippet::create($request->all());

            return response()->json([
                'status' => true,
                'snippet' => $snippet,
                'message' => 'Snippet Created Successfully',

            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $snippet = Snippet::findOrFail($id);
            if (is_null($snippet)) {
                return response()->json([
                    'status' => false,
                    'message' => 'alert',
                    'errors' => 'Order Not Found'
                ], 401);
            }

            $snippet->delete();
            return response()->json([
                'status' => true,
                'message' => 'Snippet Deleted Successfully'

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $snippet = Snippet::find($id);
            if (is_null($snippet)) {
                return response()->json([
                    'status' => false,
                    'message' => 'alert',
                    'errors' => 'Pdf Not Found'
                ], 401);
            }

            return response()->json([
                'status' => true,
                'snippet' => $snippet
            ], 201);
        } catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {

        $snippet = Snippet::find($id);
        if (is_null($snippet)) {
            return response()->json([
                'status' => false,
                'message' => 'alert',
                'errors' => 'Snippet Not Found'
            ], 401);
        }

        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'content' => 'required',
                    'snippet' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $snippet = $snippet->update($request->all());

            return response()->json([
                'status' => true,
                'snippet' => $snippet,
                'message' => 'Snippet Updated',

            ], 201);
        } catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
