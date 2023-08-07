<?php
/**
 * @var \App\Class\Assistant\AssistantDTO $assistant
 * @var \App\Models\LongTermMemoryContent $memory
 */
?>

@extends('layout.dashboard')
@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pamięć asystenta: <strong>{{ $assistant->getName() }}</strong></h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Nowa informacja (sieć neuronowa)</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('assistantMemoryAdd') }}" method="POST">
                @csrf
                <input type="hidden" name="assistantId" value="{{ $assistant->getId() }}">
                <div class="form-group">
                    <label>Zawartość</label>
                    <textarea type="text" class="form-control @error('content') is-invalid @enderror" name="content">{{ old('content') }}</textarea>
                    <small class="form-text text-muted">Informacja jaką chcemy zapisać w pamięci</small>
                </div>

                <div class="form-group">
                    <label>Typ</label>
                    <input type="text" class="form-control" value="{{ old('type') }}" name="type"/>
                    <small class="form-text text-muted">DOC, TEXT</small>
                </div>

                <div class="form-group">
                    <label>Link</label>
                    <input type="text" class="form-control" value="{{ old('link') }}" name="link"/>
                </div>

                <button type="submit" class="btn btn-primary col-12">Zapisz informacje</button>
            </form>
        </div>
    </div>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pamięć asystenta</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Zawartość</th>
                        <th>Typ</th>
                        <th>Link</th>
                        <th>Opcje</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Nazwa</th>
                        <th>Typ</th>
                        <th>Link</th>
                        <th>Opcje</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($memories as $memory)
                        <tr>
                            <td>{{ $memory->content }}</td>
                            <td>{{ $memory->type }}</td>
                            <td>{{ $memory->link }}</td>
                            <td>
                                <a href="{{ route('assistantMemoryRemove', ['assistantId' => $assistant->getId(), 'id' => $memory->id]) }}" class="btn btn-danger btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fa-solid fa-trash"></i>
                                        </span>
                                    <span class="text">Usuń</span>
                                </a>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
