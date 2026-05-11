@extends('layouts.guest')

@section('content')
    <form action="{{ url('/login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control"
                   value="{{ old('email') }}" placeholder="admin@uks.test" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control"
                   placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-login">🔐 Masuk</button>
    </form>
@endsection
