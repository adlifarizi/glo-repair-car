<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        // Debug: Lihat apakah request masuk
        Log::info($request->all());

        $request->validate([
            'nama_pelanggan' => 'required|string',
            'plat_no' => 'required|string',
            'rating' => 'required|integer|between:1,5',
            'feedback' => 'required|string',        ]);


        // Simpan data ke database
        $feedback = Feedback::create($request->all());

        return response()->json([
            'message' => 'Feedback berhasil ditambahkan',
            'data' => $feedback
        ], 201);
    }

    public function toggleShow(Request $request, $id)
    {
        // Temukan feedback berdasarkan ID
        $feedback = Feedback::find($id);

        // Jika tidak ditemukan, kirim response error
        if (!$feedback) {
            return response()->json([
                'message' => 'Data Feedback tidak ditemukan'
            ], 404);
        }

        // Ubah nilai `show` ke kebalikannya (toggle)
        $feedback->show = !$feedback->show;
        $feedback->save();

        return response()->json([
            'message' => 'Status show berhasil diperbarui',
            'data' => $feedback
        ], 200);
    }




    public function delete(Request $request, $id)
    {
        // Debug: Lihat apakah request masuk
        Log::info($request->all());

        // Temukan data berdasarkan ID
        $feedback = feedback::find($id);

        // Jika tidak ditemukan, kirim response error
        if (!$feedback) {
            return response()->json([
                'message' => 'Data Feedback tidak ditemukan'
            ], 404);
        }

        // Hapus data
        $feedback->delete();

        return response()->json([
            'message' => 'Feedback berhasil dihapus',
            'data' => $feedback
        ], 200);
    }

    public function getVisibleFeedback()
    {
        // Mengambil semua feedback yang memiliki `show` = true
        $feedbacks = Feedback::where('show', true)->get();

        return response()->json([
            'data' => $feedbacks
        ], 200);
    }

    public function getAllFeedback()
    {
        // Mengambil semua feedback, baik yang `show` = true maupun `show` = false
        $feedbacks = Feedback::all();

        return response()->json([
            'data' => $feedbacks
        ], 200);
    }
}
