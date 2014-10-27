<?php

class Comments_model extends MY_Model {

    protected function array_delete($array, $element) {
        return array_diff($array, [$element]);
    }

    public function by_user_id($user_id, $for_user = true) {
        $from_for_user = ($for_user) ? 'user_for_id' : 'user_from_id';
        $query = $this->db->query("SELECT users_comments.*, users.username AS username_from FROM users_comments JOIN users WHERE $from_for_user = $user_id AND users.id = users_comments.user_from_id ORDER BY time ASC");
        $comments = array();
        foreach ($query->result() as $row)
            $comments[$row->id] = $row;
        return $comments;
    }

    public function add_comment($user_from_id, $user_for_id, $comment_text) {
        $user_from_id = mysql_real_escape_string($user_from_id);
        $user_for_id = mysql_real_escape_string($user_for_id);
        $comment_text = mysql_real_escape_string($comment_text);
        
        $time = (new DateTime())->getTimestamp();
        $query = $this->db->query("INSERT INTO users_comments (user_from_id, user_for_id, time, text) VALUES ($user_from_id, $user_for_id, $time, '$comment_text')");
    }
}
