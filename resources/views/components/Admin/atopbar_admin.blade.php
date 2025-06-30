<script src="https://unpkg.com/lucide@latest"></script>
<header class="topbar">
    <div class="welcome">
        <h2>
            @if(isset($icon))
                <i class="{{ $icon }}"></i>
            @else
                <i class="fas fa-user-cog"></i>
            @endif

            {{ $title ?? 'Dashboard Admin' }}
        </h2>

        @if(auth('admin')->check())
            <p>Login sebagai <strong>{{ auth('admin')->user()->username }}</strong></p>
        @else
            <p><em>Belum login</em></p>
        @endif
    </div>

    @if(auth('admin')->check())
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    @endif
</header>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />