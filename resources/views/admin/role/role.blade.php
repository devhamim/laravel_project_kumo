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
                        <th>Role Name</th>
                        <th>Permission</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($roles as $sl=>$role)
                        <tr>
                            <td>{{ $sl+1 }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @foreach ($role->getPermissionNames() as $permission)
                                   <span class="badge badge-info my-2">{{ $permission }}</span>
                                @endforeach
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="">Edit</a>
                                        <a class="dropdown-item" href="{{ route('permition.delete', $role->id) }}">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    {{-- add permition start --}}

    {{-- <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h2>Add Permission</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('add.permission') }}" method="POST" >
                    @csrf
                    <div class="my-3">
                        <label for="" class="form-lable">Permission</label>
                        <input type="text" name="permission" class="form-control" placeholder="Permission">
                    </div>
                    <div class="my-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

    {{-- add permition end --}}

    {{-- add role start --}}

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h2>Add Role</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('add.role') }}" method="POST" >
                    @csrf
                    <div class="my-3">
                        <label for="" class="form-lable">Role Name</label>
                        <input type="text" name="role" class="form-control" placeholder="Role">
                    </div>
                    <div class="my-3">
                        <label for="" class="form-lable">Permission</label>
                        <div class="form-group">
                            @foreach ($permissions as $permission)
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="permission[]" class="form-check-input" value="{{ $permission->id }}">{{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="my-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

        {{-- add role end --}}

</div>
@endsection
