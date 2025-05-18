@props(['id', 'name', 'status'])

<p>Status: {{ $status }}</p>

@php
    $statusLower = strtolower($status);

    $style = $statusLower == 'running' ? 'label-success' : 'label-danger';
@endphp

<style>
    #status-{{ Str::slug($name, '-') }}.label-success {
        background-color: rgb(21, 148, 21) !important;
        color: white !important;
        padding: 10px 10px !important;
        border-radius: 3px !important;
    }

    #status-{{ Str::slug($name, '-') }}.label-danger {
        background-color: rgb(40, 51, 199) !important;
        color: white !important;
        padding: 10px 10px !important;
        border-radius: 3px !important;
    }
</style>

<li id="{{ $id }}">
    {{ $name }}
    <span id="status-{{ Str::slug($name, '-') }}" class="pull-right {{ $style }} label-1 label">
        {{ $status }}
    </span>
</li>
