<nav aria-label="breadcrumb" role="navigation">
    <ol class="breadcrumb mb-0">
        @for ($i = 0; $i < count($breadcrumb) - 1; $i++)
            <li class="breadcrumb-item">
                <a href="{{ $breadcrumb[$i]['url'] }}">{{ $breadcrumb[$i]['text'] }}</a>
            </li>
        @endfor
        <li class="breadcrumb-item active" aria-current="page">
          {{ $breadcrumb[count($breadcrumb) - 1]['text'] }}
        </li>
    </ol>
</nav>