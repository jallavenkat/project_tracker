<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sql extends CI_Model {

	public function checkUser($params)
	{
		$query=$this->db->select("*")->from("users")->where(array("email" => $params["email"],"password" => $params["password"], "status" => 1))->where_in("usertype",array(1))->get(); 
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return array();
		}
	}
	
	public function getUserDetailsByEmail($email)
	{
		$this->db->select("*")->from('users')->where("email",$email);
		$query = $this->db->get(); 
		if($query->num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return array();
		}
	}
	
	public function getUserDetails($email)
	{
		$this->db->select("*")->from("users")->where(array("usertype" => 1,"email" => $email));
		$query=$this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else{
			return array();
		}
	}
	
	public function updateNewPassword($params,$email)
	{
		$query=$this->db->update("users",$params,array("email" => $email));
		if($query)
		{
			return 1;
		}
		else{
			return 0;
		}
	}
	
	public function getSuperAdminUserDetails()
	{
		$this->db->select("email,mobile")->from("users")->where(array("usertype" => 1,"status" => 1));
		$query=$this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else{
			return array();
		}
	}	
	
	public function getSitename()
	{
		$query = $this->db->select("*")->from("configurations")->where(array("configTitle" => "sitename"))->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else{
			return array();
		}
	}
	
	public function getTotalInfo($table,$orderCol,$orderBy="ASC")
	{
		if($orderCol !='')
		{
			$this->db->order_by($orderCol,$orderBy);
		}
		$query = $this->db->select("*")->from($table)->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else{
			return array();
		}
	} 
	public function getAllInfo($table,$orderBy=null)
	{
		if($orderBy !='')
		{
			$this->db->order_by($orderBy,"ASC");
		}
		$query = $this->db->select("*")->from($table)->get(); 
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else{
			return array();
		}
	}
	public function getInfobyId($table,$bannerid)
	{
		$query = $this->db->select("*")->from($table)->where("id",$bannerid)->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else{
			return array();
		}
	} 
	public function storeItems($table,$params)
	{
		$query=$this->db->insert($table,$params);
		if($query)
		{
			return $this->db->insert_id();
		}
		else{
			return 0;
		}
	}  
	
	public function updateItems($table,$params,$bannerid)
	{
		$query=$this->db->update($table,$params,array("id" => $bannerid));
		if($query)
		{
			return 1;
		}
		else{
			return 0;
		}
	}
	
	public function deleteInfoByTableAndIdWithMedia($table,$rowId,$coloumn,$folder)
	{		
		$this->db->select("*")->from($table)->where(array("id" => $rowId));		
		$query=$this->db->get();
		
		if($query->num_rows() == 1)
		{
			$result=$query->result();
			@unlink(FCPATH . 'uploads/'.$folder.'/' . $result[0]->$coloumn);								
		}
		$deletequery=$this->db->delete($table,array("id" => $rowId));
		if($deletequery)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	  
	
	public function deleteItems($table,$rowid)
	{		
		$deletequery=$this->db->delete($table,array("id" => $rowid));
		if($deletequery)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function deleteDirectory($dirPath) {
		if (is_dir($dirPath)) {
			$objects = scandir($dirPath);
			foreach ($objects as $object) {
				if ($object != "." && $object !="..") {
					if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
						$this->deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
					} else {
						unlink($dirPath . DIRECTORY_SEPARATOR . $object);
					}
				}
			}
		reset($objects);
		rmdir($dirPath);
		}
	}	
	
	public function deleteInfoByTableAndId($table,$id)
	{
		$deletequery=$this->db->delete($table,array("id" => $id));
		if($deletequery)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function getInfoByPage($table,$page,$column=null,$order=null)
	{
		if($column !='' && $order !='')
		{
			$this->db->order_by($column,$order);
		}
		$query = $this->db->select("*")->from($table)->where("page_type",$page)->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else{
			return array();
		}
	}
	
	
	public function removeExitingImageParams($table,$bannerid,$folder,$coloumn)
	{
		$this->db->select("*")->from($table)->where(array("id" => $bannerid));
		$query=$this->db->get(); 
		if($query->num_rows() > 0)
		{
			$result=$query->result();
			$delete=@unlink(FCPATH . 'uploads/'.@$folder.'/'.@$result[0]->$coloumn);
			if($delete)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
	}
	
	public function removeExitingImageWithWhere($table,$where,$folder,$coloumn)
	{
		$this->db->select("*")->from($table)->where($where);
		$query=$this->db->get(); 
		if($query->num_rows() > 0)
		{
			$result=$query->result();
			$delete=@unlink(FCPATH . 'uploads/'.@$folder.'/'.@$result[0]->$coloumn);
			if($delete)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
	}
	public function deleteInfoByTableArrayAndIdWithMedia($table,$array,$folder,$coloumn)
	{		
		$this->db->select("*")->from($table)->where($array);		
		$query=$this->db->get();
		$deletequery=$this->db->delete($table,$array);
		if($deletequery)
		{
			if($query->num_rows() > 0)
			{
				$result=$query->result();
				@unlink(FCPATH . 'uploads/'.$folder.'/'.$result[0]->$coloumn);								
			}
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function getTableRowDataOrder($table,$where,$column=null,$order=null)
	{
		if($column !='' && $order !='')
		{
			$this->db->order_by($column,$order);
		}
		$this->db->select("*")->from($table)->where($where);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return array();
		}
	}
	
	public function getTableRowDataArray($table,$where,$array,$column)
	{
		$this->db->select("*")->from($table)->where($where)->where_in($column,$array)->order_by("id","DESC");
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return array();
		}
	}
	public function getTableRowDataArrayLimit($table,$where,$array,$column,$limit)
	{
		$this->db->select("*")->from($table)->where($where)->where_in($column,$array)->order_by("id","DESC");
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return array();
		}
	}
	public function getTableRowDataNoWhereArray($table,$array,$column)
	{
		$this->db->select("*")->from($table)->where_in($column,$array)->order_by("id","DESC");
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return array();
		}
	}
	public function getTableLimitData($table,$where,$limit,$column,$order)
	{
		$this->db->select("*")->from($table)->where($where)->limit($limit,0)->order_by($column,$order);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return array();
		}
	}
	
	public function getTableLimitDataNoWhere($table,$limit,$column,$order)
	{
		$this->db->select("*")->from($table)->limit($limit,0)->order_by($column,$order);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return array();
		}
	}
	
	public function getTableRowDataNotIn($table,$where,$column,$array)
	{
		$this->db->select("*")->from($table)->where($where)->where_not_in($column,$array);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return array();
		}
	}
	public function getTableRowDataWhereOrderArray($table,$where,$arrayCol,$arrayVals,$column,$order)
	{
		if(@sizeOf($arrayVals) > 0)
		{
			$this->db->select("*")->from($table)->where($where)->where_in($arrayCol,$arrayVals)->order_by($column,$order);
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->result();
			}
			else
			{
				return array();
			}
		}
		else{
			return array();
		}
	}
	public function getTableRowDataOrderArray($table,$arrayCol,$arrayVals,$column,$order)
	{
		if(@sizeOf($arrayVals) > 0)
		{
			$this->db->select("*")->from($table)->where_in($arrayCol,$arrayVals)->order_by($column,$order);
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->result();
			}
			else
			{
				return array();
			}
		}
		else{
			return array();
		}
	}
	
	public function getTableRowDataOrderArrayLimit($table,$arrayCol,$arrayVals,$limit,$column,$order)
	{
		if(@sizeOf($arrayVals) > 0)
		{
			$this->db->select("*")->from($table)->where_in($arrayCol,$arrayVals)->limit($limit)->order_by($column,$order);
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->result();
			}
			else
			{
				return array();
			}
		}
		else{
			return array();
		}
	}
	public function getTableRowDataGroupOrder($table,$where,$column,$order,$groupColumn)
	{
		$this->db->select("*")->from($table)->where($where)->order_by($column,$order)->group_by($groupColumn);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return array();
		}
	}
	public function getTableRowDataGroupOrderParams($table,$groupcol,$where,$column,$order,$groupColumn)
	{
		$this->db->select($groupcol)->from($table)->where($where)->order_by($column,$order)->group_by($groupColumn);
		$query = $this->db->get(); 
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return array();
		}
	}
	public function deleteItemsbyWhere($table,$where)
	{
		$deletequery=$this->db->delete($table,$where);
		if($deletequery)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	} 
	public function getAllInfobyTypewr($table,$coloumn,$type,$ordBy=null)
	{
		if($ordBy !='')
		{
			$this->db->order_by("id",$ordBy);
		}
		$this->db->where(array($coloumn => $type));
		$query = $this->db->select("*")->from($table)->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else{
			return array();
		}
	}
	public function updateItemsWithWhere($table,$params,$where)
	{
		$query=$this->db->update($table,$params,$where);
		echo $this->db->last_query();
		if($query)
		{
			return 1;
		}
		else{
			return 0;
		}
	}
	public function deleteInfoByTableRow($table,$where)
	{
		$deletequery=$this->db->delete($table,$where);
		if($deletequery)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
}