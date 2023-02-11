@extends('layouts.dashbord')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-10">
            @if(session('success_update'))
                <div class="alert alert-success">{{ session('success_update') }}</div>
            @else

            @endif
            <div class="card">
                <div class="card-header">
                    <h2>Catagory</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('subcatagory.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden"  name="id" value="{{ $subcatagori_info->id }}">
                        <div class="my-3">
                            <select name="catagory_id" class="form-control">
                                <option value=""> -- Select Catagory --</option>
                                @foreach ($catagories as $catagory)
                                    <option value="{{ $catagory->id }}" {{ ($catagory->id == $subcatagori_info->catagory_id? 'selected':'') }}>{{ $catagory->catagory_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label">SubCatagory Name</label>
                            <input type="text" class="form-control" name="subcatagory_name" value="{{ $subcatagori_info->subcatagory_name }}">
                            @error('subcatagory_name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label">SubCatagory Image</label>
                            <input type="file"  class="form-control" name="subcatagory_img" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                            <div>
                                <img width="200" id="blah" src="{{ asset('uplodes/subcatagory') }}/{{ $subcatagori_info->subcatagory_img }}">
                            </div>
                            @error('subcatagory_img')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="my-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
