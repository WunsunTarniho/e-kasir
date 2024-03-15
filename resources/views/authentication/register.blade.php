@extends('main.body')

@section('container')
    <div class="container col-lg-5 col-md-9 mt-5 mb-3 px-0">
        <div class="card o-hidden border-0 shadow-lg mb-3">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12 px-0">
                        <div class="px-md-5 py-5 px-4">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mt-4 mb-4">Register</h1>
                            </div>
                            <form class="user" action="/register" method="POST">
                                @csrf
                                <div class="form-floating">
                                    <input type="text" class="form-control valid form-control-user" id="username"
                                        name="username" placeholder="Username" value="{{ old('username') }}" autofocus />
                                    <label for="username">Username</label>
                                    @error('username')
                                        <div class="err-message text-danger ms-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-floating">
                                    <input type="email" class="form-control valid form-control-user" id="email"
                                        name="email" placeholder="Email Address" value="{{ old('email') }}">
                                    <label for="email">Email</label>
                                    @error('email')
                                        <div class="err-message text-danger ms-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-floating">
                                    <input type="password" class="form-control valid form-control-user" id="password"
                                        name="password" placeholder="Password">
                                    <label for="password">Password</label>
                                    @error('password')
                                        <div class="err-message text-danger ms-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div>
                                    <select class="form-select valid py-2" name="level" id="level">
                                        <option value="admin" selected>Admin</option>
                                        <option value="petugas">Petugas</option>
                                    </select>
                                </div>
                                <button type="submit"
                                    class="btn btn-primary mx-auto px-4 mt-md-4 mt-3 d-block">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
