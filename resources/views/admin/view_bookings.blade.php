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
                                    <td>{{ $booking->status }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No bookings found.</td>
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