<?php
class Vari
{
    public $id;
    public $email;
    public $password;
    public $file_id;
    public $owner_id;
    public $file_path;
    public $file_name;
    public $share_id;
    public $public;
    public $rep_id;
    public $active;

    function __construct($data=null) {
        if (is_array($data)) {
            if (isset($data['id'])) $this->id = $data['id'];

            $this->email = $data['email'];
            $this->password = $data['password'];
            $this->file_id = $data['file_id'];
            $this->owner_id = $data['owner_id'];
            $this->file_path = $data['file_path'];
            $this->file_name = $data['file_name'];
            $this->share_id = $data['share_id'];
            $this->public = $data['public'];
            $this->rep_id = $data['rep_id'];
            $this->active = $data['active'];
        }
    }

    public function __toString() {
        return $this->id." ".$this->email." ".$this->password." ".$this->file_id." ".$this->owner_id." 
            ".$this->file_path." ".$this->file_name." ".$this->share_id." ".$this->public." ".$this->rep_id." ".$this->active;

    }
}