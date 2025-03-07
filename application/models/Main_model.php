<?php
class Main_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * Obtiene una fila segun la consulta
	 *
	 * @author Ing. John Evert Aleman Orellana
	 * @copyright GAM Cochabamba
	 * @param  string 	$table 	El nombre de la tabla
	 * @param  array 	$where 	Condiciones WHERE para las consultas
	 * @param  array 	$joins  Condiciones JOIN para los resultados
	 * @return object        	Resultado de la consulta realizada
	 */
	function get($table, $where=null, $joins=null){
		if($joins){
			foreach($joins as $table2=>$field){
				$this->db->join($table2, $table2.'.'.$field.' = '.$table.'.'.$field, 'left');
			}
		}
		return $this->db->get_where($table, $where)->row();
	}

	/**
	 * Obtiene una fila segun la consulta
	 *
	 * @author Ing. John Evert Aleman Orellana
	 * @copyright GAM Cochabamba
	 * @param  string 	$table 	El nombre de la tabla
	 * @param  array 	$where 	Condiciones WHERE para las consultas
	 * @param  array 	$joins  Condiciones JOIN para los resultados
	 * @return object        	Resultado de la consulta realizada
	 */
	function getOrder($table, $order=null, $where=null, $joins=null){
		if($order){
			foreach($order as $orderby=>$direction){
				$this->db->order_by($orderby, $direction);
			}
		}
		return $this->get($table, $where, $joins);
	}


	/**
	 * Obtiene una fila con los campos seleccionados
	 *
	 * @author Ing. John Evert Aleman Orellana
	 * @copyright GAM Cochabamba
	 * @param  string 	$table  El nombre de la tabla
	 * @param  string 	$select Campos que seran devueltos despues de la consulta
	 * @param  array 	$where  Condiciones WHERE para la consulta
	 * @param  array 	$joins  Condiciones JOIN para la consulta
	 * @return object         	Resultado de la consulta realizada
	 */
	function getSelect($table, $select=null, $where = null, $joins=null){
		$this->db->select($select, false);
		return $this->get($table, $where, $joins);
	}

	/**
	 * Obtiene la cantidad de registros segun la consulta
	 *
	 * @author Ing. John Evert Aleman Orellana
	 * @copyright GAM Cochabamba
	 * @param  string 	$table  El nombre de la tabla
	 * @param  array 	$where  Condiciones WHERE para la consulta
	 * @param  array 	$joins  Condiciones JOIN para la consulta
	 * @return integer          Cantidad de resultados de la consulta realizada
	 */
	function total($table, $where = null, $joins=null){
		$this->db->distinct();
		if($joins){
			foreach($joins as $table2=>$field){
				$this->db->join($table2, $table2.'.'.$field.' = '.$table.'.'.$field, 'left');
			}
		}

		return $this->db->get_where($table, $where)->num_rows();
	}

	/**
	 * Obtiene una lista con todos los campos segun la consulta
	 *
	 * @author Ing. John Evert Aleman Orellana
	 * @copyright GAM Cochabamba
	 * @param  string 	$table  	El nombre de la tabla
	 * @param  array 	$where  	Condiciones WHERE para la consulta
	 * @param  integer 	$limit  	Cantidad de resultados a mostrar
	 * @param  integer  $offset 	A partir de que registro se mostraran los rosultados
	 * @param  array 	$joins  	Condiciones JOIN para la consulta
	 * @param  string 	$groupby 	Sirve para agrupar los resultados por algun campo en especifico
	 * @return object          		Los resultados de la consulta realizada
	 */
	function getList($table, $where = null, $limit = null, $offset = null, $joins=null, $groupby=null){
		$this->db->distinct();
		if($joins){
			foreach($joins as $table2=>$field){
				$this->db->join($table2, $table2.'.'.$field.' = '.$table.'.'.$field, 'left');
			}
		}

		if($groupby){
			$this->db->group_by($groupby);
		}

		return $this->db->get_where($table, $where, $limit, $offset)->result();
	}
	function getListWD($table, $where = null, $limit = null, $offset = null, $joins=null, $groupby=null){
		
		if($joins){
			foreach($joins as $table2=>$field){
				$this->db->join($table2, $table2.'.'.$field.' = '.$table.'.'.$field, 'left');
			}
		}

		if($groupby){
			$this->db->group_by($groupby);
		}

		return $this->db->get_where($table, $where, $limit, $offset)->result();
	}

	/**
	 * Devuelve una lista ordenada por un campo
	 * @author Ing. John Evert Aleman Orellana
	 * @copyright GAM Cochabamba
	 * @param  string 	$table  	El nombre de la tabla
	 * @param  array    $order   	El campo a ordenarce y si es adc o desc
	 * @param  array 	$where  	Condiciones WHERE para la consulta
	 * @param  integer 	$limit  	Cantidad de resultados a mostrar
	 * @param  integer  $offset 	A partir de que registro se mostraran los rosultados
	 * @param  array 	$joins  	Condiciones JOIN para la consulta
	 * @param  string 	$groupby 	Sirve para agrupar los resultados por algun campo en especifico
	 * @return object          		Los resultados de la consulta realizada
	 */
	function getListOrder($table, $order=null, $where = null, $limit = null, $offset = null, $joins=null, $groupby=null){
		if($order){
			foreach($order as $orderby=>$direction){
				$this->db->order_by($orderby, $direction);
			}
		}
		return $this->getList($table, $where, $limit, $offset, $joins, $groupby);
	}

	/**
	 * Inserta registros a una tabla
	 *
	 * @author Ing. John Evert Aleman Orellana
	 * @update Lic. Juan Garcia Arevalo
	 * @copyright GAM Cochabamba
	 * @param  string 	$table  	El nombre de la tabla
	 * @param  array   	$data  		Los datos a insertarse en la tabla
	 * @return integer        		el Id generado tras la inserccion.
	 */
	 /*function insert($table, $data)
	 {
	 	$this->db->insert($table, $data);

		$id = $this->db->insert_id();
	}*/
	 function insert($table, $data, $seq = null)
	 {
		  $this->db->insert($table, $data);

		  return $this->db->insert_id($seq);

    }





	/**
	 * Elimina un registro
	 *
	 * @author Ing. John Evert Aleman Orellana
	 * @copyright GAM Cochabamba
	 * @param  string 	$table  	El nombre de la tabla
	 * @param  array 	$where 		Condiciones WHERE para la eliminacion
	 * @return [type]        [description]
	 */
	// function delete($table, $where = null) {
	// 	$this->db->delete($table, $where);
	// }

	/*
		Method modified for audit queries
	 */
	function delete($table, $where = null)
	{
		$this->db->delete($table, $where);
		$query = ( $this->config->item('save_query')['delete'] )? $this->db->last_query(): '';

		if ( $this->config->item('save_query')['delete'] )
			$this->audit_sql_delete($table, $query);
	}

	/**
	 * Actualiza un registro de una tabla
	 * Ing. John Evert Aleman Orellana
     * @update Lic. Juan Garcia Arevalo
	 * @copyright GAM Cochabamba
	 * @param  string 	$table  	El nombre de la tabla
	 * @param  array 	$set   		Los campos que seran actualizados
	 * @param  array 	$where 		Condiciones WHERE para la eliminacion
	 * @return void
	 */

	 function update($table, $set=null, $where = null, $operacion = null) {

	     //if($operacion ===null){
	       //  $operacion = 'ACTUALIZAR';
         //}


         //$datoParaActualizar = $this->main->get($table, $where);
         //$consult = $this->db->last_query();
         //$stringPerson = json_encode($datoParaActualizar);
         //$info_anterior = str_replace(['":"', '"'], ['=>', ''], $stringPerson);

         $this->db->update($table, $set, $where);
         //$info_actualizado = $this->db->last_query();
         //auditoria($operacion.' UN ITEM',$table, $info_anterior, $info_actualizado);

     }

	/*
		Method modified for audit queries
	 */
	/*function update($table, $set=null, $where = null)
	{
		$this->db->update($table, $set, $where);
		$query = ( $this->config->item('save_query')['delete'] )? $this->db->last_query(): '';

		if ( $this->config->item('save_query')['update'] )
			$this->audit_sql_update($table, $query);
	}*/


	/**
	 * Obtiene una lista con los campos escogidos
	 *
	 * @author Ing. John Evert Aleman Orellana
	 * @copyright GAM Cochabamba
	 * @param  string 	$table  	El nombre de la tabla
	 * @param  string  	$select  	Campos que seran seleccionados
	 * @param  array 	$order   	Campo por el que seran ordenados los resultados
	 * @param  array 	$where 		Condiciones WHERE para la eliminacion
	 * @param  integer 	$limit  	Cantidad de resultados a mostrar
	 * @param  integer  $offset 	A partir de que registro se mostraran los rosultados
	 * @param  array 	$joins  	Condiciones JOIN para la consulta
	 * @param  string 	$groupby 	Agrupa los resultados por algun campo en especifico
	 * @return object          		Resultado de la consulta realizada
	 */
	function getListSelect($table, $select=null, $order=null, $where = null, $limit = null, $offset = null, $joins=null, $groupby=null){
		if($order){
			foreach($order as $orderby=>$direction){
				$this->db->order_by($orderby, $direction);
			}
		}
		$this->db->select($select, false);
		return $this->getList($table, $where, $limit, $offset, $joins, $groupby);
	}
	function getListSelectWD($table, $select=null, $order=null, $where = null, $limit = null, $offset = null, $joins=null, $groupby=null){
		if($order){
			foreach($order as $orderby=>$direction){
				$this->db->order_by($orderby, $direction);
			}
		}
		$this->db->select($select, false);
		return $this->getListWD($table, $where, $limit, $offset, $joins, $groupby);
	}

	/**
	 * La cantidad de registros de la seleccion
	 *
	 * @author Ing. John Evert Aleman Orellana
	 * @copyright GAM Cochabamba
	 * @param  string 	$table  	El nombre de la tabla
	 * @param  string  	$select  	Campos que seran seleccionados
	 * @param  array 	$where 		Condiciones WHERE para la eliminacion
	 * @param  array 	$joins  	Condiciones JOINS para la consulta
	 * @return integer         		El resultado de la consulta
	 */
	function totalSelect($table, $select=null, $where = null, $joins=null){
		$this->db->select($select, false);
		return $this->total($table, $where, $joins);
	}

	/**
	 *	Un combo box para ser usado
	 *
	 * @param  array   $list  La lista para ser usado como un dropdown
	 * @param  string  $title El titulo o placeholder del dropdown
	 * @param  boolean $type  Typo de combo box para la devolucion
	 * @return object         Un lista tipo combobox
	 */
	function dropdown($list, $title=FALSE, $type=FALSE){
		$options = array();
		if($title!==FALSE){
			if($type){
				$options[] = array('key'=>'', 'value'=>$title);
			}
			else{
				$options =  array(''=>$title);
			}
		}
		foreach ($list as $item){
			if($type){
				$options[] = array('key'=>current($item), 'value'=>end($item));
			}
			else{
				$options[current($item)] = end($item);
			}

		}
		return $options;
	}

	/**
	 * Obtiene el valor de un campo de una tabla de un registro
	 *
	 * @param  string $table El nombre de la tabla
	 * @param  string $field El campo de la tabla
	 * @param  array  $where Condiciones $where para la busqueda
	 * @return string        el resultado de la consulta
	 */
	function getField($table, $field, $where=null){
		$row = $this->db->get_where($table, $where)->row();

		return ($row)?$row->$field:'';
	}

	/**
	 * Devuelve una lista ordenada por un campo, con campos personalizados cuando contiene joins anidados
	 * @copyright GAM Cochabamba
	 * @param  string 	$table  	El nombre de la tabla
	 * @param  string  	$select  	Campos que seran seleccionados
	 * @param  array 	$order   	Campo por el que seran ordenados los resultados
	 * @param  array 	$where 		Condiciones WHERE para la eliminacion
	 * @param  integer 	$limit  	Cantidad de resultados a mostrar
	 * @param  integer  $offset 	A partir de que registro se mostraran los rosultados
	 * @param  array 	$joins  	Condiciones JOIN para la consulta
	 * @param  string 	$groupby 	Agrupa los resultados por algun campo en especifico
	 * @return object          		Resultado de la consulta realizada
	 */
	function getListSelectJoin($table, $select, $order=null, $where = null, $limit = null, $offset = null, $joins=null, $groupby=null){
		if($order){
			foreach($order as $orderby=>$direction){
				$this->db->order_by($orderby, $direction);
			}
		}
		$this->db->select($select, false);

		return $this->getListJoin($table, $where, $limit, $offset, $joins, $groupby);
	}

	/**
	 * Obtiene una lista con todos los campos segun la consulta (Joins Anidados 4 tablas)
	 *
	 * @copyright GAM Cochabamba
	 * @param  string 	$table  	El nombre de la tabla
	 * @param  array 	$where  	Condiciones WHERE para la consulta
	 * @param  integer 	$limit  	Cantidad de resultados a mostrar
	 * @param  integer  $offset 	A partir de que registro se mostraran los rosultados
	 * @param  array 	$joins  	Condiciones JOIN para la consulta (anidados)
	 * @param  string 	$groupby 	Sirve para agrupar los resultados por algun campo en especifico
	 * @return object          		Los resultados de la consulta realizada
	 */
	function getListJoin($table,$where = null, $limit = null, $offset = null, $joins=null, $groupby=null){
		$this->db->distinct();
		if($joins){
			$i=0;
			$previoustable = '';
			foreach($joins as $table2=>$field){
				if($i !=2)
				{
					$this->db->join($table2, $table2.'.'.$field.' = '.$table.'.'.$field, 'left');
				}
				else{
					$this->db->join($table2, $table2.'.'.$field.' = '.$previoustable.'.'.$field, 'left');
				}
				$previoustable = $table2;
				$i++;
			}
		}
		if($groupby){
			$this->db->group_by($groupby);
		}

		return $this->db->get_where($table, $where, $limit, $offset)->result();
	}

	function getSelectGroupBy($table, $select, $where = null,$groupby){

		$this->db->select($select, false);
		$this->db->group_by($groupby);
		return $this->get($table, $where);
	}























	/*
	Methods Privates by this Model
	 */

	private function audit_sql_insert($table='', $primaryKey = 0, $query = '')
	{
		if( !in_array($table, $this->config->item('ignore_tables')) )
			{
				$data                    = array();
				$data['query']           = $query;
				$data['date_time_query'] = 'NOW()';
				$data['id_user']         = $this->session->sistema->id_usuario;
				$data['table']           = $table;
				$data['type']            = 'insert';
				$data['primary_key']     = $primaryKey;

				$this->db->insert('audit_sql', $data);
			}
	}

	private function audit_sql_update($table='', $query = '')
	{
		if( !in_array($table, $this->config->item('ignore_tables')) )
			{
				$data                    = array();
				$data['query']           = $query;
				$data['date_time_query'] = 'NOW()';
				$data['id_user']         = $this->session->sistema->id_usuario;
				$data['table']           = $table;
				$data['type']            = 'update';

				$this->db->insert('audit_sql', $data);
			}
	}

	private function audit_sql_delete($table='', $query = '')
	{
		if( !in_array($table, $this->config->item('ignore_tables')) )
			{
				$data                    = array();
				$data['query']           = $query;
				$data['date_time_query'] = 'NOW()';
				$data['id_user']         = $this->session->sistema->id_usuario;
				$data['table']           = $table;
				$data['type']            = 'delete';

				$this->db->insert('audit_sql', $data);
			}
	}
}
