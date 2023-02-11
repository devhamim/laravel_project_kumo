@extends('layouts.dashbord')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h2>Role Permission</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>NO</th>
                        <th>User Name</th>
                        <th>Role Name</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($users as $sl=>$user)
                        <tr>
                            <td>{{ $sl+1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                @forelse ($user->getRoleNames() as $role)
                                    <span class="badge badge-success">{{ $role }}</span>
                                @empty
                                    <span class="badge badge-danger">Not Assigned</span>
                                @endforelse
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('remove.role', $user->id) }}">Remove</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
{{-- {{ $roles->getRoleNames()}} --}}
                            
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h2>Add Role</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('user.role.store') }}" method="POST" >
                    @csrf
                    <div class="my-3">
                        <label for="" class="form-label">Select User</label>
                        <select name="user_id" id="" class="form-control">
                            <option value="">-- Select User --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="my-3">
                        <label for="" class="form-label">Select Role</label>
                        <select name="role_id" id="" class="form-control">
                            <option value="">-- Select Role --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="my-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
