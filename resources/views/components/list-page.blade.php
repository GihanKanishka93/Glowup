@props([
    'title',
    'subtitle' => null,
    'backRoute' => null,
    'backLabel' => 'Back',
])

<div {{ $attributes->merge(['class' => 'list-page']) }}>
    <div class="list-toolbar">
        <div class="list-toolbar-heading">
            <h1 class="page-title">{{ $title }}</h1>
            @if($subtitle)
                <p class="page-subtitle">{{ $subtitle }}</p>
            @endif
        </div>
        <div class="list-toolbar-actions">
            @if($backRoute)
                <a href="{{ $backRoute }}" class="btn btn-outline-primary btn-sm list-back-btn">
                    <i class="fas fa-arrow-left me-1"></i>{{ $backLabel }}
                </a>
            @endif
            {{ $actions ?? '' }}
        </div>
    </div>

    <div class="card list-card shadow-sm border-0">
        <div class="card-body">
            {{ $slot }}
        </div>
    </div>
</div>
