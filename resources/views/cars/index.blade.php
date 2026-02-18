@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">Cars for Sale</h2>
                    <p class="text-muted mb-0">Browse secondhand vehicles from our community</p>
                </div>
                @auth
                    <a href="{{ route('cars.create') }}" class="btn btn-primary">List a Car</a>
                @endauth
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @forelse($cars as $car)
                <div class="card mb-4">
                    @if($car->image_path)
                        <img src="{{ asset('storage/' . $car->image_path) }}" 
                             class="card-img-top" 
                             alt="{{ $car->make }} {{ $car->model }}"
                             style="width: 100%; height: 350px; object-fit: cover; object-position: center;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 350px;">
                            <span class="text-muted">No image available</span>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h3 class="card-title">
                                    <a href="{{ route('cars.show', $car) }}" class="text-decoration-none">
                                        {{ $car->year }} {{ $car->make }} {{ $car->model }}
                                    </a>
                                </h3>
                                <p class="text-muted small">
                                    By {{ $car->user->name }} | {{ $car->created_at->format('M d, Y') }}
                                </p>
                            </div>
                            <div class="text-end">
                                <p class="h5 mb-0 text-primary">${{ number_format($car->price, 2) }}</p>
                            </div>
                        </div>
                        <p class="card-text">{{ Str::limit($car->description, 200) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('cars.show', $car) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                            @can('update', $car)
                                <div>
                                    <a href="{{ route('cars.edit', $car) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <form action="{{ route('cars.destroy', $car) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this listing?')">Delete</button>
                                    </form>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    <p class="mb-0">No cars found. @auth <a href="{{ route('cars.create') }}">List the first car!</a> @endauth</p>
                </div>
            @endforelse

            <div class="d-flex justify-content-center">
                {{ $cars->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
