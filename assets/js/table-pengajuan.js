window.onload = function () {

  var queryString = window.location.search
  var urlParams = new URLSearchParams(queryString)
  var status = urlParams.get('status')
  if (null !== status) {
    $('[name="status"]').val(status)
  }

  $('[name="propinsi"], [name="kabupaten"], [name="status"]').select2()

  $('[name="kecamatan"]').select2({
    ajax: {
      url: 'Pengajuan/select2/Kecamatans/nama',
      type: 'POST', dataType: 'json'
    }
  }).change(function () {
    let kelurahan = $('[name="kelurahan"]')
    kelurahan.val('')
    kelurahan.trigger('change.select2')
  })

  $('[name="kelurahan"]').select2({
    ajax: {
      url: 'Pengajuan/select2/Desas/nama',
      type: 'POST', dataType: 'json',
      data: function (params) {
        var query = {
          search: params.term,
          kecamatan: $('[name="kecamatan"]').val()
        }
        return query;
      },
    }
  })

  $('.btn-submit-filter').click(function () {
    history.pushState({}, null, window.location.href.split('?')[0] + '?' + $('.form-filter-pengajuan').serialize())
    table.ajax.url(current_controller_url + '/dt' + window.location.search).load()
  })

  for (var th in thead) {
    $('.table-model tfoot tr').append('<th></th>')
  }

  var footer = []
  var table = $('.table-model').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: current_controller_url + '/dt' + window.location.search, type: 'POST', dataSrc: function (data) {
        footer = data.footer
        return data.data
      }
    },
    columns: thead,
    createdRow: function (row, data, dataIndex) {
      if (data.prosentase && parseInt(data.prosentase.replace('%', '').split(',').join('')) > 100) $(row).css('background-color', '#ffcccc')
    },
    fnRowCallback: function (nRow, aData, iDisplayIndex) {
      $(nRow).css('cursor', 'pointer').click(function () {
        if (!allow_read) return false
        else window.location.href = current_controller_url + '/read/' + aData.uuid
      })
    },
    drawCallback: function (settings) {
      var api = this.api()
      for (var f in footer) $(api.column(f).footer()).html(footer[f])
    }
  })
}