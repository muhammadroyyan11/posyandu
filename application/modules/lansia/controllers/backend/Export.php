<?php defined('BASEPATH') or exit('No direct script access allowed');
/*| --------------------------------------------------------------------------*/
/*| dev : royyan  */
/*| version : V.0.0.2 */
/*| facebook :  */
/*| fanspage :  */
/*| instagram :  */
/*| youtube :  */
/*| --------------------------------------------------------------------------*/
/*| Generate By M-CRUD Generator 12/12/2023 17:07*/
/*| Please DO NOT modify this information*/

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export extends CI_Controller
{
    private $title = 'Rfq Request';

    public function __construct()
    {
        $config = [
            'title' => $this->title,
        ];
        parent::__construct($config);
        $this->load->model('Rfq_request_model', 'model');
        $this->load->model('Base_model', 'base');
    }

    public function export()
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
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

/* End of file Rfq_request.php */
/* Location: ./application/modules/rfq_request/controllers/backend/Rfq_request.php */
