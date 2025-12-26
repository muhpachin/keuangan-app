@extends('layouts.app')

@section('header_title', 'Get Help')

@section('content')
<div class="container mt-4">
    <h4>Bantuan / Live Chat</h4>

    @if(!$session)
        <p>Belum ada sesi chat aktif.</p>
        <form method="POST" action="{{ route('help.start') }}">
            @csrf
            <button class="btn btn-primary">Mulai Chat dengan Admin</button>
        </form>
    @elseif($session->status == 'closed')
        <p>Session chat ini telah ditutup. Anda tidak dapat mengirim pesan lagi.</p>
        <form method="POST" action="{{ route('help.start') }}">
            @csrf
            <button class="btn btn-primary">Mulai Session Baru</button>
        </form>
    @else
        <div id="chat-box" style="height:400px; overflow:auto; border:1px solid #ddd; padding:10px;">
            <!-- messages akan diisi oleh JS -->
        </div>

        <form id="send-form" class="mt-2">
            @csrf
            <input type="hidden" id="help_session_id" value="{{ $session->id }}">
            <div class="input-group">
                <input type="text" id="message-input" class="form-control" placeholder="Ketik pesan...">
                <button class="btn btn-primary" id="send-btn">Kirim</button>
            </div>
        </form>
    @endif
</div>

@if($session && $session->status == 'open')
<script>
window.addEventListener('beforeunload', function (e) {
    e.preventDefault();
    e.returnValue = 'Anda memiliki sesi chat yang masih aktif. Apakah Anda yakin ingin keluar?';
});
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sessionId = document.getElementById('help_session_id') ? document.getElementById('help_session_id').value : null;
    const chatBox = document.getElementById('chat-box');

    async function fetchMessages() {
        if (!sessionId) return;
        const res = await fetch('/help/messages/' + sessionId);
        const data = await res.json();
        if (!chatBox) return;
        chatBox.innerHTML = '';
        data.forEach(m => {
            const el = document.createElement('div');
            el.innerHTML = '<strong>' + (m.user.name || m.user.username) + ':</strong> ' + m.message + '<br><small class="text-muted">' + new Date(m.created_at).toLocaleString() + '</small>';
            el.style.marginBottom = '10px';
            chatBox.appendChild(el);
        });
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    if (sessionId) {
        fetchMessages();
        setInterval(fetchMessages, 3000);

        document.getElementById('send-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const msg = document.getElementById('message-input').value.trim();
            if (!msg) return;
            await fetch('/help/messages', {
                method: 'POST',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN': '{{ csrf_token() }}'},
                body: JSON.stringify({help_session_id: sessionId, message: msg})
            });
            document.getElementById('message-input').value = '';
            fetchMessages();
        });
    }
});
</script>

@endsection
