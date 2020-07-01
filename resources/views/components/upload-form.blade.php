<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Beschreibung</label>
        <input type="text" name="name" class="form-control @error('name', 'files') is-invalid @enderror" minlength="3" maxlength="255">
        <small class="form-text text-muted">Diese Beschreibung wird allen Bildern zugeordnet, die in einem Vorgang hochgeladen werden.</small>
    </div>
    @error('name', 'files')
        <p class="text-danger">{{ $message }}
    @enderror
    <div class="form-group">
        <input type="file" name="files[]" class=" btn btn-secondary @error('files', 'files') text-danger @enderror " multiple>
    </div>
    @error('files', 'files')
        <p class="text-danger">{{ $message }}</p>
    @enderror
    <button type="submit" class="btn btn-primary mt-3">Hochladen</button>
</form>