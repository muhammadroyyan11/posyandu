<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*| --------------------------------------------------------------------------*/
/*| dev : royyan  */
/*| version : V.0.0.2 */
/*| facebook :  */
/*| fanspage :  */
/*| instagram :  */
/*| youtube :  */
/*| --------------------------------------------------------------------------*/
/*| Generate By M-CRUD Generator 22/02/2024 21:09*/
/*| Please DO NOT modify this information*/

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Balita extends Backend{

private $title = "Balita";


public function __construct()
{
  $config = array(
    'title' => $this->title,
   );
  parent::__construct($config);
  $this->load->model("Balita_model","model");
  $this->load->model("Base_model","base");
}

function index()
{
  $this->is_allowed('balita_list');
  $this->template->set_title($this->title);
  $this->template->view("index");
}

function json()
{
  if ($this->input->is_ajax_request()) {
    if (!is_allowed('balita_list')) {
      show_error("Access Permission", 403,'403::Access Not Permission');
      exit();
    }

    $list = $this->model->get_datatables();
    $data = array();
    $today = new DateTime();
    foreach ($list as $row) {
        $diff = $today->diff(new DateTime($row->tgl_lahir));
        $rows = array();
                $rows[] = $row->id;
                $rows[] = $row->nama;
                $rows[] = $row->tempat_lahir;
                $rows[] = date("d-m-Y",  strtotime($row->tgl_lahir));
                $rows[] = $diff->y . ' Th';
                $rows[] = $row->nama_ayah;
                $rows[] = $row->nama_ibu;
                $rows[] = $row->catatan;
                $rows[] = $row->berat_badan . ' Kg';
                $rows[] = $row->tinggi_badan . ' Cm';
                $rows[] = date("d-m-Y H:i",  strtotime($row->createdAt));
                $rows[] = date("d-m-Y H:i",  strtotime($row->updatedAt));
        
        $rows[] = '
                  <div class="btn-group" role="group" aria-label="Basic example">
                      <a href="'.url("balita/detail/".enc_url($row->id)).'" id="detail" class="btn btn-primary" title="'.cclang("detail").'">
                        <i class="mdi mdi-file"></i>
                      </a>
                      <a href="'.url("balita/update/".enc_url($row->id)).'" id="update" class="btn btn-warning" title="'.cclang("update").'">
                        <i class="ti-pencil"></i>
                      </a>
                      <a href="'.url("balita/delete/".enc_url($row->id)).'" id="delete" class="btn btn-danger" title="'.cclang("delete").'">
                        <i class="ti-trash"></i>
                      </a>
                  </div>
                 ';

        $data[] = $rows;
    }

    $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->model->count_all(),
                    "recordsFiltered" => $this->model->count_filtered(),
                    "data" => $data,
            );
    //output to json format
    return $this->response($output);
  }
}

function filter()
{
  if(!is_allowed('balita_filter'))
  {
    echo "access not permission";
  }else{
    $this->template->view("filter",[],false);
  }
}

function detail($id)
{
  $this->is_allowed('balita_detail');
    if ($row = $this->model->find(dec_url($id))) {
    $this->template->set_title("Detail ".$this->title);
    $data = array(
          "nama" => $row->nama,
          "tempat_lahir" => $row->tempat_lahir,
          "tgl_lahir" => $row->tgl_lahir,
          "nama_ayah" => $row->nama_ayah,
          "nama_ibu" => $row->nama_ibu,
          "catatan" => $row->catatan,
          "berat_badan" => $row->berat_badan,
          "tinggi_badan" => $row->tinggi_badan,
    );
    $this->template->view("view",$data);
  }else{
    $this->error404();
  }
}

function add()
{
  $this->is_allowed('balita_add');
  $this->template->set_title(cclang("add")." ".$this->title);
  $data = array('action' => url("balita/add_action"),
                  'nama' => set_value("nama"),
                  'tempat_lahir' => set_value("tempat_lahir"),
                  'tgl_lahir' => set_value("tgl_lahir"),
                  'nama_ayah' => set_value("nama_ayah"),
                  'nama_ibu' => set_value("nama_ibu"),
                  'catatan' => set_value("catatan"),
                  'berat_badan' => set_value("berat_badan"),
                  'tinggi_badan' => set_value("tinggi_badan"),
                  );
  $this->template->view("add",$data);
}

