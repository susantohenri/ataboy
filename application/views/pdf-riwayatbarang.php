<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title_pdf; ?></title>
    <style>
        body {
            font-size: 8pt;
        }
        #table {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td,
        #table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table th {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>

<body>
    <div style="text-align:center">
        <!-- <h3> Laporan PDF Toko Kita</h3> -->
    </div>
    <table id="table">
        <thead>
            <tr>
                <th>NO</th>
                <th>TANGGAL</th>
                <th>BARANG</th>
                <th>JENIS</th>
                <th>JUMLAH</th>
                <th>DONASI / PENGAJUAN</th>
                <th>DONATUR</th>
                <th>KELURAHAN</th>
                <th>BENCANA</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($rows) > 0): ?>
            <?php foreach ($rows as $row) : ?>
                <tr>
                    <?php foreach ($row as $cell) : ?>
                        <td>
                            <?= $cell ?>
                        </td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</body>

</html>