- barangkeluar
    - index
        
        ```php
        @extends('layouts.adm-main')
        
        @section('content')
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('barangkeluar.create') }}" class="btn btn-md btn-success mb-3">+ TAMBAH BARANG KELUAR</a>
        
                            <!-- Tambahkan pesan warning -->
                        @if(session('warning'))
                            <div class="alert alert-warning">
                                {{ session('warning') }}
                            </div>
                        @endif
        
                        <!-- Tambahkan pesan sukses -->
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>TGL KELUAR</th>
                                    <th>QTT KELUAR</th>
                                    <th>BARANG ID</th>
                                    <th style="width: 15%">AKSI</th>
        
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rsetBarangKeluar as $rowbarangkeluar)
                                    <tr>
                                        <td>{{ $rowbarangkeluar->id  }}</td>
                                        <td>{{ $rowbarangkeluar->tgl_keluar  }}</td>
                                        <td>{{ $rowbarangkeluar->qty_keluar  }}</td>
                                        <td>{{ $rowbarangkeluar->barang_id  }}</td>
                                        <td class="text-center"> 
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('barangkeluar.destroy', $rowbarangkeluar->id) }}" method="POST">
                                                <a href="{{ route('barangkeluar.show', $rowbarangkeluar->id) }}" class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('barangkeluar.edit', $rowbarangkeluar->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                        
                                    </tr>
                                @empty
                                    <div class="alert">
                                        Data Barang belum tersedia
                                    </div>
                                @endforelse
                            </tbody>
                            <script>
                                setTimeout(function(){
                                    document.querySelectorAll('.alert').forEach(function(alert){
                                        alert.style.display = 'none';
                                    });
                                }, 2000);
                            </script>
                        </table>
                        {{-- {{ $siswa->links() }} --}}
                        </div>
                        </div>
        
                    </div>
                </div>
            </div>
        @endsection
        ```
        
    - create
        
        ```php
        @extends('layouts.adm-main')
        
        @section('content')
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                            <form action="{{ route('barangkeluar.store') }}" method="POST" enctype="multipart/form-data">                    
                                    @csrf
        
                                    <div class="form-group">
                                        <label class="font-weight-bold">Tanggal Keluar</label>
                                        <input type="date" class="form-control @error('tgl_keluar') is-invalid @enderror" name="tgl_keluar" value="{{ old('tgl_keluar') }}" placeholder="Masukkan Tanggal Keluar">
                                    
                                        <!-- error message untuk nama -->
                                        @error('tgl_keluar')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
        
                                    <div class="form-group">
                                        <label class="font-weight-bold">Quantity Keluar</label>
                                        <input type="text" class="form-control @error('qty_keluar') is-invalid @enderror" name="qty_keluar" value="{{ old('qty_keluar') }}" placeholder="Masukkan Quantity">
                                    
                                        <!-- error message untuk nis -->
                                        @error('qty_keluar')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
        
                                    <div class="form-group">
                                        <label for="barang_id" class="font-weight-bold">Barang Id</label>
                                        <input type="text" class="form-control @error('barang_id') is-invalid @enderror" name="barang_id" value="{{ old('barang_id') }}" placeholder="Masukkan Barang Idnya">
                                        <!-- error message untuk barang_id -->
                                        @error('barang_id')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                                    <button type="reset" class="btn btn-md btn-warning">RESET</button>
        
                                </form> 
                            </div>
                        </div>
        
         
        
                    </div>
                </div>
            </div>
        @endsection
        ```
        
    - edit
        
        ```php
        @extends('layouts.adm-main')
        
        @section('content')
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('barangkeluar.update', $rsetBarangKeluar->id) }}" method="POST" enctype="multipart/form-data">                    
                                    @csrf
                                    @method('PUT')
        
                                    <div class="form-group">
                                        <label class="font-weight-bold">Tanggal Keluar</label>
                                        <input type="date" class="form-control @error('tgl_keluar') is-invalid @enderror" name="tgl_keluar" value="{{ old('tgl_keluar', $rsetBarangKeluar->tgl_keluar) }}" placeholder="Masukkan Tanggal Keluar">
                                    
                                        <!-- error message untuk tgl_keluar -->
                                        @error('tgl_keluar')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
        
                                    <div class="form-group">
                                        <label class="font-weight-bold">Quantity</label>
                                        <input type="text" class="form-control @error('qty_keluar') is-invalid @enderror" name="qty_keluar" value="{{ old('qty_keluar', $rsetBarangKeluar->qty_keluar) }}" placeholder="Masukkan Quantity">
                                    
                                        <!-- error message untuk qty_keluar -->
                                        @error('qty_keluar')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
        
                                    <div class="form-group">
                                        <label for="barang_id" class="font-weight-bold">Barang Id</label>
                                        <input type="text" class="form-control @error('barang_id') is-invalid @enderror" name="barang_id" value="{{ old('barang_id', $rsetBarangKeluar->barang_id) }}" placeholder="Masukkan Barang Idnya">
                                        <!-- error message untuk barang_id -->
                                        @error('barang_id')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
        
                                    <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                                    <button type="reset" class="btn btn-md btn-warning">RESET</button>
        
                                </form> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
        ```
        
    - show
        
        ```php
        @extends('layouts.adm-main')
        
        @section('content')
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                       <div class="card border-0 shadow rounded">
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <td>Tanggal Keluar</td>
                                        <td>{{ $rsetBarangKeluar->tgl_keluar }}</td>
                                    </tr>
                                    <tr>
                                        <td>Quantity Barang</td>
                                        <td>{{ $rsetBarangKeluar->qty_keluar }}</td>
                                    </tr>
                                    <tr>
                                        <td>Barang Id</td>
                                        <td>{{ $rsetBarangKeluar->barang_id }}</td>
                                    </tr>
                                    </tr>
                                </table>
                            </div>
                       </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12  text-center">
        
                        <a href="{{ route('barangkeluar.index') }}" class="btn btn-md btn-primary mb-3">Back</a>
                    </div>
                </div>
            </div>
        @endsection
        