<?php


class USER
{

    private $db;

    public function __construct($DB_con)
    {
        $this->db = $DB_con;
    }


    public function register($email, $upass)
    {
        try {
            $password = password_hash($upass, PASSWORD_BCRYPT);
            $stmt = $this->db->prepare('INSERT INTO users (id, email, password) VALUES (NULL, :email, :upass)');
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":upass", $password);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

public function login($email,$upass)
{
    try
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email=:email LIMIT 1");
        $stmt->execute(array(':email'=>$email));
        $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0)
        {
            if(password_verify($upass, $userRow['password']))
            {
                $_SESSION['user_session'] = $userRow['id'];
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
}

public function is_loggedin()
{
    if(isset($_SESSION['user_session']))
    {
        return true;
    }
    return false;
}

public function redirect($url)
{
    header("Location: $url");
}

public function logout()
{
    session_destroy();
    unset($_SESSION['user_session']);
    return true;
}

}
?>

