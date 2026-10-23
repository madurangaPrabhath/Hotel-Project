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
                            <a href="#" class="btn btn-sm btn-warning ml-2 edit-room-btn"
                                data-toggle="modal"
                                data-target="#editRoomModal"
                                data-action="{{ route('update_room', $room->id) }}"
                                data-id="{{ $room->id }}"
                                data-title="{{ $room->room_title }}"
                                data-description="{{ $room->description }}"
                                data-price="{{ $room->price }}"
                                data-room-type="{{ $room->room_type }}"
                                data-wifi="{{ $room->wifi }}"
                                data-image="{{ $room->image ? asset($room->image) : '' }}">Edit</a>
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

    <div class="modal fade" id="editRoomModal" tabindex="-1" role="dialog" aria-labelledby="editRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoomModalLabel">Edit Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="editRoomForm" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_room_title">Room Title</label>
                            <input type="text" name="room_title" id="edit_room_title" class="form-control" required>
                            @error('room_title')
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                            @error('description')
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="edit_price">Price</label>
                            <input type="number" name="price" id="edit_price" class="form-control" step="0.01" min="0" required>
                            @error('price')
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="edit_room_type">Room Type</label>
                            <select name="room_type" id="edit_room_type" class="form-control" required>
                                <option value="">-- Select Room Type --</option>
                                <option value="regular">Regular</option>
                                <option value="premium">Premium</option>
                                <option value="deluxe">Deluxe</option>
                            </select>
                            @error('room_type')
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Free Wifi</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="wifi" id="edit_wifi_yes" value="yes">
                                <label class="form-check-label" for="edit_wifi_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="wifi" id="edit_wifi_no" value="no">
                                <label class="form-check-label" for="edit_wifi_no">No</label>
                            </div>
                            @error('wifi')
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label for="edit_image">Upload Image</label>
                            <input type="file" name="image" id="edit_image" class="form-control-file">
                            <div class="mt-2" id="editImagePreviewWrap" style="display: none;">
                                <img id="editImagePreview" alt="Current image"
                                    style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 4px;">
                                <p class="text-muted small mt-1">Current image</p>
                            </div>
                            @error('image')
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('admin.footer')

    {{-- Server-rendered values for the edit modal, kept out of the script block --}}
    @php($editRoomErrorId = session('edit_room_id'))
    @php($editRoomError = $editRoomErrorId ? $rooms->firstWhere('id', (int) $editRoomErrorId) : null)
    <div id="editRoomDefaults"
        data-has-errors="{{ $errors->any() ? '1' : '0' }}"
        data-error-action="{{ $editRoomErrorId ? url('update_room') . '/' . $editRoomErrorId : '' }}"
        data-old-title="{{ old('room_title') }}"
        data-old-description="{{ old('description') }}"
        data-old-price="{{ old('price') }}"
        data-old-room-type="{{ old('room_type') }}"
        data-old-wifi="{{ old('wifi') }}"
        data-error-image="{{ $editRoomError && $editRoomError->image ? asset($editRoomError->image) : '' }}"></div>

    <script>
        $(function () {
            var $defaults = $('#editRoomDefaults');

            $(document).on('click', '.edit-room-btn', function () {
                var $btn = $(this);

                $('#editRoomForm').attr('action', $btn.data('action'));

                $('#edit_room_title').val($btn.data('title'));
                $('#edit_description').val($btn.data('description'));
                $('#edit_price').val($btn.data('price'));
                $('#edit_room_type').val($btn.data('room-type'));

                var wifi = $btn.data('wifi');
                $('#edit_wifi_yes').prop('checked', wifi === 'yes');
                $('#edit_wifi_no').prop('checked', wifi === 'no');

                var image = $btn.data('image');
                if (image) {
                    $('#editImagePreview').attr('src', image);
                    $('#editImagePreviewWrap').show();
                } else {
                    $('#editImagePreview').removeAttr('src');
                    $('#editImagePreviewWrap').hide();
                }

                $('#edit_image').val('');
            });

            $('#editRoomModal').on('hidden.bs.modal', function () {
                $('#edit_image').val('');
            });

            if ($defaults.data('has-errors') === '1') {
                var errorAction = $defaults.attr('data-error-action');
                if (errorAction) {
                    $('#editRoomForm').attr('action', errorAction);
                }

                $('#edit_room_title').val($defaults.attr('data-old-title'));
                $('#edit_description').val($defaults.attr('data-old-description'));
                $('#edit_price').val($defaults.attr('data-old-price'));
                $('#edit_room_type').val($defaults.attr('data-old-room-type'));

                var oldWifi = $defaults.attr('data-old-wifi');
                $('#edit_wifi_yes').prop('checked', oldWifi === 'yes');
                $('#edit_wifi_no').prop('checked', oldWifi === 'no');

                var errorImage = $defaults.attr('data-error-image');
                if (errorImage) {
                    $('#editImagePreview').attr('src', errorImage);
                    $('#editImagePreviewWrap').show();
                } else {
                    $('#editImagePreview').removeAttr('src');
                    $('#editImagePreviewWrap').hide();
                }

                $('#editRoomModal').modal('show');
            }
        });
    </script>
</body>

</html>