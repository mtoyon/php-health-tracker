@extends('layouts.app')

@section('title', 'Login - Health Tracker')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">🏥 Health Tracker Login</h4>
                </div>

                <div class="card-body p-5">
                    <p class="text-center text-muted mb-4">Enter your username to access your health data</p>
                    
                    <form method="POST" action="{{ route('login.submit') }}" id="loginForm">
                        @csrf

                        <div class="mb-4">
                            <label for="username" class="form-label fw-bold">Username</label>
                            <input 
                                id="username" 
                                type="text" 
                                class="form-control form-control-lg @error('username') is-invalid @enderror" 
                                name="username" 
                                value="{{ old('username') }}" 
                                placeholder="Enter your username"
                                required 
                                autofocus
                            >

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Login
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-4 text-center">
                        <small class="text-muted">
                            Sample usernames: <strong>john_doe</strong>, <strong>jane_smith</strong>
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-3" style="color: #357abd;">
                <small>Your health data is stored securely in your browser's local storage</small>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('loginForm');
        if (!form) return;
        
        form.addEventListener('submit', function() {
            const input = document.getElementById('username');
            const username = input.value.trim();
            if (username) {
                input.value = username.charAt(0).toUpperCase() + username.slice(1);
            }
        });
    });
</script>
@endsection
