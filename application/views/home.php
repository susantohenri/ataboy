<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>PrototypeApp</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url('assets/css/all.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/css/adminlte.min.css') ?>">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style type="text/css">
        a.btn:not([href]):not([tabindex]) {
            color: white
        }

        .form-child .form-group.row>div {
            margin: 5px 0
        }

        .nav-link {
            cursor: pointer;
        }
    </style>
    <link rel="stylesheet" href="<?= base_url('assets/css/leaflet.css') ?>" />
    <script src="<?= base_url('assets/js/leaflet.js') ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/select2.min.css') ?>">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <div class="container">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-md navbar-light" style="background-color: #fff;">
                <a class="navbar-brand" href="<?= base_url() ?>">
                    <h2><span class="brand-text font-weight-light"><b>ATA</b>boy</span></h2>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="navbar-nav mr-auto"></div>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="modal" data-target="#loginModal">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="modal" data-target="#donaturModal">Registrasi Donatur</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="modal" data-target="#kelurahanModal">Registrasi Kelurahan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="modal" data-target="#forgotModal">Reset Password</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- /.navbar -->
        </div>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            &nbsp;

            <!-- Main content -->
            <div class="content">
                <div class="container">
                    <div class="row">

                        <div class="col-sm-12">
                            <div class="card card-outline">
                                <div class="card-body">

                                    <div id="mapid" style="min-width:200px; height:450px; width: 100%; cursor: pointer"></div>

                                </div>
                            </div><!-- /.card -->
                        </div>

                    </div>
                    <!-- /.row -->
                    <div class="row">

                        <?php foreach ($blogs as $blog) : ?>
                            <div class="col-sm-12 col-md-3" data-toggle="modal" data-target="#blogModal" style="cursor: pointer" onclick="$('#judul').html('<?= $blog->judul ?>');$('#isi').html('<?= htmlentities($blog->isi) ?>');$('#gambar').attr('src', '<?= base_url($blog->gambar) ?>')">
                                <div class="card card-outline">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-4 col-md-12">
                                                <img src="<?= base_url($blog->gambar) ?>" style="width: 100%;">
                                            </div>
                                            <div class="col-8 col-md-12">
                                                <b><?= $blog->judul ?></b>
                                            </div>
                                        </div>

                                    </div>
                                </div><!-- /.card -->
                            </div>
                        <?php endforeach ?>

                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                henry.dinus@gmail.com 081901088918
            </div>
            <!-- Default to the left -->
            <small><strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.</small>
        </footer>
    </div>
    <!-- ./wrapper -->

    <?php foreach (array('blog', 'error-message', 'forgot-password', 'login', 'registrasi-donatur', 'registrasi-kelurahan') as $home_element) include(APPPATH . "views/homepage/{$home_element}.php") ?>

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <!-- <script src="../../dist/js/adminlte.min.js"></script> -->
    <script type="text/javascript" src="<?= base_url('assets/js/select2.full.min.js') ?>"></script>
    <script>
        $('[name="desa"]').select2()
        $('.show-password').each(function() {
            $(this).click(function() {
                let input = $(this).parent().parent().find('[name="password"]')
                let icon = $(this).find('i')
                if (input.is('[type="password"]')) {
                    input.attr('type', 'text')
                    icon.attr('class', 'fa fa-eye-slash')
                } else {
                    input.attr('type', 'password')
                    icon.attr('class', 'fa fa-eye')
                }
            })
        })

        const token = 'pk.eyJ1IjoibGllbWdpb2t0aWFuIiwiYSI6ImNrbWJmcjJuYzIxNXcyd3FyajloZ3IxencifQ.DX3ZeWJ7I7nGUhTupCABXQ'
        const boyolali = [-7.517198764411566, 110.59333666185161]

        var mymap = L.map('mapid').setView(boyolali, 12)
        L.tileLayer(`https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=${token}`, {
            maxZoom: 18,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' + 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        }).addTo(mymap)

        <?php foreach ($mapMarkers as $marker) : ?>
            try {
                let marker = L.marker([<?= $marker['lat'] ?>, <?= $marker['lng'] ?>]).addTo(mymap)
            } catch (e) {

            }
        <?php endforeach ?>
    </script>
</body>

</html>