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


class Ibu_hamil_model extends MY_Model{

  private $table        = "ibu_hamil";
  private $primary_key  = "id";
  private $column_order = array('id', 'nama', 'tempat_lahir', 'tgl_lahir', 'nama_suami', 'umur_kandungan', 'vitamin', 'berat_badan', 'createdAt', 'updatedAt');
  private $order        = array('ibu_hamil.id'=>"DESC");
  private $select       = "ibu_hamil.id,ibu_hamil.id,ibu_hamil.nama,ibu_hamil.tempat_lahir,ibu_hamil.tgl_lahir,ibu_hamil.nama_suami,ibu_hamil.umur_kandungan,ibu_hamil.vitamin,ibu_hamil.berat_badan,ibu_hamil.createdAt,ibu_hamil.updatedAt";

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
          $this->db->like("ibu_hamil.nama", $this->input->post("nama"));
        }

    if($this->input->post("tempat_lahir"))
        {
          $this->db->like("ibu_hamil.tempat_lahir", $this->input->post("tempat_lahir"));
        }

    if($this->input->post("tgl_lahir"))
        {
          $this->db->like("ibu_hamil.tgl_lahir", date('Y-m-d',strtotime($this->input->post("tgl_lahir"))));
        }

    if($this->input->post("nama_suami"))
        {
          $this->db->like("ibu_hamil.nama_suami", $this->input->post("nama_suami"));
        }

    if($this->input->post("umur_kandungan"))
        {
          $this->db->like("ibu_hamil.umur_kandungan", $this->input->post("umur_kandungan"));
        }

    if($this->input->post("vitamin"))
        {
          $this->db->like("ibu_hamil.vitamin", $this->input->post("vitamin"));
        }

    if($this->input->post("berat_badan"))
        {
          $this->db->like("ibu_hamil.berat_badan", $this->input->post("berat_badan"));
        }

    if($this->input->post("createdAt"))
        {
          $this->db->like("ibu_hamil.createdAt", date('Y-m-d H:i',strtotime($this->input->post("createdAt"))));
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

/* End of file Ibu_hamil_model.php */
/* Location: ./application/modules/ibu_hamil/models/Ibu_hamil_model.php */
