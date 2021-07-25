<?php
//connect to database
//INSERT INTO `notes` (`sno`, `Title`, `Description`, `tstamp`) VALUES (NULL, 'Chemistry Homework', 'Chapter 9 workbook needs to be completed.', current_timestamp());
$servername="localhost";
$username="root";
$password="";
$database="notes";
$insert=false;
$update=false;
$delete=false;

$conn=mysqli_connect($servername,$username,$password,$database);

if(!$conn)
{
    die("Sorry! we failed to connect: ". mysqli_connect_error());
}

if(isset($_GET['delete']))
{
    $sno=$_GET['delete'];
  //  echo $sno;
    $delete=true;
      $sql="DELETE FROM `notes` WHERE `notes`.`sno` = $sno";
   // $sql="DELETE FROM `notes` WHERE `sno`=$sno";
    $result=mysqli_query($conn,$sql);
}


if($_SERVER['REQUEST_METHOD']=="POST")
{
    if(isset($_POST['snoEdit']))
    {
        //update note
        $sno=$_POST['snoEdit'];
        $title=$_POST['titleEdit'];
        $Description=$_POST['DescriptionEdit'];
        $sql="UPDATE `notes` SET `Title` = '$title' , `Description` = '$Description' WHERE `notes`.`sno` = $sno";
        $result=mysqli_query($conn,$sql);
        if($result)
        {
           $update=true;
        }
        else{
            echo 'error'.mysqli_error($conn);
        }
    }
    else{

    
    $title=$_POST['title'];
    $Description=$_POST['Description'];
    $sql="INSERT INTO `notes` (`Title`, `Description`) VALUES ('$title', '$Description')";
    $result=mysqli_query($conn,$sql);
    if($result)
    {
       // echo 'inserted successfully';
       $insert=true;
    }
    else{
        echo 'error'.mysqli_error($conn);
    }

}
}
        
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

    <title>Notes Manager</title>

</head>

<!--<body style="background-image: url(https://wallpaper-mania.com/wp-content/uploads/2018/09/High_resolution_wallpaper_background_ID_77700448994.jpg);">-->

<body>
    <!-- 
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
        Edit modal
    </button>-->

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/Notes_Manager/index.php" method="post">
                    <div class="modal-body">

                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="mb-3">
                            <label for="title" class="form-label">Note Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit"
                                aria-describedby="emailHelp">
                        </div>

                        <div class="mb-3">
                            <label for="Description" class="form-label">Note description</label>
                            <textarea class="form-control" id="DescriptionEdit" name="DescriptionEdit"
                                rows="3"></textarea>
                        </div>
                        <!-- <button type="submit" class="btn btn-primary">Update Note</button>-->

                    </div>
                    <div class="modal-footer d-block mr-auto">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img
                    src="https://dashboard.snapcraft.io/site_media/appmedia/2019/06/icon-512x512.png" height=48
                    width=48>Notes Manager </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact us</a>
                    </li>

                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <?php
    if($insert)
    {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Great!</strong> You have successfully inserted your note.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <?php
    if($update)
    {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Great!</strong> You have successfully updated your note.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <?php
    if($delete)
    {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Great!</strong> You have successfully deleted your note.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>

    <div class="container my-4">
        <h2>Add a note</h2>
        <form action="/Notes_Manager/index.php" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>

            <div class="mb-3">
                <label for="Description" class="form-label">Note description</label>
                <textarea class="form-control" id="Description" name="Description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>
    <div class="container my-4">

        <table class="table" id="myTable">

            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php      
        $sql="SELECT * FROM `notes` ";
        $result=mysqli_query($conn, $sql);
        $sno=0;
        while($row = mysqli_fetch_assoc($result))
        {
            $sno=$sno+1;
            echo '<tr>
                    <th scope="row">'.$sno.'</th>
                    <td>'.$row['Title'].'</td>
                    <td>'.$row['Description'].'</td>
                    <td><button class="edit btn btn sm btn-primary" id='.$row["sno"].'>Edit</button> <button class="delete btn btn sm btn-primary" id=d'.$row["sno"].'>Delete</button></td>
                </tr>';
           // echo $row['sno']. ".Title ".$row['Title']. "Description is  ". $row['Description'] ;
        }
        
        

 ?>

            </tbody>
        </table>

    </div>
    <hr>


    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS 
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>-->
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    </script>
    <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit ", );
            tr = e.target.parentNode.parentNode;
            title = tr.getElementsByTagName("td")[0].innerText;
            description = tr.getElementsByTagName("td")[1].innerText;
            console.log(title, description);
            titleEdit.value = title;
            DescriptionEdit.value = description;
            snoEdit.value = e.target.id;
            console.log(e.target.id);
            var myModal = new bootstrap.Modal(document.getElementById('editModal'), {
                keyboard: false
            })
            myModal.toggle();
        })
    })


    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit ", );
            sno = e.target.id.substr(1, );

            if (confirm("Are you sure you want to delete this note?")) {
                console.log("yes");
                window.location = `/Notes_Manager/index.php?delete=${sno}`; //get method 
                //make a form and use post request for security
            } else {
                console.log("no");
            }
        })
    })
    </script>


</body>

</html>