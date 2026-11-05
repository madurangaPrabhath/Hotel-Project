<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.css')
</head>
<!-- body -->

<body class="main-layout">
    <!-- loader  -->
    <div class="loader_bg">
        <div class="loader"><img src="images/loading.gif" alt="#" /></div>
    </div>
    <!-- end loader -->
    <!-- header -->
    <header>
        @include('home.header')
    </header>
    <!-- end header inner -->
    <!-- end header -->
    <!-- room details -->
    <section class="room_details_section">
        <div class="container">
            <div class="titlepage">
                <h2>Room Details</h2>
                <p>{{ $room->room_title }}</p>
            </div>
            <div class="row">
                <!-- Room Image -->
                <div class="col-md-6 col-sm-12">
                    <div class="room_img">
                        <figure>
                            <img src="{{ asset($room->image) }}" alt="{{ $room->room_title }}" />
                        </figure>
                    </div>
                </div>
                <!-- Room Info -->
                <div class="col-md-6 col-sm-12">
                    <div class="bed_room">
                        <h3>{{ $room->room_title }}</h3>
                        <div class="room_price">
                            <span class="price">$ {{ $room->price }} / night</span>
                        </div>
                        <p>{{ $room->description }}</p>
                        <ul class="room_features">
                            <li><i class="fa fa-wifi" aria-hidden="true"></i> Free Wifi: {{ $room->wifi }}</li>
                            <li><i class="fa fa-bed" aria-hidden="true"></i> Room Type: {{ ucfirst($room->room_type) }}</li>
                        </ul>
                        <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
                    </div>
                </div>
            </div>
            <!-- Booking Form -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="book_room">
                        <h1>Book This Room</h1>
                        <form class="add_booking" method="POST" action="{{ route('book_room') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <span>Name</span>
                                    <input class="online_book" type="text" name="name" placeholder="Your Name" required>
                                </div>
                                <div class="col-md-6">
                                    <span>Email</span>
                                    <input class="online_book" type="email" name="email" placeholder="Your Email" required>
                                </div>
                                <div class="col-md-6">
                                    <span>Contact Number</span>
                                    <input class="online_book" type="text" name="contact_number" placeholder="Your Contact Number" required>
                                </div>
                                <div class="col-md-6">
                                    <span>Booking Start Date</span>
                                    <img class="date_cua" src="{{ asset('images/date.png') }}">
                                    <input class="online_book" type="date" name="start_date" min="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <span>Booking End Date</span>
                                    <img class="date_cua" src="{{ asset('images/date.png') }}">
                                    <input class="online_book" type="date" name="end_date" min="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-12">
                                    <button class="book_btn" type="submit">Book Now</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end room details -->
    <!--  footer -->
    @include('home.footer')
    <!-- end footer -->
    <!-- Javascript files-->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.0.0.min.js') }}"></script>
    <!-- sidebar -->
    <script src="{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>