<?php

class User extends DatabaseObject
{

    static protected $table_name = "";
    static protected $db_columns = ['id', 'vorname', 'nachname', 'email', 'username', 'hashed_password'];

    public $id;
    public $vorname;
    public $nachname;
    public $email;
    public $username;
    protected $hashed_password;
    public $password;
    public $confirm_password;
    protected $password_required = true;

    public function __construct($args=[]) {
        $this->vorname = $args['vorname'] ?? '';
        $this->nachname = $args['nachname'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->username = $args['username'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->confirm_password = $args['confirm_password'] ?? '';
    }

    public function full_name() {
        return $this->vorname . " " . $this->nachname;
    }

    protected function set_hashed_password() {
        $this->hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function verify_password($password) {
        return password_verify($password, $this->hashed_password);
    }

    protected function create() {
        $this->set_hashed_password();
        return parent::create();
    }

    protected function update() {
        if($this->password != '') {
            $this->set_hashed_password();
        } else {
            $this->password_required = false;
        }
        return parent::update();
    }

    protected function validate() {
        $this->errors = [];

        if(is_blank($this->vorname)) {
            $this->errors[] = "Der Vorname muss ausgefüllt werden.";
        } elseif (!has_length($this->vorname, array('min' => 2, 'max' => 255))) {
            $this->errors[] = "Der Vorname muss zwischen 2 und 255 Zeichen haben.";
        }

        if(is_blank($this->nachname)) {
            $this->errors[] = "Der Nachname muss ausgefüllt werden.";
        } elseif (!has_length($this->nachname, array('min' => 2, 'max' => 255))) {
            $this->errors[] = "Der Nachname muss zwischen 2 und 255 Zeichen haben.";
        }

        if(is_blank($this->email)) {
            $this->errors[] = "Die Email-Adresse muss ausgefüllt werden.";
        } elseif (!has_length($this->email, array('min' => 2, 'max' => 255))) {
            $this->errors[] = "Die Email-Adresse muss zwischen 2 und 255 Zeichen haben.";
        } elseif (!has_valid_email_format($this->email)) {
            $this->errors[] = "Die Email-Adresse hat kein gültiges Format ";
        }

        if(is_blank($this->username)) {
            $this->errors[] = "Der User muss ausgefüllt werden.";
        } elseif (!has_length($this->username, array('min' => 2, 'max' => 255))) {
            $this->errors[] = "Der Username muss zwischen 2 und 255 Zeichen haben.";
        } elseif (!has_unique_username($this->username, $this->id ?? 0)) {
            $this->errors[] = "Der Username ist bereits vergeben! Versuche einen anderen.";
        }

        if($this->password_required) {
            if (is_blank($this->password)) {
                $this->errors[] = "Das Passwort muss ausgefüllt werden.";
            } elseif (!has_length($this->password, array('min' => 12))) {
                $this->errors[] = "Das Passwort muss auf 12 oder mehr Zeichen bestehen.";
            } elseif (!preg_match('/[A-Z]/', $this->password)) {
                $this->errors[] = "Das Passwort muss min. einen Großbuchstaben beinhalten.";
            } elseif (!preg_match('/[a-z]/', $this->password)) {
                $this->errors[] = "Das Passwort muss min. einen Kleinbuchstaben beinhalten.";
            } elseif (!preg_match('/[0-9]/', $this->password)) {
                $this->errors[] = "Das Passwort muss min. eine Zahl beinhalten.";
            } elseif (!preg_match('/[^A-Za-z0-9\s]/', $this->password)) {
                $this->errors[] = "Das Passwort muss min. ein Sonderzeichen beinhalten.";
            }

            if(is_blank($this->confirm_password)) {
                $this->errors[] = "Die Password Wiederholung muss ausgefüllt werden.";
            } elseif ($this->password !== $this->confirm_password) {
                $this->errors[] = "Die Passwörter müssen übereinstimmen.";
            }


        }

        return $this->errors;
    }

    static public function find_by_username($username) {
        $sql = "SELECT * FROM " . static::$table_name . " ";
        $sql .= "WHERE username='" . self::$database->escape_string($username) . "'";
        $obj_array = static::find_by_sql($sql);
        if(!empty($obj_array)) {
            return array_shift($obj_array);
        } else {
            return false;
        }
    }

}