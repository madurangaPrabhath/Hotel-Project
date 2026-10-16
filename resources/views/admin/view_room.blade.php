<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h2 class="h5 no-margin-bottom">View Rooms</h2>
            </div>
        </div>
        <section>
            <div class="container-fluid">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if(count($rooms) > 0)
                    <div class="row">
                        @foreach($rooms as $room)
                            <div class="col-lg-4 col-md-6">
                                <div class="block card">
                                    @if($room->image && file_exists(public_path($room->image)))
                                        <img src="{{ asset($room->image) }}" alt="{{ $room->room_title }}"
                                            class="card-img-top room-image">
                                    @else
                                        <div class="bg-light text-center py-4">
                                            <i class="fa fa-bed fa-3x text-muted mb-2"></i>
                                            <p class="text-muted small">No image</p>
                                        </div>
                                    @endif

                                    <div class="card-body">
                                        <h5 class="card-title">{{ $room->room_title }}</h5>

                                        <div class="mb-2">
                                            <span class="badge badge-info">{{ ucfirst($room->room_type) }}</span>
                                            @if($room->wifi == 'yes')
                                                <span class="badge badge-success">Free Wifi</span>
                                            @else
                                                <span class="badge badge-secondary">No Wifi</span>
                                            @endif
                                        </div>

                                        <p class="card-text text-muted small">{{ $room->description }}</p>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="font-weight-bold">${{ $room->price }}</span>
                                            <form action="{{ route('delete_room', $room->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this room?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                            <a href="{{ route('edit_room', $room->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="block text-center py-5">
                        <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                        <h5>No rooms found</h5>
                        <p class="text-muted">You haven't added any rooms yet.</p>
                        <a href="{{ url('create_room') }}" class="btn btn-primary">Add Room</a>
                    </div>
                @endif

            </div>
        </section>
    </div>

    @include('admin.footer')
</body>

</html>