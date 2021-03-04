@extends('layouts.base')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dados</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <table id="dtAjax" class="table table-striped table-bordered dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>Fonte</th>
                            <th>Título</th>		                                            
                            <th>Subtitulo</th>
                            <th>Data publicação</th>
                            <th>Data coleta</th>
                            <th>Texto</th>
                            <th>Tags</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>	    
            </div>
        </div>
    </div>       
      

    </div>
@endsection

@push('scripts')
  <script src="{{ asset('./js/list.js') }}"></script>
@endpush