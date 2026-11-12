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
                <h2 class="h5 no-margin-bottom">View Bookings</h2>
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
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Room</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->room->room_title ?? $booking->room_id }}</td>
                                    <td>{{ $booking->name }}</td>
                                    <td>{{ $booking->email }}</td>
                                    <td>{{ $booking->contact_number }}</td>
                                    <td>{{ $booking->start_date }}</td>
                                    <td>{{ $booking->end_date }}</td>
                                    <td>
                                        @php
                                            $statusBadge = $booking->status === 'approved' ? 'badge-success' : ($booking->status === 'rejected' ? 'badge-danger' : 'badge-warning');
                                        @endphp
                                        <span class="badge {{ $statusBadge }}">{{ ucfirst($booking->status) }}</span>
                                    </td>
                                    <td>${{ $booking->room->price ?? '-' }}</td>
                                    <td>
                                        @if($booking->room && $booking->room->image && file_exists(public_path($booking->room->image)))
                                            <img src="{{ asset($booking->room->image) }}" alt="{{ $booking->room->room_title }}" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            <span class="text-muted small">No image</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('delete_booking', $booking->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>

                                        @if($booking->status === 'pending')
                                            <form action="{{ route('approve_booking', $booking->id) }}" method="POST" style="display:inline; margin-left: 2px;" onsubmit="return confirm('Are you sure you want to approve this booking?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                            </form>
                                            <form action="{{ route('reject_booking', $booking->id) }}" method="POST" style="display:inline; margin-left: 2px;" onsubmit="return confirm('Are you sure you want to reject this booking?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning">Reject</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">No bookings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    @include('admin.footer')
</body>

</html>