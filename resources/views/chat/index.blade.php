@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 2rem auto; background: #f4f6f9; border-radius: 10px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
    <h2 style="text-align:center; color:#2c3e50; font-weight:700; margin-bottom:1rem;">💬 Ask a Question</h2>

    <div id="chat-box" style="height: 400px; overflow-y: auto; background: white; border: 1px solid #ddd; border-radius: 8px; padding: 10px;">
        <p style="text-align:center; color:#aaa;">Start chatting with StudyWell Assistant 👇</p>
    </div>

    <form id="chat-form" style="display: flex; gap: 10px; margin-top: 15px;">
        <input id="message" type="text" class="form-control" placeholder="Type your question..." style="flex:1; border-radius: 8px;">
        <button type="submit" class="btn btn-primary" style="border-radius: 8px; padding: 0 20px;">Send</button>
    </form>
</div>

<script>
document.getElementById('chat-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const input = document.getElementById('message');
    const chatBox = document.getElementById('chat-box');
    const text = input.value.trim();
    if (!text) return;

    // Show user message
    chatBox.innerHTML += `<div style="margin:8px 0; text-align:right;"><span style="background:#007bff; color:white; padding:8px 12px; border-radius:15px 15px 0 15px; display:inline-block;">${text}</span></div>`;
    input.value = '';

    // Show typing animation
    const typing = document.createElement('div');
    typing.id = 'typing';
    typing.innerHTML = `<div style="color:#888; font-style:italic;">Assistant is typing...</div>`;
    chatBox.appendChild(typing);
    chatBox.scrollTop = chatBox.scrollHeight;

    try {
        const response = await fetch("{{ route('chat.ask') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: text })
        });

        const data = await response.json();
        typing.remove();

        chatBox.innerHTML += `<div style="margin:8px 0; text-align:left;"><span style="background:#eaeaea; color:#333; padding:8px 12px; border-radius:15px 15px 15px 0; display:inline-block;">${data.answer}</span></div>`;
    } catch (err) {
        typing.remove();
        chatBox.innerHTML += `<div style="color:red;">Error: Could not connect to the server.</div>`;
    }

    chatBox.scrollTop = chatBox.scrollHeight;
});
</script>
@endsection
