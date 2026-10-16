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
                <h2 class="h5 no-margin-bottom">Add Room</h2>
            </div>
        </div>
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="block">
                            <form method="POST" action="{{ url('add_room') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="room_title">Room Title</label>
                                    <input type="text" name="room_title" id="room_title" class="form-control"
                                        placeholder="Enter room title" value="{{ old('room_title') }}" required>
                                    @error('room_title')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="4"
                                        placeholder="Enter room description">{{ old('description') }}</textarea>
                                    @error('description')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" name="price" id="price" class="form-control"
                                        placeholder="Enter price" value="{{ old('price') }}" step="0.01" min="0" required>
                                    @error('price')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="room_type">Room Type</label>
                                    <select name="room_type" id="room_type" class="form-control" required>
                                        <option value="">-- Select Room Type --</option>
                                        <option value="regular" {{ old('room_type') == 'regular' ? 'selected' : '' }}>Regular</option>
                                        <option value="premium" {{ old('room_type') == 'premium' ? 'selected' : '' }}>Premium</option>
                                        <option value="deluxe" {{ old('room_type') == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                                    </select>
                                    @error('room_type')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Free Wifi</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="wifi" id="wifi_yes" value="yes"
                                            {{ old('wifi', 'yes') == 'yes' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="wifi_yes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="wifi" id="wifi_no" value="no"
                                            {{ old('wifi') == 'no' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="wifi_no">No</label>
                                    </div>
                                    @error('wifi')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="image">Upload Image</label>
                                    <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
                                    @error('image')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ url('create_room') }}" class="btn btn-secondary ml-2">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('admin.footer')
</body>

</html>