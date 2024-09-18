<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-container {
            position: relative;
            width: 100%;
            max-width: 150px;
        }

        .profile-container img {
            width: 100%;
        }

        .edit-icon {
            position: absolute;
            top: 0;
            right: 0;
            display: none;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 5px;
            border-radius: 50%;
            cursor: pointer;
        }

        .profile-container:hover .edit-icon {
            display: block;
        }

        .edit-form {
            display: none;
            margin-top: 10px;
        }

        .edit-form.active {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="profile-container">
                        <img id="profileImage"
                            src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://via.placeholder.com/150' }}"
                            class="card-img-top" alt="Profile Photo">
                        <span class="edit-icon" onclick="showEditForm()">&#9998;</span> <!-- Edit Icon -->
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->name }}</h5>
                        <p class="card-text">{{ $user->email }}</p>
                        <p class="card-text">{{ $user->contact_num }}</p>
                        <p class="card-text"><small class="text-muted">Member since
                                {{ $user->created_at->format('F Y') }}</small></p>

                        <!-- Hidden Form for Image Upload -->
                        {{-- <form id="editForm" class="edit-form" action="{{ route('profile.update', $user->id) }}"
                            method="POST" enctype="multipart/form-data"> --}}
                        <form id="editForm" class="edit-form" action="" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <input type="file" name="profile_photo" id="profilePhotoInput" accept="image/*"
                                    class="form-control">
                            </div>
                            <button type="submit" class="btn btn-success">Finish</button>
                            <button type="button" class="btn btn-secondary" onclick="hideEditForm()">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        User Information
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>ID:</strong> {{ $user->id }}</li>
                        <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                        <li class="list-group-item"><strong>Contact Number:</strong> {{ $user->contact_num }}</li>
                        <li class="list-group-item"><strong>Created At:</strong>
                            {{ $user->created_at->format('F j, Y, g:i a') }}</li>
                        <li class="list-group-item"><strong>Updated At:</strong>
                            {{ $user->updated_at->format('F j, Y, g:i a') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showEditForm() {
            document.getElementById('editForm').classList.add('active');
        }

        function hideEditForm() {
            document.getElementById('editForm').classList.remove('active');
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
