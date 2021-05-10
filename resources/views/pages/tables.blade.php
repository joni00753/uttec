@extends('layouts.app',['title' => 'home'])

@section('content')
  <condominios  ruta_home="{{ route('home') }}" ruta_lista_clientes="{{ route('clientes-list') }}" ruta_lista_condominios="{{ route('condominios-list') }}" ruta_guarda_condominio="{{ route('condominios-save') }}" ruta_elmina_condominio="{{ route('condominios-delete','*condominio*') }}" />
@endsection

@push('js')
  <!-- Argon Scripts -->
  <script src="../assets/vendor/jquery/dist/jquery.min.js" type="application/javascript"></script>
  <script src="../assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js" type="application/javascript"></script>
@endpush