<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
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

        // Broadcast event
        broadcast(new NewChatMessage($chat))->toOthers();

        return response()->json([
            'message' => 'Chat berhasil dikirim',
            'session_id' => $sessionId, // Kembalikan session ID agar frontend bisa menyimpan
            'chat' => $chat,
        ], 201);
    }

    public function getAllChatSessions()
    {
        $now = Carbon::now();

        // Ambil semua session
        $sessions = Chat_Sessions::all();

        // Hapus yang expired
        $sessions->each(function ($session) use ($now) {
            if ($session->expired_at && Carbon::parse($session->expired_at)->isPast()) {
                Log::info("Session expired (getAll). Deleting session: " . $session->id);
                $session->delete(); // ini akan cascade delete chat-nya
            }
        });

        // Ambil ulang session yang aktif setelah penghapusan
        $sessions = Chat_Sessions::where('expired_at', '>', $now)->get();

        $sessions = $sessions->map(function ($session) {
            $lastChat = Chat::where('id_chat_sessions', $session->id)
                ->orderBy('created_at', 'desc')
                ->first();

            $session->last_message = $lastChat ? $lastChat->content : null;
            $session->last_chat_time = $lastChat ? $lastChat->created_at : null;

            return $session;
        });

        $sessions = $sessions->sortByDesc('last_chat_time')->values();

        return response()->json([
            'message' => 'Berhasil mengambil semua chat sessions yang masih aktif',
            'data' => $sessions
        ], 200);
    }

    public function getChatsBySession($session_id)
    {
        $session = Chat_Sessions::find($session_id);

        if (!$session) {
            return response()->json([
                'message' => 'Sesi tidak ditemukan'
            ], 404);
        }

        // Cek apakah sesi sudah expired
        if (Carbon::parse($session->expired_at)->isPast()) {
            Log::info("Session expired (getChats). Deleting session: " . $session_id);
            $session->delete(); // juga akan hapus chat-nya

            return response()->json([
                'message' => 'Sesi telah expired dan telah dihapus'
            ], 410);
        }


        $chats = $session->Chats()->orderBy('created_at', 'asc')->get();

        if ($chats->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada chat dalam sesi ini'
            ], 404);
        }

        return response()->json([
            'message' => 'Berhasil mengambil chat berdasarkan session ID',
            'data' => $chats
        ], 200);
    }
}
