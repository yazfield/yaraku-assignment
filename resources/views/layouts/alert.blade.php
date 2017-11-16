@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

@elseif (session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>

@elseif (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif