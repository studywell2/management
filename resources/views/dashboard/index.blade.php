@extends('layouts.app')

@section('content')
<div class="dashboard-wrapper d-flex flex-column justify-content-between" style="min-height: 100vh; background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);">

    <div class="container py-5 flex-grow-1">
        <h2 class="mb-4 fw-bold text-white text-center">Welcome, {{ Auth::user()->name }} 👋</h2>

        {{-- Success/Error messages --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @php
            $user = Auth::user();
            $isStudent = $user->role === 'student';
            $isTeacher = $user->role === 'teacher';
            $studentPaid = $isStudent && optional($user->student)->paid_term_fee;
            $teacherPaid = $isTeacher && optional($user->teacher)->paid_allowance;
            $hasPaid = $isStudent ? $studentPaid : ($isTeacher ? $teacherPaid : true);

            $cards = [
                ['title' => 'Schools', 'icon' => '🏫', 'route' => route('school.create'), 'color' => '#3498db', 'restricted' => false],
                ['title' => 'Students', 'icon' => '🎓', 'route' => route('students.index'), 'color' => '#2ecc71', 'restricted' => true],
                ['title' => 'Results', 'icon' => '📊', 'route' => route('results.index'), 'color' => '#e67e22', 'restricted' => true],
                ['title' => 'Teachers', 'icon' => '👩‍🏫', 'route' => route('teachers.index'), 'color' => '#9b59b6', 'restricted' => true],
                ['title' => 'Classes', 'icon' => '🏢', 'route' => route('classes.index'), 'color' => '#1abc9c', 'restricted' => false],
                ['title' => 'Subjects', 'icon' => '📚', 'route' => route('subjects.index'), 'color' => '#f39c12', 'restricted' => false],
                ['title' => 'Payments', 'icon' => '💳', 'route' => route('payment.form'), 'color' => '#e74c3c', 'restricted' => false],
            ];
        @endphp

        {{-- School Information --}}
        <div class="card shadow-sm mb-4 p-3">
            <h4 class="fw-bold">School Information</h4>

            @if($school)
                <p><strong>School Name:</strong> {{ $school->school_name }}</p>
                <p><strong>Address:</strong> {{ $school->address }}</p>
                <p><strong>Email:</strong> {{ $school->email }}</p>
                <p><strong>Phone:</strong> {{ $school->phone }}</p>
                <p><strong>Website:</strong> {{ $school->website }}</p>
                @if($school->logo)
                    <p><strong>Logo:</strong></p>
                    <img src="{{ asset('storage/' . $school->logo) }}" alt="School Logo" width="120">
                @else
                    <p>No logo uploaded.</p>
                @endif
            @else
                <p>No school information available. <a href="{{ route('school.create') }}">Add your school</a></p>
            @endif
        </div>

        <div class="row g-4">
            @foreach($cards as $card)
            <div class="col-md-4 col-lg-3">
                <div class="card dashboard-card h-100 text-center p-4 shadow-sm">
                    <div class="mb-2" style="font-size: 2.5rem;">{{ $card['icon'] }}</div>
                    <h5 class="fw-bold" style="color: {{ $card['color'] }}">{{ $card['title'] }}</h5>
                    <p class="text-muted small">
                        @if($card['restricted'] && !$hasPaid)
                            Access locked 🔒
                        @else
                            Manage your {{ strtolower($card['title']) }}.
                        @endif
                    </p>

                    @if($card['restricted'] && !$hasPaid)
                        <a href="{{ route('payment.form') }}" class="btn btn-warning btn-sm">Pay Now</a>
                    @else
                        <a href="{{ $card['route'] }}" class="btn btn-outline-light btn-sm">View</a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        {{-- Payment Status --}}
        <div class="card shadow-sm mt-5 p-3 mb-5">
            <div class="card-header bg-primary text-white fw-bold">Account Payment Status</div>
            <div class="card-body">
                @if($isStudent)
                    <p>Term Fee:
                        @if($studentPaid)
                            <span class="badge bg-success">Paid ✅</span>
                        @else
                            <span class="badge bg-danger">Unpaid ❌</span>
                            <a href="{{ route('payment.form') }}" class="btn btn-sm btn-success ms-2">Pay Now</a>
                        @endif
                    </p>
                @elseif($isTeacher)
                    <p>Allowance:
                        @if($teacherPaid)
                            <span class="badge bg-success">Paid ✅</span>
                        @else
                            <span class="badge bg-danger">Unpaid ❌</span>
                            <a href="{{ route('payment.form') }}" class="btn btn-sm btn-success ms-2">Pay Now</a>
                        @endif
                    </p>
                @else
                    <p><span class="badge bg-info">Admin Account — Access Granted</span></p>
                @endif
            </div>
        </div>
    </div>

    <!-- Fixed Footer -->
    <footer class="text-center text-light py-3 mt-auto" style="background: rgba(0,0,0,0.3); backdrop-filter: blur(6px); position: relative; z-index: 1;">
        &copy; {{ date('Y') }} StudyWell. All rights reserved.
    </footer>

</div>

<!-- Chatbox -->
<div id="chatbox-container">
    <div id="chatbox-header">💬 Ask a Question</div>
    <div id="chatbox-messages"></div>
    <form id="chatbox-form">
        <input type="text" id="chatbox-input" placeholder="Type your question..." required />
        <button type="submit">Send</button>
    </form>
</div>

<style>
/* === Chatbox Styling === */
#chatbox-container {
    position: fixed;
    bottom: 90px; /* leaves space for footer */
    right: 20px;
    width: 300px;
    max-height: 400px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    font-family: 'Segoe UI', sans-serif;
    z-index: 9999;
}

#chatbox-header {
    background-color: #0d6efd;
    color: #fff;
    padding: 10px;
    text-align: center;
    font-weight: bold;
}

