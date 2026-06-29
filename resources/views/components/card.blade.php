@props(['title' => null, 'subtitle' => null, 'padding' => true, 'parent' => false])

<div {{ $attributes->merge(['class' => 'bg-white border border-slate-100 shadow-sm ' . ($parent ? 'rounded-xl md:rounded-2xl' : 'rounded-lg md:rounded-xl') . ' overflow-hidden']) }}>
    @if($title || $subtitle)
        <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
            @if($title)
                <h3 class="text-base font-bold text-slate-800">{{ $title }}</h3>
            @endif
            @if($subtitle)
                <p class="text-xs text-slate-500 mt-0.5">{{ $subtitle }}</p>
            @endif
        </div>
    @endif
    <div class="{{ $padding ? 'p-5' : '' }}">
        {{ $slot }}
    </div>
</div>
