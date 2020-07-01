@if ($files->count() == 0)
    <div class="alert bg-info">Es sind keine Dateien hinterlegt.</div>
@else
    <div class="row">
        @foreach($files as $file)
        <div class="col-md-4 col-sm-12">
            <a href="{{ asset($file->imagePath()) }}" target="_blank">
                <img src="{{ asset($file->thumbnailPath()) }}" class="img-fluid">
            </a>
            {{ $file->name }}
        </div>
        @endforeach
    </div>
@endif