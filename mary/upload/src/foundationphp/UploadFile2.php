<?php
namespace foundationphp;

class UploadFile
{
    //Klasseneigenschaften wurden auf protected gesetzt, damit der Zugang auf Elternklassen und abgeleitete Klassen
    //beschränkt wird; private würde es zu sehr einschränken, während public wiederum nicht sicher wäre
    protected $destination;
    protected $messages = array();
    //2MB ist die maximale Größe, die eine Datei haben darf, um hochgeladen zu werden
    protected $maxSize = 2000000;
    protected $permittedTypes = array(
        'image/jpeg',
        'image/pjpeg',
        'image/gif',
        'image/png',
        'image/webp'
    );
    protected $newName;
    protected $typeCheckingOn = true;
    protected $notTrusted = array('bin', 'cgi', 'exe', 'js', 'pl', 'php5', 'php', 'py', 'sh');
    protected $suffix = '.upload';
    protected $renameDuplicates;

//KOnstruktor wird bei jedem new UploadFile aufgerufen; die verpflichtenden Parameter sind $uploadFolder und $DB_con
    public function __construct($uploadFolder, $DB_con)
    {
        //er fragt ab, ob der Ordner auf dem Server existiert und
        //ob er writable ist -> wenn nicht, kommt eine Fehlermeldung
        if (!is_dir($uploadFolder) || !is_writable($uploadFolder)) {
            throw new \Exception("$uploadFolder must be a valid, writable folder.");
        }
        //diese Schleife checkt, ob das letzte Zeichen des Strings von $uploadFolder ein Backslash ist;
        //wenn nicht, wird dort einer angefügt, damit man später nur noch beoispielseise die User-ID anfügen muss,
        //um neue Ordner erstellen zu können
        if ($uploadFolder[strlen($uploadFolder) - 1] != '/') {
            $uploadFolder .= '/';
        }
        //hier erfolgt der Methodenaufruf für jede neue UploadFile
        $this->destination = $uploadFolder;
        $this->db = $DB_con;
    }

//checken, ob die hochzuladende Datei die festgelegte Größe im Server überschreitet
    public function setMaxSize($bytes)
    {
        $serverMax = self::convertToBytes(ini_get('upload_max_filesize'));
        if ($bytes > $serverMax) {
            throw new \Exception('Maximum size cannot exceed server limit for individual files: ' .
                self::convertFromBytes($serverMax));
        }
        if (is_numeric($bytes) && $bytes > 0) {
            $this->maxSize = $bytes;
        }
    }
//kontrolliert den letzten Buchstaben der Datei und leitet dann einen fallthrough switch case (also eines ohne breaks) ein;
//ist der letzte Buchstabe ein k, sprich Kilobyte, wird der Wert einmal mit 1024 multipliziert, um ihn in Bytes umwandeln zu können usw.
    public static function convertToBytes($val)
    {
        $val = trim($val);
        $last = strtolower($val[strlen($val) - 1]);
        if (in_array($last, array('g', 'm', 'k'))) {
            // Explicit cast to number
            $val = (float)$val;
            switch ($last) {
                case 'g':
                    $val *= 1024;
                case 'm':
                    $val *= 1024;
                case 'k':
                    $val *= 1024;
            }
        }
        return $val;
    }

    public static function convertFromBytes($bytes)
    {
        $bytes /= 1024;
        if ($bytes > 1024) {
            return number_format($bytes / 1024, 1) . ' MB';
        } else {
            return number_format($bytes, 1) . ' KB';
        }
    }

    public function allowAllTypes($suffix = null)
    {
        $this->typeCheckingOn = false;
        if (!is_null($suffix)) {
            if (strpos($suffix, '.') === 0 || $suffix == '') {
                $this->suffix = $suffix;
            } else {
                $this->suffix = ".$suffix";
            }
        }
    }

//$uploaded ist das letzte in dem Array initialisierte Element und soll nun ausgewählt und kontrolliert werden
    public function upload($renameDuplicates = true)
    {
        $this->renameDuplicates = $renameDuplicates;
        $uploaded = current($_FILES);
        if (is_array($uploaded['name'])) {
            foreach ($uploaded['name'] as $key => $value) {
                $currentFile['name'] = $uploaded['name'][$key];
                $currentFile['type'] = $uploaded['type'][$key];
                $currentFile['tmp_name'] = $uploaded['tmp_name'][$key];
                $currentFile['error'] = $uploaded['error'][$key];
                $currentFile['size'] = $uploaded['size'][$key];
                if ($this->checkFile($currentFile)) {
                    $this->moveFile($currentFile);
                }
            }
        } else {
            if ($this->checkFile($uploaded)) {
                $this->moveFile($uploaded);
            }
        }
    }

    public function getMessages()
    {
        return $this->messages;
    }

    protected function checkFile($file)
    {
        if ($file['error'] != 0) {
            $this->getErrorMessage($file);
            return false;
        }
        if (!$this->checkSize($file)) {
            return false;
        }
        if ($this->typeCheckingOn) {
            if (!$this->checkType($file)) {
                return false;
            }
        }
        $this->checkName($file);
        return true;
    }

