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


class Lansia_model extends MY_Model{

  private $table        = "lansia";
  private $primary_key  = "id";
  private $column_order = array('id', 'nama', 'tempat_lahir', 'tgl_lahir', 'jenis_kelamin', 'pemeriksaan', 'pemberian_vitamin', 'createdAt');
  private $order        = array('lansia.id'=>"DESC");
  private $select       = "lansia.id,lansia.id,lansia.nama,lansia.tempat_lahir,lansia.tgl_lahir,lansia.jenis_kelamin,lansia.pemeriksaan,lansia.pemberian_vitamin,lansia.createdAt";

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
          $this->db->like("lansia.nama", $this->input->post("nama"));
        }

    if($this->input->post("tempat_lahir"))
        {
          $this->db->like("lansia.tempat_lahir", $this->input->post("tempat_lahir"));
        }

    if($this->input->post("tgl_lahir"))
        {
          $this->db->like("lansia.tgl_lahir", date('Y-m-d',strtotime($this->input->post("tgl_lahir"))));
        }

    if($this->input->post("jenis_kelamin"))
        {
          $this->db->like("lansia.jenis_kelamin", $this->input->post("jenis_kelamin"));
        }

    if($this->input->post("pemeriksaan"))
        {
          $this->db->like("lansia.pemeriksaan", $this->input->post("pemeriksaan"));
        }

    if($this->input->post("pemberian_vitamin"))
        {
          $this->db->like("lansia.pemberian_vitamin", $this->input->post("pemberian_vitamin"));
        }

    if($this->input->post("createdAt"))
        {
          $this->db->like("lansia.createdAt", date('Y-m-d H:i',strtotime($this->input->post("createdAt"))));
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

/* End of file Lansia_model.php */
/* Location: ./application/modules/lansia/models/Lansia_model.php */
