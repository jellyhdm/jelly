<?php
include_once '../private/includes/dbconfig.php';
if(!$user->is_loggedin())
{
    $user->redirect('index.php');
}
$id = $_SESSION['user_session'];
$stmt = $DB_con->prepare("SELECT * FROM users WHERE id=:id");
$stmt->execute(array(":id"=>$id));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
$owner_id = $_SESSION['user_session'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="jelly, maria barbulovic, steffi dinies, carina gierth">
    <title>jelly</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <!-- BootstrapCSS-->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- FontAwesome-->
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    <!-- Stylesheet für jelly-->
    <link href="css/style2.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<!-- Navigation-->
<?php
include_once 'nav.php'?>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Home</a>
            </li>
            <li class="breadcrumb-item active">Deine Dateien</li>
        </ol>
        <h1>Übersicht</h1>
        <hr>
        <p>Hallo <?php echo $_SESSION['user_session'] ?><br>Dies ist die Übersichtsseite, mit der der Nutzer starten wird. </p>
        <!-- Leeres DIV um der Seite größe zu geben-->
        <div align="right">
            <button type="button" name="upload" id="upload_file" data-name="<?php $name ?>" class="upload btn btn-success">Datei hochladen</button>
        </div>
<!-- Aufruf bzw Einbindung der Aktionen-->

        <div class="table-responsive" id="file_table">


        </div>
        <!--folder_table-->

    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
        <div class="container">
            <div class="text-center">
                <small>Copyright © jelly 2018</small>
            </div>
        </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ist es Zeit zu gehen?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Möchtest du dich wirklich ausloggen? Dann klicke auf Logout.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Abbrechen</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="jquery/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="jquery-easing/jquery.easing.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/jelly2.js"></script>
    <!-- Custom scripts for this page-->


</div>
</body>

</html>

<div id="folderModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span id="change_title">Create Folder</span></h4>
            </div>
            <div class="modal-body">
                <p>Enter Folder Name
                    <input type="text" name="folder_name" id="folder_name" class="form-control" /></p>
                <br />
                <input type="hidden" name="action" id="action" />
                <input type="hidden" name="old_name" id="old_name" />
                <input type="button" name="folder_button" id="folder_button" class="btn btn-info" value="Create" />

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="uploadModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Upload File</h4>
            </div>
            <div class="modal-body">
                <?php include_once '../upload/form.php' ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="filelistModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">File List</h4>
            </div>
            <div class="modal-body" id="file_list">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

        load_folder_list();
        load_folder_list2();

        function load_folder_list()
        {
            var action = "fetch";
            $.ajax({
                url:"../upload/uploaded/action.php",
                method:"POST",
                data:{action:action},
                success:function(data)
                {
                    $('#folder_table').html(data);
                }
            });
        }


        function load_folder_list2()
        {
            var action = "fetch_files1";
            $.ajax({
                url:"../upload/uploaded/action.php",
                method:"POST",
                data:{action:action},
                success:function(data)
                {
                    $('#file_table').html(data);
                }
            });
        }

        $(document).on('click', '#create_folder', function(){
            $('#action').val("create");
            $('#folder_name').val('');
            $('#folder_button').val('Create');
            $('#folderModal').modal('show');
            $('#old_name').val('');
            $('#change_title').text("Create Folder");
        });

        $(document).on('click', '#folder_button', function(){
            var folder_name = $('#folder_name').val();
            var old_name = $('#old_name').val();
            var action = $('#action').val();
            if(folder_name != '')
            {
                $.ajax({
                    url:"../upload/uploaded/action.php",
                    method:"POST",
                    data:{folder_name:folder_name, old_name:old_name, action:action},
                    success:function(data)
                    {
                        $('#folderModal').modal('hide');
                        load_folder_list();
                        alert(data);
                    }
                });
            }
            else
            {
                alert("Enter Folder Name");
            }
        });

        $(document).on("click", ".update", function(){
            var folder_name = $(this).data("name");
            $('#old_name').val(folder_name);
            $('#folder_name').val(folder_name);
            $('#action').val("change");
            $('#folderModal').modal("show");
            $('#folder_button').val('Update');
            $('#change_title').text("Change Folder Name");
        });

        $(document).on("click", ".delete", function(){
            var folder_name = $(this).data("name");
            var action = "delete";
            if(confirm("Are you sure you want to remove it?"))
            {
                $.ajax({
                    url:"../upload/uploaded/action.php",
                    method:"POST",
                    data:{folder_name:folder_name, action:action},
                    success:function(data)
                    {
                        load_folder_list();
                        alert(data);
                    }
                });
            }
        });

        $(document).on('click', '.upload', function(){
            var folder_name = $(this).data("name");
            $('#hidden_folder_name').val(folder_name);
            $('#uploadModal').modal('show');
        });

        $('#upload_form').on('submit', function(){
            $.ajax({
                url:"test/upload.php",
                method:"POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(data)
                {
                    load_folder_list();
                    alert(data);
                }
            });
        });

        $(document).on('click', '.view_files', function(){
            var folder_name = $(this).data("name");
            var action = "fetch_files";
            $.ajax({
                url:"../upload/uploaded/action.php",
                method:"POST",
                data:{action:action, folder_name:folder_name},
                success:function(data)
                {
                    $('#file_list').html(data);
                    $('#filelistModal').modal('show');
                }
            });
        });

        $(document).on('click', '.remove_file', function(){
            var path = $(this).attr("id");
            var action = "remove_file";
            if(confirm("Are you sure you want to remove this file?"))
            {
                $.ajax({
                    url:"../upload/uploaded/action.php",
                    method:"POST",
                    data:{path:path, action:action},
                    success:function(data)
                    {
                        alert(data);
                        $('#filelistModal').modal('hide');
                        load_folder_list();
                    }
                });
            }
        });

        $(document).on('click', '.share_file', function(){
            var path = $(this).attr("id");
            var action = "download_file";
            $.ajax({
                url:"../upload/uploaded/action.php",
                method:"POST",
                data:{path:path, action:action},
                success:function(data)
                {
                    alert(data);
                }
            });
        });

        $(document).on('click', '.download_file', function(){
            var path = $(this).attr("id");
            var action = "download_file";
            $.ajax({
                url:"../upload/uploaded/action.php",
                method:"POST",
                data:{path:path, action:action},
                success:function(data)
                {
                    alert(data);
                }
            });
        });

        $(document).on('blur', '.change_file_name', function(){
            var folder_name = $(this).data("folder_name");
            var old_file_name = $(this).data("file_name");
            var new_file_name = $(this).text();
            var action = "change_file_name";
            $.ajax({
                url:"../upload/uploaded/action.php",
                method:"POST",
                data:{folder_name:folder_name, old_file_name:old_file_name, new_file_name:new_file_name, action:action},
                success:function(data)
                {
                    alert(data);
                }
            });
        });

    });
</script>