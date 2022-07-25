<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LinkController extends Controller
{
    public function index()
    {
        try {

            $link = Link::all();
            if (is_null($link)) {
                return response()->json([
                    'status' => false,
                    'message' => 'alert',
                    'errors' => 'Snippet Not Found'
                ], 401);
            }

            return response()->json([
                'status' => true,
                'link' => $link
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
                    'link' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $link = Link::create([
                'title' => $request->title,
                'link' => $request->link,
                "newtab" => $request->newtab == 'true' ? 1 : 0
            ]);

            return response()->json([
                'status' => true,
                'link' => $link,
                'message' => 'Link Created Successfully',

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
            $link = Link::findOrFail($id);
            if (is_null($link)) {
                return response()->json([
                    'status' => false,
                    'message' => 'alert',
                    'errors' => 'Order Not Found'
                ], 401);
            }

            $link->delete();
            return response()->json([
                'status' => true,
                'message' => 'Link Deleted Successfully'

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
            $link = Link::find($id);
            if (is_null($link)) {
                return response()->json([
                    'status' => false,
                    'message' => 'alert',
                    'errors' => 'Pdf Not Found'
                ], 401);
            }

            return response()->json([
                'status' => true,
                'link' => $link
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

        $link = Link::find($id);
        if (is_null($link)) {
            return response()->json([
                'status' => false,
                'message' => 'alert',
                'errors' => 'Link Not Found'
            ], 401);
        }

        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'link' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $link = $link->update([
                'title' => $request->title,
                'link' => $request->link,
                "newtab" => $request->newtab == 'true' ? 1 : 0
            ]);

            return response()->json([
                'status' => true,
                'link' => $link,
                'message' => 'Link Updated',

            ], 201);
        } catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
