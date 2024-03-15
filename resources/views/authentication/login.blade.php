@include('main.head')


<div class="col-md-4 my-5 mx-auto p-3 px-4 border border-secondary-subtle rounded">
    <form action="/login" method="POST">
        @csrf
        <h3 class="h3 my-5 text-center">Login</h3>
        <div class="form-floating">
            <input type="email" class="form-control valid" id="email" name="email" placeholder="Email"
                value="{{ old('email') }}">
            <label for="email">Email address</label>
            @error('email')
                <div class="err-message text-danger ms-1">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-floating">
            <input type="password" class="form-control valid" id="password" name="password" placeholder="Password"
                value="{{ old('password') }}">
            <label for="password">Password</label>
            @error('password')
                <div class="err-message text-danger ms-1">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form">
            <select class="form-select valid py-2" id="level" name="level">
                <option value="admin" selected>Admin</option>
                <option value="petugas">Petugas</option>
            </select>
        </div>

        <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                Remember me
            </label>
        </div>
        <button class="btn btn-primary w-100 py-2 my-1 fw-bold" type="submit">Login</button>
        <a href="/auth/google" class="btn btn-danger w-100 py-2 my-1 fw-bold" type="button">Login with Google</a>
        <p class="mt-5 mb-3 text-center text-body-secondary">&copy; 2024</p>
    </form>
</div>

@include('main.footer')
