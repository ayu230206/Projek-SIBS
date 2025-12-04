@extends('admin.layout.app')

@section('body')
{{-- Navbar (Fixed Top) --}}
@include('partials._navbar', ['userRole' => 'Admin'])


{{-- Main Content Area --}}
<div class="content-wrapper ">
    <main class="py-4 px-3 ">
        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <div class="container-fluid">
            @yield('content')
        </div>
    </main>
</div>

{{-- Footer --}}
@include('partials._footer')


@endsection