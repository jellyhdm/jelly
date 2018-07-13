<?php
include_once '../../private/includes/dbconfig.php';
include_once '../../private/includes/session.php';


function get_folder_size($folder_name)
{
    $total_size = 0;
    $file_data = scandir($folder_name);
    foreach($file_data as $file)
    {
        if($file === '.' or $file === '..')
        {
            continue;
        }
        else
        {
            $path = $folder_name . '/' . $file;
            $total_size = $total_size + filesize($path);
        }
    }
    return format_folder_size($total_size);
}

if(isset($_POST["action"]))
{
    if($_POST["action"] == "fetch")
    {
        $folder = array_slice((scandir($owner_id.'/')),2);

        $output = '
  <table class="table table-bordered table-striped">
   <tr>
    <th>Ordner</th>
    <th>Umbenennen</th>
    <th>Ordner löschen</th>
    <th>Dateien anschauen</th>
   </tr>
   ';

        if(count($folder) > 0)
        {
            foreach($folder as $name)
            {
       $output .= '   
                
                    
     <tr>
      <td>' . $name . '</td>
      <td><button type="button" name="update" data-name="' . $name . '" class="update btn btn-warning btn-xs">Umbenennen</button></td>
      <td><button type="button" name="delete" data-name="' . $name . '" class="delete btn btn-danger btn-xs">Löschen</button></td>
      <td><button type="button" name="view_files" data-name="' . $name . '" class="view_files btn btn-default btn-xs">Dateien anschauen</button></td>
     </tr>';

            }
        }
        else
        {
            $output .= '
    <tr>
     <td colspan="6">No Folder Found</td>
    </tr>
   ';
        }
        $output .= '</table>';
        echo $output;
    }



    if(isset($_POST["action"])) {
        if ($_POST["action"] == "fetch_files1") {
            $file1 = array_slice((scandir($owner_id.'/')),2);

            $output = '
  <table class="table table-bordered table-striped">
   <tr>
    <th>Dateien</th>
    <th>In Ordner verschieben</th>
    <th>Teilen</th>
    <th>Löschen</th>
   </tr>
   ';

            if (count($file1) > 0) {
                foreach ($file1 as $name1) {
                    $stmt= $DB_con->prepare(SELECT `file_id` FROM `files` WHERE `file_name`
                    $output .= '
     <tr>
  
      <td>'.$name1.'</td>
      <td><button type="button" name="change_file_name" data-name="' . $name1 . '" class="rename btn btn-info btn-xs">Verschieben</button></td>
      <td><button type="button" name="share" data-name="' . $name1 . '" class="share btn btn-default btn-xs">Teilen</button></td>
      <td><button type="button" name="remove_file" data-name="' . $name1 . '" class="remove_file btn btn-danger btn-xs" id="'.$path.'">Löschen</button></td>
     </tr>';
                }
            } else {
                $output .= '
    <tr>
     <td colspan="6">No Folder Found</td>
    </tr>
   ';
            }
            $output .= '</table>';
            echo $output;
        }
    }


    if($_POST["action"] == "create")
    {
        if(!file_exists($_POST["folder_name"]))
        {
            mkdir($owner_id.'/'.($_POST["folder_name"]), 0777, true);
            echo 'Folder Created';
        }
        else
        {
            echo 'Folder Already Created';
        }
    }
    if($_POST["action"] == "change")
    {
        if(!file_exists($_POST["folder_name"]))
        {
            rename($_POST["old_name"], $_POST["folder_name"]);
            echo 'Folder Name Change';
        }
        else
        {
            echo 'Folder Already Created';
        }
    }

    if($_POST["action"] == "delete")
    {
        $files = scandir($_POST["folder_name"]);
        foreach($files as $file)
        {
            if($file === '.' or $file === '..')
            {
                continue;
            }
            else
            {
                unlink($_POST["folder_name"] . '/' . $file);
            }
        }
        if(rmdir($_POST["folder_name"]))
        {
            echo 'Folder Deleted';
        }
    }

    if($_POST["action"] == "fetch_files")
    {
        $file_data = scandir($_POST["folder_name"]);
        $output = '
  <table class="table table-bordered table-striped">
   <tr>
    <th>Image</th>
    <th>File Name</th>
    <th>Delete</th>
   </tr>
  ';

        foreach($file_data as $file)
        {
            if($file === '.' or $file === '..')
            {
                continue;
            }
            else
            {
                $path = $_POST["folder_name"] . '/' . $file;
                $output .= '
    <tr>
     <td><img src="'.$path.'" class="img-thumbnail" height="50" width="50" /></td>
     <td contenteditable="true" data-folder_name="'.$_POST["folder_name"].'"  data-file_name = "'.$file.'" class="change_file_name">'.$file.'</td>
     <td><button name="remove_file" class="remove_file btn btn-danger btn-xs" id="'.$path.'">Remove</button></td>
    </tr>
    ';
            }
        }
        $output .='</table>';
        echo $output;
    }


    //Delete FILE


    if($_POST["action"] == "remove_file")
    {
        if(file_exists($_POST["path"]))
        {
            $stmt = $DB_con->prepare("DELETE * FROM `files` WHERE file_id=:file_id");
            $stmt->execute(array(":file_id"=>$userRow["file_id"]));
            $userRowFile=$stmt3->fetch(PDO::FETCH_ASSOC);
            unlink($_POST["path"]);
            echo 'Datei gelöscht';
        }
    }


    if($_POST["action"] == "change_file_name")
    {
        if(!file_exists($_POST["folder_name"]))
        {
            rename($_POST["old_name"], $_POST["folder_name"]);
            echo 'Folder Name Change';
        }
        else
        {
            echo 'Folder Already Created';
        }
    }

    if($_POST["action"] == "change_file_name")
    {
        try {
            $stmt =$DB_con->prepare('
            UPDATE files
            SET file_name = :file_name, file_path = :file_path, owner_id = :owner_id
            WHERE file_id = :file_id
            ');
            $stmt->bindParam(':file_name', $file_name);
            $stmt->bindParam(':file_path', $file_path);
            $stmt->bindParam(':owner_id', $owner_id);
            $stmt->bindParam(':file_id', $file_id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo("Fehler! Bitten wenden Sie sich an den Administrator...<br>" . $e->getMessage() . "<br>");
            die();
        }
        $old_name = $_POST["folder_name"] . '/' . $_POST["old_file_name"];
        $new_name = $_POST["folder_name"] . '/' . $_POST["new_file_name"];
        if(rename($old_name, $new_name))
        {
            echo 'File name change successfully';
        }
        else
        {
            echo 'There is an error';
        }
    }
}
?>