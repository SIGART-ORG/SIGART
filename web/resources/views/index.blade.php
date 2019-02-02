<!DOCTYPE html>
<html lang="es">
    <head>

        <!-- SITE TITTLE -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Calssimax</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- PLUGINS CSS STYLE -->
        <link href="{{ URL::asset('dist/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
        <!-- Bootstrap -->
        <link href="{{ URL::asset('dist/plugins/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{ URL::asset('dist/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <!-- Owl Carousel -->
        <link href="{{ URL::asset('dist/plugins/slick-carousel/slick/slick.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('dist/plugins/slick-carousel/slick/slick-theme.css') }}" rel="stylesheet">
        <!-- Fancy Box -->
        <link href="{{ URL::asset('dist/plugins/fancybox/jquery.fancybox.pack.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('dist/plugins/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('dist/plugins/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css') }}" rel="stylesheet">
        <!-- CUSTOM CSS -->
        <link href="{{ URL::asset('dist/css/style.css') }}" rel="stylesheet">

        <!-- FAVICON -->
        <link href="{{ URL::asset('img/favicon.png') }}" rel="shortcut icon">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body class="body-wrapper">


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
                                        <a class="nav-link" href="index.html">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="dashboard.html">Dashboard</a>
                                    </li>
                                    <li class="nav-item dropdown dropdown-slide">
                                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Pages <span><i class="fa fa-angle-down"></i></span>
                                        </a>
                                        <!-- Dropdown list -->
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="category.html">Category</a>
                                            <a class="dropdown-item" href="single.html">Single Page</a>
                                            <a class="dropdown-item" href="store-single.html">Store Single</a>
                                            <a class="dropdown-item" href="dashboard.html">Dashboard</a>
                                            <a class="dropdown-item" href="user-profile.html">User Profile</a>
                                            <a class="dropdown-item" href="submit-coupon.html">Submit Coupon</a>
                                            <a class="dropdown-item" href="blog.html">Blog</a>
                                            <a class="dropdown-item" href="single-blog.html">Single Post</a>
                                        </div>
                                    </li>
                                    <li class="nav-item dropdown dropdown-slide">
                                        <a class="nav-link dropdown-toggle" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Listing <span><i class="fa fa-angle-down"></i></span>
                                        </a>
                                        <!-- Dropdown list -->
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
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

        <!--===============================
        =            Hero Area            =
        ================================-->

        <section class="hero-area bg-1 text-center overly">
        <!-- Container Start -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Header Contetnt -->
                        <div class="content-block">
                            <h1>Buy & Sell Near You </h1>
                            <p>Join the millions who buy and sell from each other <br> everyday in local communities around the world</p>
                            <div class="short-popular-category-list text-center">
                                <h2>Popular Category</h2>
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <a href=""><i class="fa fa-bed"></i> Hotel</a></li>
                                    <li class="list-inline-item">
                                        <a href=""><i class="fa fa-grav"></i> Fitness</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href=""><i class="fa fa-car"></i> Cars</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href=""><i class="fa fa-cutlery"></i> Restaurants</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href=""><i class="fa fa-coffee"></i> Cafe</a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <!-- Advance Search -->
                        <div class="advance-search">
                            <form action="#">
                                <div class="row">
                                    <!-- Store Search -->
                                    <div class="col-lg-6 col-md-12">
                                        <div class="block d-flex">
                                            <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="search" placeholder="Search for store">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="block d-flex">
                                            <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="search" placeholder="Search for store">
                                            <!-- Search Button -->
                                            <button class="btn btn-main">SEARCH</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
            <!-- Container End -->
        </section>

        <!--===================================
        =            Client Slider            =
        ====================================-->


        <!--===========================================
        =            Popular deals section            =
        ============================================-->

        <section class="popular-deals section bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2>Trending Ads</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas, magnam.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- offer 01 -->
                    <div class="col-sm-12 col-lg-4">
                        <!-- product card -->
                        <div class="product-item bg-light">
                            <div class="card">
                                <div class="thumb-content">
                                    <!-- <div class="price">$200</div> -->
                                    <a href="">
                                        <img class="card-img-top img-fluid" src="{{ URL::asset('dist/images/products/products-1.jpg') }}" alt="Card image cap">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><a href="">11inch Macbook Air</a></h4>
                                    <ul class="list-inline product-meta">
                                        <li class="list-inline-item">
                                            <a href=""><i class="fa fa-folder-open-o"></i>Electronics</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href=""><i class="fa fa-calendar"></i>26th December</a>
                                        </li>
                                    </ul>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, aliquam!</p>
                                    <div class="product-ratings">
                                        <ul class="list-inline">
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <!-- product card -->
                        <div class="product-item bg-light">
                            <div class="card">
                                <div class="thumb-content">
                                    <!-- <div class="price">$200</div> -->
                                    <a href="">
                                        <img class="card-img-top img-fluid" src="{{ URL::asset('dist/images/products/products-2.jpg') }}" alt="Card image cap">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><a href="">Full Study Table Combo</a></h4>
                                    <ul class="list-inline product-meta">
                                        <li class="list-inline-item">
                                            <a href=""><i class="fa fa-folder-open-o"></i>Furnitures</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href=""><i class="fa fa-calendar"></i>26th December</a>
                                        </li>
                                    </ul>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, aliquam!</p>
                                    <div class="product-ratings">
                                        <ul class="list-inline">
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <!-- product card -->
                        <div class="product-item bg-light">
                            <div class="card">
                                <div class="thumb-content">
                                    <!-- <div class="price">$200</div> -->
                                    <a href="">
                                        <img class="card-img-top img-fluid" src="{{ URL::asset('dist/images/products/products-3.jpg') }}" alt="Card image cap">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><a href="">11inch Macbook Air</a></h4>
                                    <ul class="list-inline product-meta">
                                        <li class="list-inline-item">
                                            <a href=""><i class="fa fa-folder-open-o"></i>Electronics</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href=""><i class="fa fa-calendar"></i>26th December</a>
                                        </li>
                                    </ul>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo, aliquam!</p>
                                    <div class="product-ratings">
                                        <ul class="list-inline">
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item selected"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--==========================================
        =            All Category Section            =
        ===========================================-->

        <section class=" section">
            <!-- Container Start -->
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- Section title -->
                        <div class="section-title">
                            <h2>All Categories</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis, provident!</p>
                        </div>
                        <div class="row">
                            <!-- Category list -->
                            <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                                <div class="category-block">
                                    <div class="header">
                                        <i class="fa fa-laptop icon-bg-1"></i>
                                        <h4>Electronics</h4>
                                    </div>
                                    <ul class="category-list" >
                                        <li><a href="category.html">Laptops <span>93</span></a></li>
                                        <li><a href="category.html">Iphone <span>233</span></a></li>
                                        <li><a href="category.html">Microsoft  <span>183</span></a></li>
                                        <li><a href="category.html">Monitors <span>343</span></a></li>
                                    </ul>
                                </div>
                            </div> <!-- /Category List -->
                            <!-- Category list -->
                            <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                                <div class="category-block">
                                    <div class="header">
                                        <i class="fa fa-apple icon-bg-2"></i>
                                        <h4>Restaurants</h4>
                                    </div>
                                    <ul class="category-list" >
                                        <li><a href="category.html">Cafe <span>393</span></a></li>
                                        <li><a href="category.html">Fast food <span>23</span></a></li>
                                        <li><a href="category.html">Restaurants  <span>13</span></a></li>
                                        <li><a href="category.html">Food Track<span>43</span></a></li>
                                    </ul>
                                </div>
                            </div> <!-- /Category List -->
                            <!-- Category list -->
                            <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                                <div class="category-block">
                                    <div class="header">
                                        <i class="fa fa-home icon-bg-3"></i>
                                        <h4>Real Estate</h4>
                                    </div>
                                    <ul class="category-list" >
                                        <li><a href="category.html">Farms <span>93</span></a></li>
                                        <li><a href="category.html">Gym <span>23</span></a></li>
                                        <li><a href="category.html">Hospitals  <span>83</span></a></li>
                                        <li><a href="category.html">Parolurs <span>33</span></a></li>
                                    </ul>
                                </div>
                            </div> <!-- /Category List -->
                            <!-- Category list -->
                            <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                                <div class="category-block">
                                    <div class="header">
                                        <i class="fa fa-shopping-basket icon-bg-4"></i>
                                        <h4>Shoppings</h4>
                                    </div>
                                    <ul class="category-list" >
                                        <li><a href="category.html">Mens Wears <span>53</span></a></li>
                                        <li><a href="category.html">Accessories <span>212</span></a></li>
                                        <li><a href="category.html">Kids Wears <span>133</span></a></li>
                                        <li><a href="category.html">It & Software <span>143</span></a></li>
                                    </ul>
                                </div>
                            </div> <!-- /Category List -->
                            <!-- Category list -->
                            <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                                <div class="category-block">
                                    <div class="header">
                                        <i class="fa fa-briefcase icon-bg-5"></i>
                                        <h4>Jobs</h4>
                                    </div>
                                    <ul class="category-list" >
                                        <li><a href="category.html">It Jobs <span>93</span></a></li>
                                        <li><a href="category.html">Cleaning & Washing <span>233</span></a></li>
                                        <li><a href="category.html">Management  <span>183</span></a></li>
                                        <li><a href="category.html">Voluntary Works <span>343</span></a></li>
                                    </ul>
                                </div>
                            </div> <!-- /Category List -->
                            <!-- Category list -->
                            <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                                <div class="category-block">
                                    <div class="header">
                                        <i class="fa fa-car icon-bg-6"></i>
                                        <h4>Vehicles</h4>
                                    </div>
                                    <ul class="category-list" >
                                        <li><a href="category.html">Bus <span>193</span></a></li>
                                        <li><a href="category.html">Cars <span>23</span></a></li>
                                        <li><a href="category.html">Motobike  <span>33</span></a></li>
                                        <li><a href="category.html">Rent a car <span>73</span></a></li>
                                    </ul>
                                </div>
                            </div> <!-- /Category List -->
                            <!-- Category list -->
                            <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                                <div class="category-block">
                                    <div class="header">
                                        <i class="fa fa-paw icon-bg-7"></i>
                                        <h4>Pets</h4>
                                    </div>
                                    <ul class="category-list" >
                                        <li><a href="category.html">Cats <span>65</span></a></li>
                                        <li><a href="category.html">Dogs <span>23</span></a></li>
                                        <li><a href="category.html">Birds  <span>113</span></a></li>
                                        <li><a href="category.html">Others <span>43</span></a></li>
                                    </ul>
                                </div>
                            </div> <!-- /Category List -->
                            <!-- Category list -->
                            <div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
                                <div class="category-block">
                                    <div class="header">
                                        <i class="fa fa-laptop icon-bg-8"></i>
                                        <h4>Services</h4>
                                    </div>
                                    <ul class="category-list" >
                                        <li><a href="category.html">Cleaning <span>93</span></a></li>
                                        <li><a href="category.html">Car Washing <span>233</span></a></li>
                                        <li><a href="category.html">Clothing  <span>183</span></a></li>
                                        <li><a href="category.html">Business <span>343</span></a></li>
                                    </ul>
                                </div>
                            </div> <!-- /Category List -->


                        </div>
                    </div>
                </div>
            </div>
            <!-- Container End -->
        </section>
        <!--============================
        =            Footer            =
        =============================-->

        <footer class="footer section section-sm">
            <!-- Container Start -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-7 offset-md-1 offset-lg-0">
                        <!-- About -->
                        <div class="block about">
                            <!-- footer logo -->
                            <img src="{{ URL::asset('dist/images/logo-footer.png') }}" alt="">
                            <!-- description -->
                            <p class="alt-color">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                    <!-- Link list -->
                    <div class="col-lg-2 offset-lg-1 col-md-3">
                        <div class="block">
                            <h4>Site Pages</h4>
                            <ul>
                                <li><a href="#">Boston</a></li>
                                <li><a href="#">How It works</a></li>
                                <li><a href="#">Deals & Coupons</a></li>
                                <li><a href="#">Articls & Tips</a></li>
                                <li><a href="#">Terms of Services</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Link list -->
                    <div class="col-lg-2 col-md-3 offset-md-1 offset-lg-0">
                        <div class="block">
                            <h4>Admin Pages</h4>
                            <ul>
                                <li><a href="#">Boston</a></li>
                                <li><a href="#">How It works</a></li>
                                <li><a href="#">Deals & Coupons</a></li>
                                <li><a href="#">Articls & Tips</a></li>
                                <li><a href="#">Terms of Services</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Promotion -->
                    <div class="col-lg-4 col-md-7">
                        <!-- App promotion -->
                        <div class="block-2 app-promotion">
                            <a href="">
                                <!-- Icon -->
                                <img src="{{ URL::asset('dist/images/footer/phone-icon.png') }}" alt="mobile-icon">
                            </a>
                            <p>Get the Dealsy Mobile App and Save more</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container End -->
        </footer>
        <!-- Footer Bottom -->
        <footer class="footer-bottom">
            <!-- Container Start -->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <!-- Copyright -->
                        <div class="copyright">
                            <p>Copyright © 2016. All Rights Reserved</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-12">
                        <!-- Social Icons -->
                        <ul class="social-media-icons text-right">
                            <li><a class="fa fa-facebook" href=""></a></li>
                            <li><a class="fa fa-twitter" href=""></a></li>
                            <li><a class="fa fa-pinterest-p" href=""></a></li>
                            <li><a class="fa fa-vimeo" href=""></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Container End -->
            <!-- To Top -->
            <div class="top-to">
                <a id="top" class="" href=""><i class="fa fa-angle-up"></i></a>
            </div>
        </footer>

        <!-- JAVASCRIPTS -->
        <script src="{{ URL::asset('dist/plugins/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('dist/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ URL::asset('dist/plugins/tether/js/tether.min.js') }}"></script>
        <script src="{{ URL::asset('dist/plugins/raty/jquery.raty-fa.js') }}"></script>
        <script src="{{ URL::asset('dist/plugins/bootstrap/dist/js/popper.min.js') }}"></script>
        <script src="{{ URL::asset('dist/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ URL::asset('dist/plugins/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js') }}"></script>
        <script src="{{ URL::asset('dist/plugins/slick-carousel/slick/slick.min.js') }}"></script>
        <script src="{{ URL::asset('dist/plugins/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
        <script src="{{ URL::asset('dist/plugins/fancybox/jquery.fancybox.pack.js') }}"></script>
        <script src="{{ URL::asset('dist/plugins/smoothscroll/SmoothScroll.min.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
        <script src="{{ URL::asset('dist/js/scripts.js') }}"></script>
    </body>
</html>