<!-- Form Edit Profil -->
<form action="{{ route('profile.update') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Update Profile</button>
</form>