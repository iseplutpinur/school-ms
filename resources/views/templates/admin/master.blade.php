<?php
$page_attr = (object) [
    'title' => isset($page_attr['title']) ? $page_attr['title'] : '',
    'description' => isset($page_attr['description']) ? $page_attr['description'] : '',
    'keywords' => isset($page_attr['keywords']) ? $page_attr['keywords'] : '',
    'author' => isset($page_attr['author']) ? $page_attr['author'] : '',
    'navigation' => isset($page_attr['navigation']) ? $page_attr['navigation'] : false,
    'breadcrumbs' => isset($page_attr['breadcrumbs']) ? (is_array($page_attr['breadcrumbs']) ? $page_attr['breadcrumbs'] : false) : false,
];
$page_attr_title = ($page_attr->title == '' ? '' : $page_attr->title . ' | ') . (env('APP_NAME') ?? '');
?>

<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="{{ $page_attr->description }}">
    <meta name="author" content="{{ $page_attr->author }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="keywords" content="{{ $page_attr->keywords }}">

    <!-- TITLE -->
    <title>{{ $page_attr_title }}</title>

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ asset('assets/templates/admin/main/assets/images/brand/favicon.ico') }}" />

    <!-- BOOTSTRAP CSS -->
    <link id="style" href="{{ asset('assets/templates/admin/main/assets/plugins/bootstrap/css/bootstrap.min.css') }}"
        rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="{{ asset('assets/templates/admin/main/assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/templates/admin/main/assets/css/dark-style.css') }}" rel="stylesheet" />

    <link href="{{ asset('assets/templates/admin/main/assets/css/skin-modes.css') }}" rel="stylesheet" />

    <!--- FONT-ICONS CSS -->
    <link href="{{ asset('assets/templates/admin/main/assets/css/icons.css') }}" rel="stylesheet" />

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all"
        href="{{ asset('assets/templates/admin/main/assets/colors/color1.css') }}" />

    <!-- CSS PLUGINS -->
    @yield('stylesheet')

    <style>
        .modal-content {
            border-radius: 16px;
        }

    </style>
</head>

<body class="app sidebar-mini ltr light-mode">

    <!-- GLOBAL-LOADER -->
    <div id="global-loader">
        <img src="{{ asset('assets/templates/admin/main/assets/images/loader.svg') }}" class="loader-img"
            alt="Loader">
    </div>
    <!-- /GLOBAL-LOADER -->

    <!-- PAGE -->
    <div class="page">
        <div class="page-main">

            @include('templates.admin.body.header')

            @include('templates.admin.body.sidebar', [
                'page_attr_navigation' => $page_attr->navigation,
            ])

            <!--app-content open-->
            <div class="main-content app-content mt-0">
                <div class="side-app">
                    <!-- CONTAINER -->
                    <div class="main-container container-fluid">
                        @if ($page_attr->breadcrumbs)
                            <!-- PAGE-HEADER -->
                            <div class="page-header">
                                <h1 class="page-title">{{ $page_attr->title }}</h1>
                                <div>
                                    <ol class="breadcrumb">
                                        @foreach ($page_attr->breadcrumbs as $breadcrumb)
                                            <li class="breadcrumb-item">
                                                @if (isset($breadcrumb['url']))
                                                    <a href="{{ $breadcrumb['url'] }}"
                                                        title="Page To {{ $breadcrumb['name'] }}">
                                                        {{ $breadcrumb['name'] }}
                                                    </a>
                                                @else
                                                    {{ $breadcrumb['name'] }}
                                                @endif
                                            </li>
                                        @endforeach
                                        <li class="breadcrumb-item active" aria-current="{{ $page_attr->title }}">
                                            {{ $page_attr->title }}</li>
                                    </ol>
                                </div>
                            </div>
                            <!-- PAGE-HEADER END -->
                        @endif
                        @yield('content')
                    </div>
                    <!-- CONTAINER END -->
                </div>
            </div>
            <!--app-content close-->

        </div>

        <div class="position-fixed end-0 p-3" style="top: 85px">
            <div class="toast align-items-center" role="alert" id="toast" aria-live="assertive" aria-atomic="true"
                data-bs-delay="5000">
                <div class="d-flex">
                    <div class="toast-body" id="toast-body">
                        Hello, world! This is a toast message.
                    </div>

                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"
                        style="position: absolute;padding: 0.4rem;">x</button>
                </div>
                <div class="progress progress-xs mb-0">
                    <div class="progress-bar bg-blue" style="width: 0%;" id="toast-progresbar"></div>
                </div>
            </div>
        </div>

        @include('templates.admin.body.footer')

    </div>

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

    <!-- JQUERY JS -->
    <script src="{{ asset('assets/templates/admin/main/assets/js/jquery.min.js') }}"></script>

    <!-- BOOTSTRAP JS -->
    <script src="{{ asset('assets/templates/admin/main/assets/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/templates/admin/main/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- SPARKLINE JS-->
    <script src="{{ asset('assets/templates/admin/main/assets/js/jquery.sparkline.min.js') }}"></script>

    <!-- Sticky js -->
    <script src="{{ asset('assets/templates/admin/main/assets/js/sticky.js') }}"></script>

    <!-- CHART-CIRCLE JS-->
    <script src="{{ asset('assets/templates/admin/main/assets/js/circle-progress.min.js') }}"></script>

    <!-- SIDEBAR JS -->
    <script src="{{ asset('assets/templates/admin/main/assets/plugins/sidebar/sidebar.js') }}"></script>

    <!-- SIDE-MENU JS-->
    <script src="{{ asset('assets/templates/admin/main/assets/plugins/sidemenu/sidemenu.js') }}"></script>

    <!-- Color Theme js -->
    <script src="{{ asset('assets/templates/admin/main/assets/js/themeColors.js') }}"></script>

    <!-- CUSTOM JS -->
    <script src="{{ asset('assets/templates/admin/main/assets/js/custom.js') }}"></script>

    <script>
        function setBtnLoading(element, text, status = true) {
            const el = $(element);
            if (status) {
                el.attr("disabled", "");
                el.html(
                    `<span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true">
                                        </span> <span>${text}</span>`
                );
            } else {
                el.removeAttr("disabled");
                el.html(text);
            }
        }

        function setToast(
            message = 'Hello, world! This is a toast message.',
            classAttr = ['text-white', 'bg-light']
        ) {
            var myToastEl = document.getElementById('toast');
            const toastJq = $(myToastEl);
            classAttr.forEach(element => {
                toastJq.addClass(element);
            });
            $("#toast-body").html(message);

            const delay = toastJq.attr('data-bs-delay');

            myToastEl.addEventListener('hidden.bs.toast', function() {
                toastJq.attr("class", "toast fade hide");
            });
            let counter = 0;
            const iterator = delay / 50;
            const progressbar = setInterval(() => {
                counter += iterator;
                const percent = Math.floor((50 / (delay * 0.50)) * counter);
                const progres_bar = $('#toast-progresbar');
                progres_bar.attr('style', `width: ${percent}%`);

                if (counter >= delay) {
                    clearInterval(progressbar);
                }
            }, iterator);

            $('.toast').toast('show');
        }
    </script>

    @yield('javascript')
</body>

</html>
