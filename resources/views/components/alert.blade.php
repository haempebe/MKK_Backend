<div>
    @if ($message = session()->has('success'))
        <div class="alert alert-success fade show" role="alert">
            <p class="mb-0">{{ session()->get('success') }}</p>
        </div>
    @endif
    @if ($message = session()->has('error'))
        <div class="alert alert-danger" role="alert">
            <p class="mb-0">{{ session()->get('error') }}</p>
        </div>
    @endif
</div>
