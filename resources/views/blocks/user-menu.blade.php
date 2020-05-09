@if (Auth::user()->role->role_name == 'admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('designers.index') }}">Дизайнери</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('designers.create') }}">Додати дизайнера</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('feedbacks.index') }}">Зворотній зв'язок</a>
    </li>
@else
    <li class="nav-item">
        <a class="nav-link" href="{{ route('designers.index') }}">Дизайнери</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('orders.create') }}">Нове замовлення</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('orders.index') }}">Мої замовлення</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('feedbacks.create') }}">Зворотній зв'язок</a>
    </li>
@endif

<li class="nav-item">
    <a class="nav-link" href="{{ route('logout') }}"
    onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"
    >Вихід</a>
</li>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>