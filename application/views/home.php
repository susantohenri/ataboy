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

        div.contains-dt {
            color: white;
            font-size: small;
            padding: 5px
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

        <div class="content-wrapper">
            &nbsp;

            <div class="content">
                <div class="container-" style="padding: 10px">

                    <div class="row">
                        <div class="col-sm-12 col-md-4" style="background-color: #1f567c">
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
                        <div class="col-sm-12 col-md-4 contains-dt" style="background-color: #ed7d31; max-width: 33%; margin: 0 2px">
                            <h4 class="text-center">Verifikasi</h4>
                            <table id="tableDiverifikasi" class="table table-bordered table-striped datatable table-model"></table>
                        </div>
                        <div class="col-sm-12 col-md-4 contains-dt" style="background-color: #c10100;">
                            <h4 class="text-center">Pengajuan</h4>
                            <table id="tableDiajukan" class="table table-bordered table-striped datatable table-model"></table>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px; margin-bottom: 5px">
                        <div class="col-sm-12 col-md-8" style="background-color: white;">
                            <div id="mapid" style="min-width:200px; height:450px; width: 100%; cursor: pointer"></div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="row">
                                <div class="col-sm-12 contains-dt" style="background-color: white; color: black; height: 225px">
                                    <table id="tableDonatur" class="table table-bordered table-striped datatable table-model"></table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12" style="background-color: white; height: 225px">
                                    <style>
                                        .mySlides {
                                            display: none;
                                        }

                                        .btn-slider {
                                            color: #fff !important;
                                            background-color: #000 !important;
                                            border: none;
                                            display: inline-block;
                                            padding: 8px 16px;
                                            vertical-align: middle;
                                            overflow: hidden;
                                            text-decoration: none;
                                            color: inherit;
                                            background-color: inherit;
                                            text-align: center;
                                            cursor: pointer;
                                            white-space: nowrap;
                                        }

                                        .btn-slider-left {
                                            position: absolute;
                                            top: 50%;
                                            left: 0%;
                                            transform: translate(0%, -50%);
                                        }

                                        .btn-slider-right {
                                            position: absolute;
                                            top: 50%;
                                            right: 0%;
                                            transform: translate(0%, -50%);
                                        }
                                    </style>
                                    <?php foreach ($slideshow as $img) : ?>
                                        <img class="mySlides" src="<?= $img ?>" style="width:100%; max-height: 220px">
                                    <?php endforeach ?>

                                    <button class="btn-slider btn-slider-left" onclick="plusDivs(-1)">&#10094;</button>
                                    <button class="btn-slider btn-slider-right" onclick="plusDivs(1)">&#10095;</button>
                                    <script>
                                        var myIndex = 0;
                                        carousel();

                                        function carousel() {
                                            var i;
                                            var x = document.getElementsByClassName("mySlides");
                                            for (i = 0; i < x.length; i++) {
                                                x[i].style.display = "none";
                                            }
                                            myIndex++;
                                            if (myIndex > x.length) {
                                                myIndex = 1
                                            }
                                            x[myIndex - 1].style.display = "block";
                                            setTimeout(carousel, 2500); // Change image every 2 seconds
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 contains-dt" style="background-color: black; width: 32%">
                            <h4 class="text-center">Bantuan Tersalurkan</h4>
                            <table id="tablePenyaluran" class="table table-bordered table-striped datatable table-model"></table>

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
                        <div class="col-sm-12 col-md-6" style="background-color: white; border-radius: 25px">
                            <h4 class="text-center">Tahukah Anda?</h4>
                            <div class="row">
                                <?php foreach ($blogs as $blog) : ?>
                                    <div class="col-sm-12 col-md-4" data-toggle="modal" data-target="#blogModal" style="cursor: pointer" onclick="$('#judul').html('<?= $blog->judul ?>');$('#isi').html('<?= htmlentities($blog->isi) ?>');$('#gambar').attr('src', '<?= base_url($blog->gambar) ?>')">
                                        <img src="<?= base_url($blog->gambar) ?>" style="width: 100%;">
                                        <b><?= $blog->judul ?></b>
                                    </div>
                                <?php endforeach ?>
                            </div>
                            <div class="modal fade" id="blogModal" tabindex="-1" role="dialog" aria-labelledby="blogModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <center>
                                                        <h2 id="judul"></h2>
                                                    </center>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="card card-outline">
                                                        <div class="card-body">
                                                            <img id="gambar" src="" style="width: 100%;">
                                                        </div>
                                                    </div><!-- /.card -->
                                                </div>
                                                <div class="col-sm-12" id="isi">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                henry.dinus@gmail.com 081901088918
            </div>
            <!-- Default to the left -->
            <small><strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.</small>
        </footer>
    </div>

    <?php foreach (array('error-message', 'forgot-password', 'login', 'registrasi-donatur', 'registrasi-kelurahan', 'reset-password') as $home_element) include(APPPATH . "views/homepage/{$home_element}.php") ?>

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

        $('#tableDiverifikasi').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 1,
            lengthMenu: [
                [1, 5, -1],
                [1, 5, 'Semua']
            ],
            columns: [{
                    mData: 'desa',
                    sTitle: 'DESA'
                },
                {
                    mData: 'bencana',
                    sTitle: 'BENCANA'
                },
                {
                    mData: 'kebutuhan',
                    sTitle: 'KEBUTUHAN'
                }
            ],
            ajax: {
                url: '<?= site_url('Home/dtDiverifikasi') ?>',
                type: 'POST'
            }
        })

        $('#tableDiajukan').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 1,
            lengthMenu: [
                [1, 5, -1],
                [1, 5, 'Semua']
            ],
            columns: [{
                    mData: 'desa',
                    sTitle: 'DESA'
                },
                {
                    mData: 'bencana',
                    sTitle: 'BENCANA'
                },
                {
                    mData: 'kebutuhan',
                    sTitle: 'KEBUTUHAN'
                }
            ],
            ajax: {
                url: '<?= site_url('Home/dtDiajukan') ?>',
                type: 'POST'
            }
        })

        $('#tableDonatur').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 1,
            lengthMenu: [
                [1, 5, -1],
                [1, 5, 'Semua']
            ],
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
                url: '<?= site_url('Home/dtDonatur') ?>',
                type: 'POST'
            }
        })

        $('#tablePenyaluran').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 1,
            lengthMenu: [
                [1, 5, -1],
                [1, 5, 'Semua']
            ],
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
                url: '<?= site_url('Home/dtPenyaluran') ?>',
                type: 'POST'
            },
            fnRowCallback: function(nRow, aData, iDisplayIndex) {
                $(nRow).find('.btn').click(function() {
                    $('img#previewSerahTerima').attr('src', $(this).attr('data-img'))
                    $('#modalSerahTerima').modal('show')
                })
            }
        })
    </script>
</body>

</html>