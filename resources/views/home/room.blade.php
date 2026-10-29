<div class="our_room">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2>Our Room</h2>
                    <p>Lorem Ipsum available, but the majority have suffered </p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($room as $r)
            <div class="col-md-4 col-sm-6">
                <div id="serv_hover" class="room">
                    <div class="room_img">
                        <figure><img src="{{ asset($r->image) }}" alt="{{ $r->room_title }}" /></figure>
                    </div>
                    <div class="bed_room">
                        <h3>{{ $r->room_title }}</h3>
                        <p>{{ $r->description }}</p>
                        <p>Price: ${{ $r->price }} | Wifi: {{ $r->wifi }} | Type: {{ $r->room_type }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>