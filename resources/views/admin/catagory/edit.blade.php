@extends('layouts.dashbord')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <h2>Catagory</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('catagory.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="my-3">
                            <input type="hidden"  name="catagoris_id" value="{{ $catagori_info->id }}">

                            <label for="" class="form-label">Catagory Name</label>
                            <input type="text" class="form-control" name="catagory_name" value="{{ $catagori_info->catagory_name }}">
                            @error('catagory_name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label">Catagory Image</label>
                            <input type="file" class="form-control" name="catagory_img"   onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                            @error('catagory_img')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                            <div class="my-5">
                                <img width="100" id="blah" src="{{ asset('uplodes/catagory_img/') }}/{{ $catagori_info->catagory_img }}" alt="">
                            </div>
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
