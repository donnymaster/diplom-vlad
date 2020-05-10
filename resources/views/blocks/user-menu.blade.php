@if (Auth::user()->role->role_name == 'admin')
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Дизайнери
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('all.designers') }}">Всі дизайнери</a>
          <a class="dropdown-item" href="{{ route('designers.create') }}">Додати дизайнера</a>
        </div>
      </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('feedbacks.index') }}">Зворотній зв'язок</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('orders.admin') }}">Замовлення</a>
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