    protected function getErrorMessage($file)
    {
        switch ($file['error']) {
            case 1:
            case 2:
                $this->messages[] = $file['name'] . ' is too big: (max: ' .
                    self::convertFromBytes($this->maxSize) . ').';
                break;
            case 3:
                $this->messages[] = $file['name'] . ' was only partially uploaded.';
                break;
            case 4:
                $this->messages[] = 'No file submitted.';
                break;
            default:
                $this->messages[] = 'Sorry, there was a problem uploading ' . $file['name'];
                break;
        }
    }

//hier werden verschiedene Szenarien bezüglich der Dateigröße kontrolliert und die passende Meldung angezeigt
    protected function checkSize($file)
    {
        if ($file['size'] == 0) {
            $this->messages[] = $file['name'] . ' is empty.';
            return false;
        } elseif ($file['size'] > $this->maxSize) {
            $this->messages[] = $file['name'] . ' exceeds the maximum size for a file ('
                . self::convertFromBytes($this->maxSize) . ').';
            return false;
        } else {
            return true;
        }
    }

    protected function checkType($file)
    {
        if (in_array($file['type'], $this->permittedTypes)) {
            return true;
        } else {
            $this->messages[] = $file['name'] . ' is not permitted type of file.';
            return false;
        }
    }

//checked den Namen der Datei und ersetzt die Leerzeichen durch Unterstriche
    protected function checkName($file)
    {
        $this->newName = null;
        $nospaces = str_replace(' ', '_', $file['name']);
        if ($nospaces != $file['name']) {
            $this->newName = $nospaces;
        }
        $nameparts = pathinfo($nospaces);
        //die Endung wird geprüft: Falls die Endung einer unerlaubten entspricht oder keine Endung vorhanden ist, wird
        //der Datei sie Endung .upload hinzugefügt
        $extension = isset($nameparts['extension']) ? $nameparts['extension'] : '';
        if (!$this->typeCheckingOn && !empty($this->suffix)) {
            if (in_array($extension, $this->notTrusted) || empty($extension)) {
                $this->newName = $nospaces . $this->suffix;
            }
        }
        //wenn der Name der Datei feststeht, wird der Ordner auf alle Dateien geprüft;  existiert bereits eine Datei mit demselben
        //Namen wird der Datei ein Unterstrich und die nächthöhere Zahl angefügt;
        if ($this->renameDuplicates) {
            $name = isset($this->newName) ? $this->newName : $file['name'];
            $existing = scandir($this->destination);
            if (in_array($name, $existing)) {
                $i = 1;
                do {
                    $this->newName = $nameparts['filename'] . '_' . $i++;
                    if (!empty($extension)) {
                        $this->newName .= ".$extension";
                    }
                    if (in_array($extension, $this->notTrusted)) {
                        $this->newName .= $this->suffix;
                    }
                } while (in_array($this->newName, $existing));
            }
        }
    }

    protected function moveFile($file)
    {
        //? : ist if, dann else - Abfrage, weil der newName nur benutzt wird, wenn der File renamed wird
        $filename = isset($this->newName) ? $this->newName : $file['name'];
        $owner_id = $_SESSION["user_session"];
        if (!is_dir($this->destination. $owner_id)) {
            mkdir($this->destination. $owner_id, 0777);
        }
        if (!is_dir($this->destination .'/up')) {
            mkdir($this->destination . '/up', 0777);
        }
        $success = move_uploaded_file($file['tmp_name'], $this->destination . $owner_id . '/up' . $filename);
        $file_path = $this->destination;
        if ($success) {
            $result = $file['name'] . ' was uploaded successfully';
            try {
                $stmt = $this->db->prepare("INSERT INTO files (owner_id, file_path, file_name) VALUES (:owner_id, :file_path, :file) ");
                $stmt->bindParam(':owner_id', $owner_id);
                $stmt->bindParam(':file_path', $file_path);
                $stmt->bindParam(':file', $filename);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage() . "<br>";
                die();
            }

            if (!is_null($this->newName)) {
                $result .= ', and was renamed ' . $this->newName;
            }
            $result .= '.';
            $this->messages[] = $result;
        } else {
            $this->messages[] = 'Could not upload ' . $file['name'];
        }
    }

    public function downloadFile($file)
    {

        $filename = $file['name'];
        $owner_id = $_SESSION["user_session"];
        $file_path = $this->destination . $owner_id . '/' . $filename;

        try {
            $stmt = $this->db->prepare("SELECT FROM files (owner_id, file_path, file_name) VALUES (:owner_id, :file_path, :file) ");
            $stmt->bindParam(':owner_id', $owner_id);
            $stmt->bindParam(':file_path', $file_path);
            $stmt->bindParam(':file', $filename);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage() . "<br>";
            die();
        }

        if (file_exists($file_path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            flush(); // Flush system output buffer
            readfile($file_path);
            exit;

        }
    }
}