@extends('main.body')

@section('container')
    <div class="d-flex flex-nowrap align-items-center justify-content-between pt-3 pb-2 mb-4  border-bottom">
        <h1 class="h2">{{ $title }}</h1>
        <div>
            @can('admin')
                <a class="btn btn-primary px-3 me-1" href="/user/create">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                    </svg>
                    User Baru
                </a>
            @endcan
        </div>
    </div>
    <div class="row">
        <div class="table-responsive small col-xl-10 mt-3">
            <table class="table table-striped table-sm mt-5">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Pengguna</th>
                        <th scope="col">Email</th>
                        <th scope="col">Level</th>
                        <th scope="col">Tgl Registrasi</th>
                        <th scope="col" style="width: 90px" class="text-center">Tools</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="">
                                {{ $loop->iteration }}
                            </td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-capitalize">{{ $user->level }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td class="text-center text-nowrap">
                                <form action="/user/{{ $user->id }}" method="POST" class="d-inline">
                                    @method('DELETE')
                                    @csrf
                                    <button class="badge text-white p-1 bg-danger border border-none"
                                        onclick="return confirm('Yakin ingin hapus ?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-trash3"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
