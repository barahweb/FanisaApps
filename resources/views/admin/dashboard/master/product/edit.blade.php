@extends('admin.dashboard.layouts.main')
@section('container')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="fas fa-money-bill-wave">{{ $title }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/master/products">Data Barang</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="/master/products/{{ $product->kd_menu }}" enctype="multipart/form-data"
                class="forms-sample">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="nm_menu" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control @error('nm_menu')is-invalid             
                        @enderror" id="nm_menu" name="nm_menu"
                        value="{{ old('nm_menu', $product->nm_menu) }}">
                    @error('nm_menu')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Kategori</label>
                    <select class="form-control select2" name="id_kategori">
                        @foreach ($categories as $category)
                        <option value="{{ $category->id_kategori }}" {{ $category->id_kategori ==  old('id_kategori', $product->id_kategori) ? 'selected': ''}}>{{ $category->nm_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga Barang</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white">Rp</span>
                        </div>
                        <input type="text" class="form-control @error('harga')is-invalid             
                     @enderror" id="harga" name="harga"
                            value="{{ old('harga', number_format($product->harga, 0, ',', '.')) }}"
                            onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                        @error('harga')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <div class="custom-file-container" data-upload-id="myUniqueUploadId2">

                        <label>Upload Gambar
                            <a href="javascript:void(0)" class="custom-file-container__image-clear"
                                title="Clear Image">&times;</a></label>
                        <label class="custom-file-container__custom-file">
                            <input type="file" class="custom-file-container__custom-file__custom-file-input" accept="*"
                                multiple aria-label="Pilih Gambar" name="gambar[]" />
                            <input type="hidden" name="oldImage" id="oldImage" value="">
                            <input type="hidden" name="gambarBaru" id="gambarBaru" value="">
                            <input type="hidden" value="{{ $product->kd_menu }}" name="id_product" id="id_product">
                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                        </label>
                        <div class="custom-file-container__image-preview"></div>
                    </div>


                </div>
                {{-- <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Barang</label>
                    <input id="deskripsi" value="{{ $product->deskripsi }}" type="hidden" name="deskripsi">
                    <trix-editor input="deskripsi"></trix-editor>
                </div> --}}
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
<script>
    function showImageHereFunc() {
        var total_file=document.getElementById("gambar").files.length;
        $('#showImageHere').empty();
        for(var i=0;i<total_file;i++) {
        let element = $("<div class='card col-md-1' style='padding: 5px 15px; margin-left: 10px;'><img class='card-img-top'style='height: 100px; width: 100px;display: inline-block;' src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
        $('#showImageHere').append(element);
        }
    }
</script>
@endsection