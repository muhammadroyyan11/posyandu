<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*| --------------------------------------------------------------------------*/
/*| dev : royyan  */
/*| version : V.0.0.2 */
/*| facebook :  */
/*| fanspage :  */
/*| instagram :  */
/*| youtube :  */
/*| --------------------------------------------------------------------------*/
/*| Generate By M-CRUD Generator 22/02/2024 19:52*/
/*| Please DO NOT modify this information*/


class Ibu_hamil extends Backend{

private $title = "Ibu Hamil";


public function __construct()
{
  $config = array(
    'title' => $this->title,
   );
  parent::__construct($config);
  $this->load->model("Ibu_hamil_model","model");
}

function index()
{
  $this->is_allowed('ibu_hamil_list');
  $this->template->set_title($this->title);
  $this->template->view("index");
}

function json()
{
  if ($this->input->is_ajax_request()) {
    if (!is_allowed('ibu_hamil_list')) {
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
                $rows[] = $row->nama_suami;
                $rows[] = $row->umur_kandungan;
                $rows[] = $row->vitamin;
                $rows[] = $row->berat_badan;
                $rows[] = date("d-m-Y H:i",  strtotime($row->createdAt));
                $rows[] = date("d-m-Y H:i",  strtotime($row->updatedAt));
        
        $rows[] = '
                  <div class="btn-group" role="group" aria-label="Basic example">
                      <a href="'.url("ibu_hamil/detail/".enc_url($row->id)).'" id="detail" class="btn btn-primary" title="'.cclang("detail").'">
                        <i class="mdi mdi-file"></i>
                      </a>
                      <a href="'.url("ibu_hamil/update/".enc_url($row->id)).'" id="update" class="btn btn-warning" title="'.cclang("update").'">
                        <i class="ti-pencil"></i>
                      </a>
                      <a href="'.url("ibu_hamil/delete/".enc_url($row->id)).'" id="delete" class="btn btn-danger" title="'.cclang("delete").'">
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
  if(!is_allowed('ibu_hamil_filter'))
  {
    echo "access not permission";
  }else{
    $this->template->view("filter",[],false);
  }
}

function detail($id)
{
  $this->is_allowed('ibu_hamil_detail');
    if ($row = $this->model->find(dec_url($id))) {
    $this->template->set_title("Detail ".$this->title);
    $data = array(
          "nama" => $row->nama,
          "tempat_lahir" => $row->tempat_lahir,
          "tgl_lahir" => $row->tgl_lahir,
          "nama_suami" => $row->nama_suami,
          "umur_kandungan" => $row->umur_kandungan,
          "vitamin" => $row->vitamin,
          "berat_badan" => $row->berat_badan,
    );
    $this->template->view("view",$data);
  }else{
    $this->error404();
  }
}

function add()
{
  $this->is_allowed('ibu_hamil_add');
  $this->template->set_title(cclang("add")." ".$this->title);
  $data = array('action' => url("ibu_hamil/add_action"),
                  'nama' => set_value("nama"),
                  'tempat_lahir' => set_value("tempat_lahir"),
                  'tgl_lahir' => set_value("tgl_lahir"),
                  'nama_suami' => set_value("nama_suami"),
                  'umur_kandungan' => set_value("umur_kandungan"),
                  'vitamin' => set_value("vitamin"),
                  'berat_badan' => set_value("berat_badan"),
                  );
  $this->template->view("add",$data);
}

function add_action()
{
  if($this->input->is_ajax_request()){
    if (!is_allowed('ibu_hamil_add')) {
      show_error("Access Permission", 403,'403::Access Not Permission');
      exit();
    }

    $json = array('success' => false);
    $this->form_validation->set_rules("nama","* Nama","trim|xss_clean|required");
    $this->form_validation->set_rules("tempat_lahir","* Tempat lahir","trim|xss_clean|required");
    $this->form_validation->set_rules("tgl_lahir","* Tgl lahir","trim|xss_clean|required");
    $this->form_validation->set_rules("nama_suami","* Nama suami","trim|xss_clean|required");
    $this->form_validation->set_rules("umur_kandungan","* Umur kandungan","trim|xss_clean|required");
    $this->form_validation->set_rules("vitamin","* Vitamin","trim|xss_clean");
    $this->form_validation->set_rules("berat_badan","* Berat badan","trim|xss_clean|required");
    $this->form_validation->set_error_delimiters('<i class="error text-danger" style="font-size:11px">','</i>');

    if ($this->form_validation->run()) {
      $save_data['nama'] = $this->input->post('nama',true);
      $save_data['tempat_lahir'] = $this->input->post('tempat_lahir',true);
      $save_data['tgl_lahir'] = date("Y-m-d",  strtotime($this->input->post('tgl_lahir', true)));
      $save_data['nama_suami'] = $this->input->post('nama_suami',true);
      $save_data['umur_kandungan'] = $this->input->post('umur_kandungan',true);
      $save_data['vitamin'] = $this->input->post('vitamin',true);
      $save_data['berat_badan'] = $this->input->post('berat_badan',true);

      $this->model->insert($save_data);

      set_message("success",cclang("notif_save"));
      $json['redirect'] = url("ibu_hamil");
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
  $this->is_allowed('ibu_hamil_update');
  if ($row = $this->model->find(dec_url($id))) {
    $this->template->set_title(cclang("update")." ".$this->title);
    $data = array('action' => url("ibu_hamil/update_action/$id"),
                  'nama' => set_value("nama", $row->nama),
                  'tempat_lahir' => set_value("tempat_lahir", $row->tempat_lahir),
                  'tgl_lahir' => $row->tgl_lahir == "" ? "":date("Y-m-d",  strtotime($row->tgl_lahir)),
                  'nama_suami' => set_value("nama_suami", $row->nama_suami),
                  'umur_kandungan' => set_value("umur_kandungan", $row->umur_kandungan),
                  'vitamin' => set_value("vitamin", $row->vitamin),
                  'berat_badan' => set_value("berat_badan", $row->berat_badan),
                  );
    $this->template->view("update",$data);
  }else {
    $this->error404();
  }
}

function update_action($id)
{
  if($this->input->is_ajax_request()){
    if (!is_allowed('ibu_hamil_update')) {
      show_error("Access Permission", 403,'403::Access Not Permission');
      exit();
    }

    $json = array('success' => false);
    $this->form_validation->set_rules("nama","* Nama","trim|xss_clean|required");
    $this->form_validation->set_rules("tempat_lahir","* Tempat lahir","trim|xss_clean|required");
    $this->form_validation->set_rules("tgl_lahir","* Tgl lahir","trim|xss_clean|required");
    $this->form_validation->set_rules("nama_suami","* Nama suami","trim|xss_clean|required");
    $this->form_validation->set_rules("umur_kandungan","* Umur kandungan","trim|xss_clean|required");
    $this->form_validation->set_rules("vitamin","* Vitamin","trim|xss_clean");
    $this->form_validation->set_rules("berat_badan","* Berat badan","trim|xss_clean|required");
    $this->form_validation->set_error_delimiters('<i class="error text-danger" style="font-size:11px">','</i>');

    if ($this->form_validation->run()) {
      $save_data['nama'] = $this->input->post('nama',true);
      $save_data['tempat_lahir'] = $this->input->post('tempat_lahir',true);
      $save_data['tgl_lahir'] = date("Y-m-d",  strtotime($this->input->post('tgl_lahir', true)));
      $save_data['nama_suami'] = $this->input->post('nama_suami',true);
      $save_data['umur_kandungan'] = $this->input->post('umur_kandungan',true);
      $save_data['vitamin'] = $this->input->post('vitamin',true);
      $save_data['berat_badan'] = $this->input->post('berat_badan',true);

      $save = $this->model->change(dec_url($id), $save_data);

      set_message("success",cclang("notif_update"));

      $json['redirect'] = url("ibu_hamil");
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
    if (!is_allowed('ibu_hamil_delete')) {
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

/* End of file Ibu_hamil.php */
/* Location: ./application/modules/ibu_hamil/controllers/backend/Ibu_hamil.php */
