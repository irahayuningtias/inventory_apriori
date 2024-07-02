<!DOCTYPE html>
<html>
<head>
    <title>Masukkan Password</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <form action="{{ route('users.password.validate') }}" method="POST">
        @csrf
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        @error('password')
            <div>{{ $message }}</div>
        @enderror
        <button type="submit">Submit</button>
    </form>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
