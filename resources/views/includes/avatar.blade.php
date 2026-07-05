@if(Auth::user()->image)
    <div class="avatar-container">
        <img src="{{ route('user.avatar', Auth::user()->image) }}" alt="User Avatar" class="avatar w-8 h-8 rounded-full object-cover">
    </div>
@endif