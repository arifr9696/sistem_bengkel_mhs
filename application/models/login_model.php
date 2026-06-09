<?php
class Login_model extends CI_Model {

    public function getUser($username)
    {
        $query = $this->db->query(
            "SELECT * FROM user WHERE username = '" . $username . "' "
        )->row_array();
        return $query;
    }

}