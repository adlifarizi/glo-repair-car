<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Chat_Sessions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'sender' => 'required|in:Pelanggan,Admin',
            'content' => 'required|string',
        ]);

        // Ambil session ID dari request (misalnya dari localStorage di frontend)
        $sessionId = $request->input('id_chat_sessions');

        if ($sessionId) {
            // Cek apakah session masih aktif
            $chatSession = Chat_Sessions::find($sessionId);

            if ($chatSession) {
                // Jika session expired, hapus dan buat yang baru
                if ($chatSession->expired_at && Carbon::parse($chatSession->expired_at)->isPast()) {
                    Log::info("Session expired. Deleting session: " . $sessionId);
                    $chatSession->delete();
                    $sessionId = null;
                }
            } else {
                // Jika session tidak ditemukan, set sessionId ke null untuk buat baru
                $sessionId = null;
            }
        }

        // Jika tidak ada session yang valid, buat session baru
        if (!$sessionId) {
            $chatSession = Chat_Sessions::create();
            $sessionId = $chatSession->id;
        }

        // Simpan chat baru ke dalam session yang valid
        $chat = Chat::create([
            'id_chat_sessions' => $sessionId,
            'sender' => $request->sender,
            'content' => $request->content,
        ]);

        return response()->json([
            'message' => 'Chat berhasil dikirim',
            'session_id' => $sessionId, // Kembalikan session ID agar frontend bisa menyimpan
            'chat' => $chat,
        ], 201);
    }

    public function getAllChatSessions()
    {
        // Ambil semua session dengan data chat yang terkait
        $sessions = Chat_Sessions::get();

        return response()->json([
            'message' => 'Berhasil mengambil semua chat sessions',
            'data' => $sessions
        ], 200);
    }

    public function getChatsBySession($session_id)
    {
        $chats = Chat::where('id_chat_sessions', $session_id)
        ->orderBy('created_at', 'asc') // Urutkan dari lama ke baru
        ->get();
        
        if ($chats->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada chat dalam sesi ini atau sesi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Berhasil mengambil chat berdasarkan session ID',
            'data' => $chats
        ], 200);
    }
}
