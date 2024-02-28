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


class Balita_model extends MY_Model{

  private $table        = "balita";
  private $primary_key  = "id";
  private $column_order = array('id', 'nama', 'tempat_lahir', 'tgl_lahir', 'jenis_kelamin', 'nama_ayah', 'nama_ibu', 'catatan', 'berat_badan', 'tinggi_badan', 'createdAt', 'updatedAt');
  private $order        = array('balita.id'=>"DESC");
  private $select       = "balita.id,balita.id,balita.nama,balita.tempat_lahir,balita.tgl_lahir,balita.jenis_kelamin,balita.nama_ayah,balita.nama_ibu,balita.catatan,balita.berat_badan,balita.tinggi_badan,balita.createdAt,balita.updatedAt";

public function __construct()
	{
		$config = array(
      'table' 	      => $this->table,
			'primary_key' 	=> $this->primary_key,
		 	'select' 	      => $this->select,
      'column_order' 	=> $this->column_order,
      'order' 	      => $this->order,
		 );

		parent::__construct($config);
	}

  private function _get_datatables_query()
    {
      $this->db->select($this->select);
      $this->db->from($this->table);

    if($this->input->post("nama"))
        {
          $this->db->like("balita.nama", $this->input->post("nama"));
        }

    if($this->input->post("tempat_lahir"))
        {
          $this->db->like("balita.tempat_lahir", $this->input->post("tempat_lahir"));
        }

    if($this->input->post("tgl_lahir"))
        {
          $this->db->like("balita.tgl_lahir", date('Y-m-d',strtotime($this->input->post("tgl_lahir"))));
        }

    if($this->input->post("nama_ayah"))
        {
          $this->db->like("balita.nama_ayah", $this->input->post("nama_ayah"));
        }

    if($this->input->post("nama_ibu"))
        {
          $this->db->like("balita.nama_ibu", $this->input->post("nama_ibu"));
        }

    if($this->input->post("catatan"))
        {
          $this->db->like("balita.catatan", $this->input->post("catatan"));
        }

    if($this->input->post("berat_badan"))
        {
          $this->db->like("balita.berat_badan", $this->input->post("berat_badan"));
        }

    if($this->input->post("tinggi_badan"))
        {
          $this->db->like("balita.tinggi_badan", $this->input->post("tinggi_badan"));
        }

    if($this->input->post("createdAt"))
        {
          $this->db->like("balita.createdAt", date('Y-m-d H:i',strtotime($this->input->post("createdAt"))));
        }

      if(isset($_POST['order'])) // here order processing
       {
           $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
       }
       else if(isset($this->order))
       {
           $order = $this->order;
           $this->db->order_by(key($order), $order[key($order)]);
       }

    }


    public function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
      $this->db->select($this->select);
      $this->db->from("$this->table");
      return $this->db->count_all_results();
    }



}

/* End of file Balita_model.php */
/* Location: ./application/modules/balita/models/Balita_model.php */
