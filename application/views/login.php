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
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light navbar-white">
            <div class="container">
                <a href="<?= base_url() ?>" class="navbar-brand">
                    <!-- <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8"> -->
                    <H2><span class="brand-text font-weight-light"><b>ATA</b>boy</span></H2>
                </a>

                <a class="nav-link" data-toggle="modal" data-target="#exampleModal" style="cursor: pointer">Login</a>
            </div>
        </nav>
        <!-- /.navbar -->

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
                            <div class="col-sm-12 col-md-3">
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

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Alamat Email" name="username">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Kata Sandi" name="password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 offset-8">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <!-- <script src="../../dist/js/adminlte.min.js"></script> -->
    <script>
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

        try {
            let slatlng = localStorage.getItem('marker_lurah_1')
            let olatlng = JSON.parse(slatlng)
            let marker = L.marker([olatlng.lat, olatlng.lng]).addTo(mymap)
        } catch (e) {

        }

        try {
            let slatlng = localStorage.getItem('marker_lurah_2')
            let olatlng = JSON.parse(slatlng)
            let marker = L.marker([olatlng.lat, olatlng.lng]).addTo(mymap)
        } catch (e) {

        }
    </script>
</body>

</html>