<?php
    /**
     * @var \App\Class\Assistant\AssistantDTO $assistant
 */
?>

@extends('layout.dashboard')
@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Lista asystentów</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista asystentów</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Nazwa</th>
                        <th>Publiczny</th>
                        <th>Opcje</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Nazwa</th>
                        <th>Publiczny</th>
                        <th>Opcje</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($assistants as $assistant)
                        <tr>
                            <td>{{ $assistant->getName() }}</td>
                            <td>@if($assistant->getPublic()) <i class="fa-solid fa-circle-check text-success fa-lg"></i> @else <i class="fa-solid fa-circle-xmark fa-lg"></i> @endif</td>
                            <td>
                                <a href="{{ route('assistants_memory', ['assistantId' => $assistant->getId()]) }}" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fa-solid fa-database"></i>
                                        </span>
                                    <span class="text">Pamięć</span>
                                </a>

                                <a href="{{ route('assistant_edit', ['assistantId' => $assistant->getId()]) }}" class="btn btn-secondary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </span>
                                    <span class="text">Edytuj</span>
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
