<?php
class Match_model extends CI_Model {
	// transaction mode method of fetching match data
	function getExclusive($id) {
		$sql = "select * from `match` where id=? for update";
		$query = $this->db->query($sql,array($id));
		if ($query && $query->num_rows() > 0)
			return $query->row(0,'Match');
		else
			return null;
	}
	// regular way of getting match data
	function get($id) {
		$this->db->where('id',$id);
		$query = $this->db->get('match');
		if ($query && $query->num_rows() > 0)
			return $query->row(0,'Match');
		else
			return null;
	}
	// when a new match is created, add a record in database
	function insert($match) {
		return $this->db->insert('match',$match);
	}
	// update message of player 1
	function updateMsgU1($id,$msg) {
		$this->db->where('id',$id);
		return $this->db->update('match',array('u1_msg'=>$msg));
	}
	// update message of player 2
	function updateMsgU2($id,$msg) {
		$this->db->where('id',$id);
		return $this->db->update('match',array('u2_msg'=>$msg));
	}
	// update match status
	function updateStatus($id, $status) {
		$this->db->where('id',$id);
		return $this->db->update('match',array('match_status_id'=>$status));
	}
	// update board state
	function updateBoardState($id, $data){
		$this->db->where('id',$id);
		// serialize the data so it can pushed into the blob field
		$blob = serialize($data);
		return $this->db->update('match',array('board_state'=>$blob));
	}
}
?>
