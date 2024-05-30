<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title')
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    {{-- js data table --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://kit.fontawesome.com/ad2db55012.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .fixed-sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1000;
            overflow-y: auto;
            /* background-color: #fff; */
            /* Add any other styling for the sidebar */
        }
    </style>



</head>

<body>
    @php
        use App\Models\Cart;
        use Illuminate\Support\Facades\Auth;
        $user_id = Auth::id();

        $cart = Cart::whereJsonContains('cart_items->user_id', $user_id)->first();

        if ($cart) {
            $cart_items = $cart->cart_items;
            $product_in_cart_count = count($cart_items['products']);
        }

    @endphp
    <div class="container header-for-mobile mt-3">
        <div class="logo">
            <h2 class="text-center">LOGO</h2>
        </div>
        <div class="menu-for-small-screens">
            <div class="dropdown" style="position: relative;">
                <div id="dropdownMenuButton2" data-toggle="dropdown" class="burger-menu" aria-haspopup="true"
                    aria-expanded="false" onclick="toggleSubMenu2()">
                    <div class="line"></div>
                </div>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" id="submenu2"
                    style="position: absolute; right: 0;">
                    <a href="{{ route('dashboard') }}" class="dropdown-item"> <i class="fa-solid fa-gauge"></i>
                        Dashboard</a>

                    <a href="" class="dropdown-item"> <i class="fa-solid fa-gauge"></i>
                        Setting</a>


                    <form id="logout-form" action="{{ route('authentication.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row" style="width: 100%; margin:0%; padding:0%;">
            <div class="col-md-2 vertical-menu2 p-0 fixed-sidebar">
                <div class="logo">
                    <h2 class="text-center">LOGO</h2>
                    <div class="vertical-menu mt-4" id="verticalMenu">
                        <ul>
                            <li>
                                <a href="{{ route('dashboard') }}"
                                    class="dropdown-item {{ request()->routeIs('dashboard.index') ? 'dashboard-nav-active' : '' }}">
                                    <i class="fa-solid fa-gauge"></i> Dashboard</a>
                            </li>

                            <li>
                                <a href="{{ route('product_category.index') }}"
                                    class="dropdown-item {{ request()->routeIs('product_category.index') ? 'dashboard-nav-active' : '' }}">
                                    <i class="fa-solid fa-clipboard"></i>
                                    Product Category</a>
                            </li>

                            <li>
                                <a href="{{ route('products.index') }}"
                                    class="dropdown-item {{ request()->routeIs('products.index') ? 'dashboard-nav-active' : '' }}">
                                    <i class="fa-solid fa-gift"></i>
                                    Products</a>
                            </li>

                            <li>
                                <a href="{{ route('cart') }}"
                                    class="dropdown-item {{ request()->routeIs('cart') ? 'dashboard-nav-active' : '' }}">
                                    <i class="fa-solid fa-cart-arrow-down"></i>
                                    Cart Items <span
                                        style="border-radius: 50%; background-color: red; width: 24px; height: 24px; display: inline-block; text-align: center; line-height: 24px; color: white;">
                                        @php
                                            if (isset($product_in_cart_count)) {
                                                echo $product_in_cart_count;
                                            } else {
                                                echo 0;
                                            }

                                        @endphp
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('transaction.index') }}"
                                    class="dropdown-item {{ request()->routeIs('transaction.index') ? 'dashboard-nav-active' : '' }}">
                                    <i class="fa-solid fa-credit-card"></i>
                                    Transactions</a>
                            </li>



                            <li>
                                <a href="" class="dropdown-item">
                                    <i class="fa-solid fa-gear"></i>
                                    Setting</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-10 content2">
                <div class="top-bar d-flex justify-content-between align-items-center fixed-header">
                    <div class="">
                        <input type="text" placeholder="Search" class="dashboard-search">
                    </div>
                    <div class="dropdown" style="position: relative;">
                        <img src="{{ asset('image/user-avatar.png') }}" alt="" width="100%;" class="profile"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            onclick="toggleSubMenu()">
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="submenu"
                            style="position: absolute; right: 0;">
                            <a class="dropdown-item" href="">Manage profile</a>
                            <a class="dropdown-item" href="{{ route('authentication.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('authentication.logout') }}" method="POST"
                                class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <div class="wrapper">
                    {{-- <p style="border: 2px solid black;" class="text-center">CART 0</p> --}}
                    <!-- content -->
                    @yield('content')
                    @include('partial.footer')
                    @include('sweetalert::alert')

                </div>

            </div>
        </div>
    </div>

    <script>
        function toggleSubMenu() {
            var submenu = document.getElementById('submenu');
            submenu.classList.toggle('show');
        }

        function toggleSubMenu2() {
            var submenu = document.getElementById('submenu2');
            submenu.classList.toggle('show');
        }
    </script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        new DataTable('#example');
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <script>
        // Dynamically adjust the height of the vertical menu based on the content on the other side
        window.addEventListener('DOMContentLoaded', function() {
            const verticalMenu = document.getElementById('verticalMenu');
            const wrapper = document.querySelector('.wrapper');

            // Set minimum height to 100vh if wrapper content is less than full screen height
            if (wrapper.scrollHeight < window.innerHeight) {
                verticalMenu.style.minHeight = "100vh";
            } else {
                // Adjust height based on content height
                verticalMenu.style.minHeight = wrapper.scrollHeight + 100 + "px";
            }
        });
    </script>


</body>

</html>
