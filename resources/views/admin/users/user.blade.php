@extends('layouts.dashbord')

@section('content')
<div class="container">
<div class="row">
    <div class="col-lg-8 ">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @can('Show_user')
        <div class="card">
            <div class="card-header">
                <h2>User List <span style="float: right">Total user: {{ $total_count }}</span></h2>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <td>no</td>
                        <td>Photo</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Created</td>
                        <td>Action</td>
                    </tr>
                    @foreach($users as $key => $user )
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>
                            @if ($user->photo == null)
                                <img width="50" src="{{ Avatar::create($user->name)->toBase64() }}" />
                            @else
                                <img width="50" src="{{ asset('uplodes/profile') }}/{{ $user->photo }}" />
                            @endif

                        </td>
                        <td>{{$user->name}}</td>
                        <td>
                            @can('show_user_mail')
                                {{$user->email}}
                            @endcan
                        </td>
                        <td>{{$user->created_at->diffForHumans()}}</td>
                        <td>
                            @can('Delete_user')
                                <a class="btn btn-danger" href="{{ route('user.delete', $user->id) }}">Delete</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        @endcan
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="text-center mb-4">Sign up your account</h4>
            </div>
            <div class="card-body">
                <div class="">
                    <div class="">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label class="mb-1"><strong>Username</strong></label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                            <div class="form-group">
                                <label class="mb-1 "><strong>Email</strong></label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                            </div>
                            <div class="form-group">
                                <label class="mb-1 "><strong>Password</strong></label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                            </div>
                            <div class="form-group">
                                <label class="mb-1 "><strong>Confirm Password</strong></label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn bg-primary text-white btn-block">Sign me up</button>
                            </div>
                        </form>
                        {{-- <div class="new-account mt-3">
                            <p class="">Already have an account? <a class="" href="{{route('login')}}">Sign in</a></p>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
