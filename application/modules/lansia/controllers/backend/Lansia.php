<?php defined('BASEPATH') or exit('No direct script access allowed');
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

// use PhpOffice\PhpSpreadsheet\Spreadsheet;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Lansia extends Backend
{

  private $title = "Lansia";


  public function __construct()
  {
    $config = array(
      'title' => $this->title,
    );
    parent::__construct($config);
    $this->load->model("Lansia_model", "model");
    $this->load->model("Base_model", "base");
  }

  function index()
  {
    $this->is_allowed('lansia_list');
    $this->template->set_title($this->title);
    $this->template->view("index");
  }

  function json()
  {
    if ($this->input->is_ajax_request()) {
      if (!is_allowed('lansia_list')) {
        show_error("Access Permission", 403, '403::Access Not Permission');
        exit();
      }

      $list = $this->model->get_datatables();
      $data = array();
      foreach ($list as $row) {
        $rows = array();
        $rows[] = $row->id;
        $rows[] = $row->nama;
        $rows[] = $row->tempat_lahir;
        $rows[] = date("d-m-Y",  strtotime($row->tgl_lahir));
        $rows[] = $row->jenis_kelamin;
        $rows[] = $row->pemeriksaan;
        $rows[] = $row->pemberian_vitamin;
        $rows[] = date("d-m-Y H:i",  strtotime($row->createdAt));

        $rows[] = '
                  <div class="btn-group" role="group" aria-label="Basic example">
                      <a href="' . url("lansia/detail/" . enc_url($row->id)) . '" id="detail" class="btn btn-primary" title="' . cclang("detail") . '">
                        <i class="mdi mdi-file"></i>
                      </a>
                      <a href="' . url("lansia/update/" . enc_url($row->id)) . '" id="update" class="btn btn-warning" title="' . cclang("update") . '">
                        <i class="ti-pencil"></i>
                      </a>
                      <a href="' . url("lansia/delete/" . enc_url($row->id)) . '" id="delete" class="btn btn-danger" title="' . cclang("delete") . '">
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
    if (!is_allowed('lansia_filter')) {
      echo "access not permission";
    } else {
      $this->template->view("filter", [], false);
    }
  }

  function detail($id)
  {
    $this->is_allowed('lansia_detail');
    if ($row = $this->model->find(dec_url($id))) {
      $this->template->set_title("Detail " . $this->title);
      $data = array(
        "nama" => $row->nama,
        "tempat_lahir" => $row->tempat_lahir,
        "tgl_lahir" => $row->tgl_lahir,
        "jenis_kelamin" => $row->jenis_kelamin,
        "pemeriksaan" => $row->pemeriksaan,
        "pemberian_vitamin" => $row->pemberian_vitamin,
      );
      $this->template->view("view", $data);
    } else {
      $this->error404();
    }
  }

  function add()
  {
    $this->is_allowed('lansia_add');
    $this->template->set_title(cclang("add") . " " . $this->title);
    $data = array(
      'action' => url("lansia/add_action"),
      'nama' => set_value("nama"),
      'tempat_lahir' => set_value("tempat_lahir"),
      'tgl_lahir' => set_value("tgl_lahir"),
      'jenis_kelamin' => set_value("jenis_kelamin"),
      'pemeriksaan' => set_value("pemeriksaan"),
      'pemberian_vitamin' => set_value("pemberian_vitamin"),
    );
    $this->template->view("add", $data);
  }

  function add_action()
  {
    if ($this->input->is_ajax_request()) {
      if (!is_allowed('lansia_add')) {
        show_error("Access Permission", 403, '403::Access Not Permission');
        exit();
      }

      $json = array('success' => false);
      $this->form_validation->set_rules("nama", "* Nama", "trim|xss_clean|required");
      $this->form_validation->set_rules("tempat_lahir", "* Tempat lahir", "trim|xss_clean|required");
      $this->form_validation->set_rules("tgl_lahir", "* Tgl lahir", "trim|xss_clean|required");
      $this->form_validation->set_rules("jenis_kelamin", "* Jenis kelamin", "trim|xss_clean|required");
      $this->form_validation->set_rules("pemeriksaan", "* Pemeriksaan", "trim|xss_clean|required");
      $this->form_validation->set_rules("pemberian_vitamin", "* Pemberian vitamin", "trim|xss_clean");
      $this->form_validation->set_error_delimiters('<i class="error text-danger" style="font-size:11px">', '</i>');

      if ($this->form_validation->run()) {
        $save_data['nama'] = $this->input->post('nama', true);
        $save_data['tempat_lahir'] = $this->input->post('tempat_lahir', true);
        $save_data['tgl_lahir'] = date("Y-m-d",  strtotime($this->input->post('tgl_lahir', true)));
        $save_data['jenis_kelamin'] = $this->input->post('jenis_kelamin', true);
        $save_data['pemeriksaan'] = $this->input->post('pemeriksaan', true);
        $save_data['pemberian_vitamin'] = $this->input->post('pemberian_vitamin', true);
        $save_data['createdAt'] = date('Y-m-d H:i:s');

        $this->model->insert($save_data);

        set_message("success", cclang("notif_save"));
        $json['redirect'] = url("lansia");
        $json['success'] = true;
      } else {
        foreach ($_POST as $key => $value) {
          $json['alert'][$key] = form_error($key);
        }
      }

      $this->response($json);
    }
  }

  function update($id)
  {
    $this->is_allowed('lansia_update');
    if ($row = $this->model->find(dec_url($id))) {
      $this->template->set_title(cclang("update") . " " . $this->title);
      $data = array(
        'action' => url("lansia/update_action/$id"),
        'nama' => set_value("nama", $row->nama),
        'tempat_lahir' => set_value("tempat_lahir", $row->tempat_lahir),
        'tgl_lahir' => $row->tgl_lahir == "" ? "" : date("Y-m-d",  strtotime($row->tgl_lahir)),
        'jenis_kelamin' => set_value("jenis_kelamin", $row->jenis_kelamin),
        'pemeriksaan' => set_value("pemeriksaan", $row->pemeriksaan),
        'pemberian_vitamin' => set_value("pemberian_vitamin", $row->pemberian_vitamin),
      );
      $this->template->view("update", $data);
    } else {
      $this->error404();
    }
  }

  function update_action($id)
  {
    if ($this->input->is_ajax_request()) {
      if (!is_allowed('lansia_update')) {
        show_error("Access Permission", 403, '403::Access Not Permission');
        exit();
      }

      $json = array('success' => false);
      $this->form_validation->set_rules("nama", "* Nama", "trim|xss_clean|required");
      $this->form_validation->set_rules("tempat_lahir", "* Tempat lahir", "trim|xss_clean|required");
      $this->form_validation->set_rules("tgl_lahir", "* Tgl lahir", "trim|xss_clean|required");
      $this->form_validation->set_rules("jenis_kelamin", "* Jenis kelamin", "trim|xss_clean|required");
      $this->form_validation->set_rules("pemeriksaan", "* Pemeriksaan", "trim|xss_clean|required");
      $this->form_validation->set_rules("pemberian_vitamin", "* Pemberian vitamin", "trim|xss_clean");
      $this->form_validation->set_error_delimiters('<i class="error text-danger" style="font-size:11px">', '</i>');

      if ($this->form_validation->run()) {
        $save_data['nama'] = $this->input->post('nama', true);
        $save_data['tempat_lahir'] = $this->input->post('tempat_lahir', true);
        $save_data['tgl_lahir'] = date("Y-m-d",  strtotime($this->input->post('tgl_lahir', true)));
        $save_data['jenis_kelamin'] = $this->input->post('jenis_kelamin', true);
        $save_data['pemeriksaan'] = $this->input->post('pemeriksaan', true);
        $save_data['pemberian_vitamin'] = $this->input->post('pemberian_vitamin', true);

        $save = $this->model->change(dec_url($id), $save_data);

        set_message("success", cclang("notif_update"));

        $json['redirect'] = url("lansia");
        $json['success'] = true;
      } else {
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
      if (!is_allowed('lansia_delete')) {
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
    $sheet->setCellValue('H3', "Tempat Lahir");
    $sheet->setCellValue('I3', "Tanggal lahir");
    $sheet->setCellValue('J3', "Jenis Kelamin");
    $sheet->setCellValue('K3', 'Pemeriksaan');
    $sheet->setCellValue('L3', 'Pemberian Vitamin');
    $sheet->setCellValue('M3', 'Email pelanggan');
    $sheet->setCellValue('N3', 'Kader');

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
    $sheet->getStyle('L3')->applyFromArray($style_col);
    $sheet->getStyle('M3')->applyFromArray($style_col);
    $sheet->getStyle('N3')->applyFromArray($style_col);

    //GET DATA
    $rfqData = $this->base->getExport(['mulai' => $mulai, 'akhir' => $akhir])->result();
    $no = 1; // Untuk penomoran tabel, di awal set dengan 1
    $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
    foreach ($rfqData as $data) { // Lakukan looping pada variabel siswa
      $sheet->setCellValue('A' . $numrow, $data->id);
      $sheet->setCellValue('B' . $numrow, $data->deadline);
      $sheet->setCellValue('C' . $numrow, $data->sbu);
      $sheet->setCellValue('D' . $numrow, $data->npp);
      $sheet->setCellValue('E' . $numrow, $data->no_penawaran);
      $sheet->setCellValue('F' . $numrow, $data->status_gagal);
      $sheet->setCellValue('G' . $numrow, $data->status_penawaran);
      $sheet->setCellValue('H' . $numrow, $data->pelanggan);
      $sheet->setCellValue('I' . $numrow, $data->nama_perusahaan);
      $sheet->setCellValue('J' . $numrow, $data->nama_proyek);
      $sheet->setCellValue('K' . $numrow, $data->nama_owner);
      $sheet->setCellValue('L' . $numrow, $data->untuk_perhatian);
      $sheet->setCellValue('M' . $numrow, $data->email_pelanggan);
      $sheet->setCellValue('N' . $numrow, $data->no_hp);

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
      $sheet->getStyle('L' . $numrow)->applyFromArray($style_row);
      $sheet->getStyle('M' . $numrow)->applyFromArray($style_row);
      $sheet->getStyle('N' . $numrow)->applyFromArray($style_row);

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
    $sheet->getColumnDimension('L')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('M')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('N')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('O')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('P')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('Q')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('R')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('S')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('T')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('U')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('V')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('W')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('X')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('Y')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('Z')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('AA')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('AB')->setWidth(50); // Set width kolom E
    $sheet->getColumnDimension('AC')->setWidth(50); // Set width kolom E

    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $sheet->getDefaultRowDimension()->setRowHeight(-1);
    // Set orientasi kertas jadi LANDSCAPE
    $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    // Set judul file excel nya
    $sheet->setTitle("Data Monitor RFQ");
    // Proses file excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="Data Lansia ' . $mulai . ' - ' . $akhir . '.xlsx"'); // Set nama file excel nya
    header('Cache-Control: max-age=0');
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
  }
}

/* End of file Lansia.php */
/* Location: ./application/modules/lansia/controllers/backend/Lansia.php */