function add_action()
{
  if($this->input->is_ajax_request()){
    if (!is_allowed('balita_add')) {
      show_error("Access Permission", 403,'403::Access Not Permission');
      exit();
    }

    $json = array('success' => false);
    $this->form_validation->set_rules("nama","* Nama","trim|xss_clean|required");
    $this->form_validation->set_rules("tempat_lahir","* Tempat lahir","trim|xss_clean|required");
    $this->form_validation->set_rules("tgl_lahir","* Tgl lahir","trim|xss_clean|required");
    $this->form_validation->set_rules("nama_ayah","* Nama ayah","trim|xss_clean|required");
    $this->form_validation->set_rules("nama_ibu","* Nama ibu","trim|xss_clean|required");
    $this->form_validation->set_rules("catatan","* Catatan","trim|xss_clean");
    $this->form_validation->set_rules("berat_badan","* Berat badan","trim|xss_clean|required");
    $this->form_validation->set_rules("tinggi_badan","* Tinggi badan","trim|xss_clean|required");
    $this->form_validation->set_error_delimiters('<i class="error text-danger" style="font-size:11px">','</i>');

    if ($this->form_validation->run()) {
      $save_data['nama'] = $this->input->post('nama',true);
      $save_data['tempat_lahir'] = $this->input->post('tempat_lahir',true);
      $save_data['tgl_lahir'] = date("Y-m-d",  strtotime($this->input->post('tgl_lahir', true)));
      $save_data['nama_ayah'] = $this->input->post('nama_ayah',true);
      $save_data['nama_ibu'] = $this->input->post('nama_ibu',true);
      $save_data['catatan'] = $this->input->post('catatan',true);
      $save_data['berat_badan'] = $this->input->post('berat_badan',true);
      $save_data['tinggi_badan'] = $this->input->post('tinggi_badan',true);

      $this->model->insert($save_data);

      set_message("success",cclang("notif_save"));
      $json['redirect'] = url("balita");
      $json['success'] = true;
    }else {
      foreach ($_POST as $key => $value) {
        $json['alert'][$key] = form_error($key);
      }
    }

    $this->response($json);
  }
}

function update($id)
{
  $this->is_allowed('balita_update');
  if ($row = $this->model->find(dec_url($id))) {
    $this->template->set_title(cclang("update")." ".$this->title);
    $data = array('action' => url("balita/update_action/$id"),
                  'nama' => set_value("nama", $row->nama),
                  'tempat_lahir' => set_value("tempat_lahir", $row->tempat_lahir),
                  'tgl_lahir' => $row->tgl_lahir == "" ? "":date("Y-m-d",  strtotime($row->tgl_lahir)),
                  'nama_ayah' => set_value("nama_ayah", $row->nama_ayah),
                  'nama_ibu' => set_value("nama_ibu", $row->nama_ibu),
                  'catatan' => set_value("catatan", $row->catatan),
                  'berat_badan' => set_value("berat_badan", $row->berat_badan),
                  'tinggi_badan' => set_value("tinggi_badan", $row->tinggi_badan),
                  );
    $this->template->view("update",$data);
  }else {
    $this->error404();
  }
}

function update_action($id)
{
  if($this->input->is_ajax_request()){
    if (!is_allowed('balita_update')) {
      show_error("Access Permission", 403,'403::Access Not Permission');
      exit();
    }

    $json = array('success' => false);
    $this->form_validation->set_rules("nama","* Nama","trim|xss_clean|required");
    $this->form_validation->set_rules("tempat_lahir","* Tempat lahir","trim|xss_clean|required");
    $this->form_validation->set_rules("tgl_lahir","* Tgl lahir","trim|xss_clean|required");
    $this->form_validation->set_rules("nama_ayah","* Nama ayah","trim|xss_clean|required");
    $this->form_validation->set_rules("nama_ibu","* Nama ibu","trim|xss_clean|required");
    $this->form_validation->set_rules("catatan","* Catatan","trim|xss_clean");
    $this->form_validation->set_rules("berat_badan","* Berat badan","trim|xss_clean|required");
    $this->form_validation->set_rules("tinggi_badan","* Tinggi badan","trim|xss_clean|required");
    $this->form_validation->set_error_delimiters('<i class="error text-danger" style="font-size:11px">','</i>');

    if ($this->form_validation->run()) {
      $save_data['nama'] = $this->input->post('nama',true);
      $save_data['tempat_lahir'] = $this->input->post('tempat_lahir',true);
      $save_data['tgl_lahir'] = date("Y-m-d",  strtotime($this->input->post('tgl_lahir', true)));
      $save_data['nama_ayah'] = $this->input->post('nama_ayah',true);
      $save_data['nama_ibu'] = $this->input->post('nama_ibu',true);
      $save_data['catatan'] = $this->input->post('catatan',true);
      $save_data['berat_badan'] = $this->input->post('berat_badan',true);
      $save_data['tinggi_badan'] = $this->input->post('tinggi_badan',true);

      $save = $this->model->change(dec_url($id), $save_data);

      set_message("success",cclang("notif_update"));

      $json['redirect'] = url("balita");
      $json['success'] = true;
    }else {
      foreach ($_POST as $key => $value) {
        $json['alert'][$key] = form_error($key);
      }
    }

    $this->response($json);
  }
}

function delete($id)
{
  if ($this->input->is_ajax_request()) {
    if (!is_allowed('balita_delete')) {
      return $this->response([
        'type_msg' => "error",
        'msg' => "do not have permission to access"
      ]);
    }

      $this->model->remove(dec_url($id));
      $json['type_msg'] = "success";
      $json['msg'] = cclang("notif_delete");


    return $this->response($json);
  }
}

