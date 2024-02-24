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


class Balita extends Backend{

private $title = "Balita";


public function __construct()
{
  $config = array(
    'title' => $this->title,
   );
  parent::__construct($config);
  $this->load->model("Balita_model","model");
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
    foreach ($list as $row) {
        $rows = array();
                $rows[] = $row->id;
                $rows[] = $row->nama;
                $rows[] = $row->tempat_lahir;
                $rows[] = date("d-m-Y",  strtotime($row->tgl_lahir));
                $rows[] = $row->nama_ayah;
                $rows[] = $row->nama_ibu;
                $rows[] = $row->catatan;
                $rows[] = $row->berat_badan;
                $rows[] = $row->tinggi_badan;
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


}

/* End of file Balita.php */
/* Location: ./application/modules/balita/controllers/backend/Balita.php */
