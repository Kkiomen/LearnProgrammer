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
        <h1 class="h3 mb-0 text-gray-800">Edytuj szczegóły: <strong>{{ $assistant->getName() }}</strong></h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edytuj: {{ $assistant->getName() }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('assistantSave', ['assistantId' => $assistant->getId()]) }}" method="POST">
                @csrf
                <input type="hidden" name="assistantId" value="{{ $assistant->getId() }}">

                <div class="form-group">
                    <label>Image url</label>
                    <input type="text" class="form-control" value="{{ old('img_url', $assistant->getImgUrl()) }}" name="img_url"/>
                </div>

                <div class="form-group">
                    <label>Nazwa</label>
                    <input type="text" class="form-control" value="{{ old('name', $assistant->getName()) }}" name="name"/>
                </div>


                <div class="form-group">
                    <label>Prompt</label>
                    <textarea type="text" class="form-control @error('prompt') is-invalid @enderror" name="prompt">{{ old('prompt', $assistant->getPromptHistory()->getPrompt()) }}</textarea>
                    <small class="form-text text-muted">Informacja jaką chcemy zapisać w pamięci</small>
                </div>

                <div class="form-group">
                    <label>Typ</label>
                    <select name="type" class="form-control">
                        @foreach ($types as $type)
                            <option value="{{ $type }}" @selected(old('type') == $type)>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">
                        <strong>basic</strong> - Asystent podstawowy<br/>
                        <strong>complaint</strong> - Asystent reklamacja
                    </small>
                </div>

                <div class="form-group">
                    <label>Widoczność</label>
                    <select name="public" class="form-control">
                        <option value="true" @selected(old('public', $assistant->getPublic()) == true)>Publiczny</option>
                        <option value="false" @selected(old('public', $assistant->getPublic()) == false)>Prywatny</option>
                    </select>
                    <small class="form-text text-muted">
                        <strong>basic</strong> - Asystent podstawowy<br/>
                        <strong>complaint</strong> - Asystent reklamacja
                    </small>
                </div>

                <div class="form-group">
                    <label>Kolejność</label>
                    <input type="number" step="1" min="1" class="form-control" value="{{ old('sort', $assistant->getSort()) }}" name="sort"/>
                </div>

                <button type="submit" class="btn btn-primary col-12">Zapisz informacje</button>
            </form>
        </div>
    </div>

@endsection
