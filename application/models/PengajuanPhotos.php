<?php defined('BASEPATH') or exit('No direct script access allowed');

class PengajuanPhotos extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'pengajuanphoto';
    $this->file_location = 'foto-bencana';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => '', 'sTitle' => ''),

    );
    $this->form = array(
      array(
        'name' => 'localFileName',
        'width' => 2,
        'label' => '',
        'type' => 'hidden',
        'value' => ''
      ),
      array(
        'name' => 'gambar',
        'type' => 'file',
        'width' => 6,
        'label' => 'Pilih Foto',
      )
    );
    $this->childs = array();
  }

  function save($record)
  {
    $index = array_search($record['localFileName'], $_FILES['PengajuanPhoto_gambar']['name']);
    unset($record['localFileName']);
    foreach ($record as $field => &$value) {
      if (is_array($value)) $value = implode(',', $value);
      else if (strpos($value, '[comma-replacement]') > -1) $value = str_replace('[comma-replacement]', ',', $value);
    }
    if (strlen($_FILES['PengajuanPhoto_gambar']['name'][$index]) > 0) {
      $oldfile = null;
      if (isset($record['uuid'])) {
        $bukti = self::findOne($record['uuid']);
        $oldfile = $bukti['gambar'];
      }
      $record['gambar'] = $this->fileupload($this->file_location, $_FILES['PengajuanPhoto_gambar'], $oldfile, $index);
    }
    return isset($record['uuid']) ? $this->update($record) : $this->create($record);
  }

  function delete($uuid)
  {
    foreach ($this->childs as $child) {
      $childmodel = $child['model'];
      $this->load->model($childmodel);
      foreach ($this->$childmodel->find(array($this->table => $uuid)) as $childrecord)
        $this->$childmodel->delete($childrecord->uuid);
    }
    $bukti = self::findOne($uuid);
    $this->fileupload('', null, $bukti['gambar']);
    return $this->db->where('uuid', $uuid)->delete($this->table);
  }

  function fileupload($location, $newfile = null, $oldfile = null, $index = 0)
  {
    $new_file_location = '';
    $unique = time();
    if (!is_null($newfile)) {
      $extension = pathinfo($newfile['name'][$index], PATHINFO_EXTENSION);
      $filename_without_ext = str_replace(".{$extension}", '', $newfile['name'][$index]);
      $extension = strtolower($extension);
      $new_file_location = "{$location}/{$filename_without_ext}_{$unique}.{$extension}";
      move_uploaded_file($newfile['tmp_name'][$index], $new_file_location);
    }
    if (!is_null($oldfile) && file_exists($oldfile)) unlink($oldfile);
    return $new_file_location;
  }
}