#chatbox-messages {
    flex: 1;
    padding: 10px;
    overflow-y: auto;
    background: #f7f9fc;
    display: flex;
    flex-direction: column;
}

.chat-message {
    margin-bottom: 10px;
    padding: 8px 10px;
    border-radius: 10px;
    max-width: 80%;
    word-wrap: break-word;
}

.chat-message.user {
    background: #0d6efd;
    color: #fff;
    align-self: flex-end;
}

.chat-message.bot {
    background: #e1e1e1;
    color: #333;
    align-self: flex-start;
}

#chatbox-form {
    display: flex;
    border-top: 1px solid #ddd;
}

#chatbox-input {
    flex: 1;
    padding: 10px;
    border: none;
    outline: none;
}

#chatbox-form button {
    background-color: #0d6efd;
    border: none;
    color: #fff;
    padding: 0 15px;
    cursor: pointer;
}

/* === Dashboard Cards === */
.dashboard-wrapper {
    background-size: cover;
    background-position: center;
}

.dashboard-card {
    border-radius: 15px;
    background: rgba(255,255,255,0.15);
    color: #fff;
    transition: transform 0.3s, box-shadow 0.3s;
    backdrop-filter: blur(10px);
}

.dashboard-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 25px rgba(0,0,0,0.2);
}

.btn-outline-light {
    border-color: #fff;
    color: #fff;
}

.btn-outline-light:hover {
    background-color: rgba(255,255,255,0.2);
    color: #fff;
}
</style>

<script>
document.getElementById('chatbox-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const input = document.getElementById('chatbox-input');
    const text = input.value.trim();
    if (!text) return;

    const messagesDiv = document.getElementById('chatbox-messages');
    messagesDiv.innerHTML += `<div class="chat-message user">${text}</div>`;
    input.value = '';

    messagesDiv.scrollTop = messagesDiv.scrollHeight;

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
        messagesDiv.innerHTML += `<div class="chat-message bot">${data.answer || 'No response received.'}</div>`;
    } catch (err) {
        messagesDiv.innerHTML += `<div class="chat-message bot">⚠️ Could not reach the server.</div>`;
    }

    messagesDiv.scrollTop = messagesDiv.scrollHeight;
});
</script>
@endsection
