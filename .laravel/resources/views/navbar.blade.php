<nav class="navbar navbar-expand-lg">
<div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="nav-link {{($active === "home") ? 'active' : '' }}" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
        <a class="nav-link {{($active === "posts") ? 'active' : '' }}" href="/blog">Blog</a>
        </li>
        <li class="nav-item">
        <a class="nav-link {{($active === "categories") ? 'active' : '' }}" href="/categories">Categories</a>
        </li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="/blog">blog</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
        </ul>
        </li>
        <li class="nav-item">
        <a class="nav-link disabled">Disabled</a>
        </li>
    </ul>
    <form action="/blog" class="d-flex">
        @if(request('category'))
            <input type="hidden" name="category" value="{{request('category')}}">
        @endif
        <input class="form-control me-2" type="text" name="search" placeholder="Search" aria-label="Search"
        value={{request('search')}}>
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    </div>
</div>
</nav>
