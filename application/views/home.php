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
    <meta name="google-signin-client_id" content="476916537848-qghfl63a34icmknbf3s5afeibd9g02ts.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <title>ATAboy</title>

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

        .card-body {
            padding: 5px;
        }

        li.paginate_button.active a {
            background-color: #ffc107 !important;
            border-color: #ffc107 !important;
        }
    </style>
    <link rel="stylesheet" href="<?= base_url('assets/css/leaflet.css') ?>" />
    <script src="<?= base_url('assets/js/leaflet.js') ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/select2.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/dataTables.bootstrap4.css') ?>">
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
                <div class="container-" style="padding: 10px">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card card-outline">
                                <div class="card-body">
                                    <a class="weatherwidget-io" href="https://forecast7.com/en/n7d43110d69/boyolali-regency/" data-label_1="KABUPATEN" data-label_2="BOYOLALI" data-theme="original">BOYOLALI</a>
                                    <script>
                                        ! function(d, s, id) {
                                            var js, fjs = d.getElementsByTagName(s)[0];
                                            if (!d.getElementById(id)) {
                                                js = d.createElement(s);
                                                js.id = id;
                                                js.src = 'https://weatherwidget.io/js/widget.min.js';
                                                fjs.parentNode.insertBefore(js, fjs);
                                            }
                                        }(document, 'script', 'weatherwidget-io-js');
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="card card-outline" style="background-color: #00b050; color: white; font-size: small;">
                                <div class="card-header">
                                    <h4 class="text-center">Penyaluran</h4>
                                </div>
                                <div class="card-body">
                                    <table id="tablePenyaluran" class="table table-bordered table-striped datatable table-model">
                                    </table>

                                    <div class="modal" tabindex="-1" role="dialog" id="modalSerahTerima">
                                        <div class="modal-dialog" role="document" style="display: table;">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img id="previewSerahTerima">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card card-outline" style="background-color: #ed7d31; color: white; font-size: small;">
                                <div class="card-header">
                                    <h4 class="text-center">Donatur</h4>
                                </div>
                                <div class="card-body">
                                    <table id="tableDonatur" class="table table-bordered table-striped datatable table-model">
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-sm-8">
                            <div class="card card-outline">
                                <div class="card-body">

                                    <div id="mapid" style="min-width:200px; height:450px; width: 100%; cursor: pointer"></div>

                                </div>
                            </div><!-- /.card -->
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card card-outline">
                                        <div class="card-body">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="card card-outline">
                                        <div class="card-body">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-outline">
                                <div class="card-body">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-outline">
                                <div class="card-body">
                                    <?php foreach ($blogs as $blog) : ?>
                                        <div class="col-sm-12 col-md-3" data-toggle="modal" data-target="#blogModal" style="cursor: pointer" onclick="$('#judul').html('<?= $blog->judul ?>');$('#isi').html('<?= htmlentities($blog->isi) ?>');$('#gambar').attr('src', '<?= base_url($blog->gambar) ?>')">
                                            <div class="row">
                                                <div class="col-4 col-md-12">
                                                    <img src="<?= base_url($blog->gambar) ?>" style="width: 100%;">
                                                </div>
                                                <div class="col-8 col-md-12">
                                                    <b><?= $blog->judul ?></b>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
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

    <?php foreach (array('blog', 'error-message', 'forgot-password', 'login', 'registrasi-donatur', 'registrasi-kelurahan', 'reset-password') as $home_element) include(APPPATH . "views/homepage/{$home_element}.php") ?>

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <!-- <script src="../../dist/js/adminlte.min.js"></script> -->
    <script type="text/javascript" src="<?= base_url('assets/js/select2.full.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/dataTables.bootstrap4.js') ?>"></script>
    <script>
        // PREVENT FORM RESUBMISSION ON REFRESH OR BACK
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
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

        var google_btn_clicked = false

        function onSignIn(googleUser) {
            if (!google_btn_clicked) return false
            var profile = googleUser.getBasicProfile()
            var email = profile.getEmail()
            $.post('Home/LoginWithGoogle', {
                email
            }, function(resp) {
                if ('1' === resp) {
                    window.location = window.location.href.replace('Home', '')
                } else {
                    $('#loginModal').modal('hide')
                    $('#donaturModal').modal('show')
                    $('[name="username"]').val(email)
                }
            })
        }

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

        var iconDIAJUKAN = L.divIcon({
            html: '<i class="fa fa-2x fa-map-marker-alt text-red"></i>',
        })
        var iconDIVERIFIKASI = L.divIcon({
            html: '<i class="fa fa-2x fa-map-marker-alt text-info"></i>',
        })
        var iconDITERIMA = L.divIcon({
            html: '<i class="fa fa-2x fa-map-marker-alt text-success"></i>',
        })

        <?php foreach ($mapMarkers as $marker) : ?>
            try {
                let marker = L
                    .marker(
                        [<?= $marker['lat'] ?>, <?= $marker['lng'] ?>], {
                            icon: icon<?= $marker['status'] ?>
                        }
                    )
                    .addTo(mymap)
                    .bindTooltip(`
                        Jumlah Korban <b><?= $marker['korban'] ?></b>
                        <br>Bencana <b><?= $marker['bencana'] ?></b>
                        <br>Kebutuhan <b><?= $marker['kebutuhan'] ?></b>
                        <br>Status <b><?= $marker['status'] ?></b>
                    `)
            } catch (e) {

            }
        <?php endforeach ?>

        $('#tablePenyaluran').DataTable({
            processing: true,
            serverSide: true,
            columns: [{
                    mData: 'desa',
                    sTitle: 'DESA'
                },
                {
                    mData: 'bencana',
                    sTitle: 'BENCANA'
                },
                {
                    mData: 'korban',
                    sTitle: 'KORBAN'
                },
                {
                    mData: 'bantuan',
                    sTitle: 'BANTUAN'
                },
                {
                    mData: 'button',
                    sTitle: 'PHOTO'
                }
            ],
            ajax: {
                url: 'Home/dtPenyaluran',
                type: 'POST'
            },
            fnRowCallback: function(nRow, aData, iDisplayIndex) {
                $(nRow).find('.btn').click(function() {
                    $('img#previewSerahTerima').attr('src', $(this).attr('data-img'))
                    $('#modalSerahTerima').modal('show')
                })
            }
        })

        $('#tableDonatur').DataTable({
            processing: true,
            serverSide: true,
            columns: [{
                    mData: 'donatur',
                    sTitle: 'DONATUR'
                },
                {
                    mData: 'donasi',
                    sTitle: 'DONASI'
                },
                {
                    mData: 'tanggal',
                    sTitle: 'TANGGAL'
                }
            ],
            ajax: {
                url: 'Home/dtDonatur',
                type: 'POST'
            }
        })
    </script>
</body>

</html>