<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pdf;
use Illuminate\Support\Facades\Validator;

class PdfController extends Controller
{

    public function index()
    {

        try {

            $pdf = Pdf::all();
            if (is_null($pdf)) {
                return response()->json([
                    'status' => false,
                    'message' => 'alert',
                    'errors' => 'Pdf Not Found'
                ], 401);
            }

            return response()->json([
                'status' => true,
                'pdf' => $pdf
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
                    'file' => 'required|mimes:pdf',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            $input = $request->except('file');

            if (!empty($request->file)) {
                $input['file'] = fileUpload($request['file'], path_file()); // upload file
            }

            $pdf = Pdf::create($input);

            return response()->json([
                'status' => true,
                'pdf' => $pdf,
                'message' => 'Pdf Created Successfully',

            ], 201);
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
            $pdf = Pdf::findOrFail($id);
            if (is_null($pdf)) {
                return response()->json([
                    'status' => false,
                    'message' => 'alert',
                    'errors' => 'Pdf Not Found'
                ], 401);
            }

            return response()->json([
                'status' => true,
                'pdf' => $pdf
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
            $pdf = Pdf::find($id);
            if (is_null($pdf)) {
                return response()->json([
                    'status' => false,
                    'message' => 'alert',
                    'errors' => 'Order Not Found'
                ], 401);
            }

            removeImage(path_file(), $pdf->file);
            $pdf->delete();
            return response()->json([
                'status' => true,
                'message' => 'Pdf Deleted Successfully'

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function pdfdownload($id)
    {
        $pdf = Pdf::findOrFail($id);

        $file = path_file() . $pdf->file;
        return response()->download($file);
    }

    public function update(Request $request, $id)
    {

        $pdf = Pdf::find($id);
        if (is_null($pdf)) {
            return response()->json([
                'status' => false,
                'message' => 'alert',
                'errors' => 'Pdf Not Found'
            ], 401);
        }

        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    // 'file' => 'nullable|mimes:pdf',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }


            $input = $request->except('file');

            if (!empty($request->file) && $request->file != 'undefined') {
                $old_img = '';
                $old_img = isset($pdf) ? $pdf->file : '';
                $input['file'] = fileUpload($request['file'], path_file(), $old_img); // upload file
            }

            $pdf = $pdf->update($input);

            return response()->json([
                'status' => true,
                'area' => $pdf,
                'message' => 'Pdf Updated',

            ], 201);
        } catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
