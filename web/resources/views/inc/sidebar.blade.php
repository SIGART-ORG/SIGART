<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg  navigation">
                    <a class="navbar-brand" href="index.html">
                        <img src="{{ URL::asset('dist/images/logo.png') }}" alt="">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto main-nav ">
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ URL::to('/') }}">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ URL::to('/about-us') }}">Nosotros</a>
                            </li>
                            <li class="nav-item dropdown dropdown-slide">
                                <a class="nav-link dropdown-toggle" href="{{ URL::to('/products') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Productos <span><i class="fa fa-angle-down"></i></span>
                                </a>
                                <!-- Dropdown list -->
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ URL::to('/most-seen') }}">Lo mas visto</a>
                                    <a class="dropdown-item" href="{{ URL::to('/products') }}">Productos</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ URL::to('/blog') }}">Blog</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ml-auto mt-10">
                            <li class="nav-item">
                                <a class="nav-link login-button" href="index.html">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link add-button" href="#"><i class="fa fa-plus-circle"></i> Add Listing</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</section>