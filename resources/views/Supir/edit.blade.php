@extends('layouts.admin')

@section('main-content')

   @if ($errors->any())
      <div class="alert alert-danger">
         <ul>
            @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
            @endforeach
         </ul>
      </div>
   @endif

   <div class="card mt-4">
      <div class="card-body">

         <h5 class="card-title fw-bolder mb-3">Ubah Data Supir</h5>

         <form method="post" action="{{ route('supir.update', $data->id_supir) }}">
            @csrf
            <input type="text" class="form-control visually-hidden" id="id_supir" name="id_supir"
               value="{{ $data->id_supir }}">
            <div class="mb-3">
               <label for="nama_supir" class="form-label">Nama</label>
               <input type="text" class="form-control" id="nama_supir" name="nama_supir"
                  value="{{ $data->nama_supir }}">
            </div>
            <div class="mb-3">
               <label for="jam_terbang" class="form-label">Jam Terbang</label>
               <input type="text" class="form-control" id="jam_terbang" name="jam_terbang"
                  value="{{ $data->jam_terbang }}">
            </div>
            <div class="mb-3">
               <label for="plat" class="form-label">ID_Bus sebelumnya {{ $data->plat }}</label>
               <select class="form-select" id="plat" name="plat" aria-label="Default select example">
                  <option value="1" selected>Santika</option>
                  <option value="2">Po Haryanto</option>
                  <option value="3">Jiwa Seraya</option>
                  <option value="4">Sarotaga</option>
               </select>
            </div>
            <div class="text-center">
               <input type="submit" class="btn btn-primary" value="Ubah" />
            </div>
         </form>
      </div>
   </div>

@stop