public function export()
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $post = $this->input->post(null, true);

    $pecah = explode(' - ', $post['tanggal']);
    $dateMasuk = new DateTime();
    $dateKeluar = new DateTime();
    $mulai = date('Y-m-d', strtotime($pecah[0]));
    $akhir = date('Y-m-d', strtotime(end($pecah)));

    $style_col = [
      'font' => ['bold' => true],
      'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
      ],
      'borders' => [
        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
      ]
    ];

    $style_row = [
      'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
      ],
      'borders' => [
        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
      ]
    ];
    $sheet->setCellValue('A1', "Data Monitor RFQ");
    $sheet->mergeCells('A1:E1');
    $sheet->getStyle('A1')->getFont()->setBold(true);

    // Buat header tabel nya pada baris ke 3
    $sheet->setCellValue('A3', "NO ID");
    $sheet->setCellValue('B3', "Nama");
    $sheet->setCellValue('C3', "Tempat Lahir");
    $sheet->setCellValue('D3', "Tanggal lahir");
    $sheet->setCellValue('E3', "Umur");
    $sheet->setCellValue('F3', "Nama Ayah");
    $sheet->setCellValue('G3', 'Nama Ibu');
    $sheet->setCellValue('H3', 'Catatan');
    $sheet->setCellValue('I3', 'Berat Badan');
    $sheet->setCellValue('J3', 'Tinggi Badan');
    $sheet->setCellValue('K3', 'Kader');

    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
    $sheet->getStyle('A3')->applyFromArray($style_col);
    $sheet->getStyle('B3')->applyFromArray($style_col);
    $sheet->getStyle('C3')->applyFromArray($style_col);
    $sheet->getStyle('D3')->applyFromArray($style_col);
    $sheet->getStyle('E3')->applyFromArray($style_col);
    $sheet->getStyle('F3')->applyFromArray($style_col);
    $sheet->getStyle('G3')->applyFromArray($style_col);
    $sheet->getStyle('H3')->applyFromArray($style_col);
    $sheet->getStyle('I3')->applyFromArray($style_col);
    $sheet->getStyle('J3')->applyFromArray($style_col);
    $sheet->getStyle('K3')->applyFromArray($style_col);

    //GET DATA
    $DataLansia = $this->base->getExport(['mulai' => $mulai, 'akhir' => $akhir])->result();
    $today = new DateTime();
    $no = 1; // Untuk penomoran tabel, di awal set dengan 1
    $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
    foreach ($DataLansia as $data) { // Lakukan looping pada variabel siswa
      $diff = $today->diff(new DateTime($data->tgl_lahir));
      $sheet->setCellValue('A' . $numrow, $data->id);
      $sheet->setCellValue('B' . $numrow, $data->nama);
      $sheet->setCellValue('C' . $numrow, $data->tempat_lahir);
      $sheet->setCellValue('D' . $numrow, $data->tgl_lahir);
      $sheet->setCellValue('E' . $numrow, $diff->y . ' Tahun'); //UMUR
      $sheet->setCellValue('F' . $numrow, $data->nama_ayah);
      $sheet->setCellValue('G' . $numrow, $data->nama_ibu);
      $sheet->setCellValue('H' . $numrow, $data->catatan);
      $sheet->setCellValue('I' . $numrow, $data->berat_badan . ' Kg');
      $sheet->setCellValue('J' . $numrow, $data->tinggi_badan . ' Cm');
      $sheet->setCellValue('K' . $numrow, 'nama kader');

      // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
      $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
      $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
      $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
      $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
      $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
      $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
      $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
      $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
      $sheet->getStyle('I' . $numrow)->applyFromArray($style_row);
      $sheet->getStyle('J' . $numrow)->applyFromArray($style_row);
      $sheet->getStyle('K' . $numrow)->applyFromArray($style_row);

      $no++; // Tambah 1 setiap kali looping
      $numrow++; // Tambah 1 setiap kali looping
    }
    // Set width kolom
    $sheet->getColumnDimension('A')->setWidth(20); // Set width kolom A
    $sheet->getColumnDimension('B')->setWidth(30); // Set width kolom B
    $sheet->getColumnDimension('C')->setWidth(20); // Set width kolom C
    $sheet->getColumnDimension('D')->setWidth(50); // Set width kolom D
    $sheet->getColumnDimension('E')->setWidth(80); // Set width kolom D
    $sheet->getColumnDimension('F')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('G')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('H')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('I')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('J')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('K')->setWidth(50); // Set width kolom E

    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $sheet->getDefaultRowDimension()->setRowHeight(-1);
    // Set orientasi kertas jadi LANDSCAPE
    $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    // Set judul file excel nya
    $sheet->setTitle("Data Monitor RFQ");
    // Proses file excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="Data Balita ' . $mulai . ' - ' . $akhir . '.xlsx"'); // Set nama file excel nya
    header('Cache-Control: max-age=0');
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
  }


}

/* End of file Balita.php */
/* Location: ./application/modules/balita/controllers/backend/Balita.php */
