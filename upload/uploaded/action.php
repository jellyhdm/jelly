<?php
//Datenbankaufbau & Abfrage ob User eingeloggt ist
include_once '../../private/includes/dbconfig.php';
if(!$user->is_loggedin())
{
    $user->redirect('index.php');
}
$id = $_SESSION['user_session'];
$stmt = $DB_con->prepare("SELECT * FROM users WHERE id=:id");
$stmt->execute(array(":id"=>$id));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
//Übergabe der user_session an $owner_id
$owner_id = $_SESSION['user_session'];


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
        $folder = array_filter(glob($owner_id.'/'.('*')), 'is_dir');

        $output = '
  <table class="table table-bordered table-striped">
   <tr>
    <th>Folder Name</th>
    <th>Update</th>
    <th>Delete</th>
    <th>Upload File</th>
    <th>View Uploaded File</th>
   </tr>
   ';
        if(count($folder) > 0)
        {
            foreach($folder as $name)
            {
                $output .= '
     <tr>
      <td>'.$name.'</td>
      <td><button type="button" name="update" data-name="'.$name.'" class="update btn btn-warning btn-xs">Update</button></td>
      <td><button type="button" name="delete" data-name="'.$name.'" class="delete btn btn-danger btn-xs">Delete</button></td>
      <td><button type="button" name="upload" data-name="'.$name.'" class="upload btn btn-info btn-xs">Upload File</button></td>
      <td><button type="button" name="view_files" data-name="'.$name.'" class="view_files btn btn-default btn-xs">View Files</button></td>
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
    <th>Download</th>
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
     <td><a href="'.$path.'" class="download_file" download>Download</button></td>
     <td><button name="remove_file" class="remove_file btn btn-danger btn-xs" id="'.$path.'">Remove</button></td>
    </tr>
    ';
            }
        }
        $output .='</table>';
        echo $output;
    }

    if($_POST["action"] == "remove_file")
    {
        if(file_exists($_POST["file"]))
        {
            unlink($_POST["path"]);
            echo 'File Deleted';
        }
    }

    if($_POST["action"] == "download_file")
    {
        if(file_exists($_POST["path"])) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($_POST["path"]) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            readfile($_POST["path"]);
            exit;
        }
    }

    if($_POST["action"] == "change_file_name")
    {
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
