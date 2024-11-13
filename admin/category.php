<?php include("header.php"); ?>
<div class="container mt-5">
    <h3>Category</h3>
    
    <?php 
        if(isset($_POST['btnsave'])){
            $target_dir = "category_image/";
            $target_file = $target_dir . basename($_FILES["fileupload"]["name"]);
            $title = $_POST['txttitle'];
            $filename = $_FILES["fileupload"]["name"];

            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check file extension
            if(!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])){  
                echo '<div class="alert alert-warning">Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>';
                $uploadOk = 0;
            }

            // Check file size (limit to 500KB)
            if ($_FILES["fileupload"]["size"] > 500000) {
                echo '<div class="alert alert-warning">Sorry, your file is too large. Maximum size is 500KB.</div>';
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                echo '<div class="alert alert-warning">Sorry, file already exists.</div>';
                $uploadOk = 0;
            }

            // Attempt file upload if all checks pass
            if($uploadOk == 1){
                if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file)) {
                    $sql = "INSERT INTO categorys (cat_title, picture) VALUES ('".$title."', '".$filename."')";
                    $result = $conn->query($sql);

                    if($result){
                        echo '<div class="alert alert-success">Category uploaded successfully. Thank you!</div>';
                    } else {
                        echo '<div class="alert alert-danger">Error: ' . $conn->error . '</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger">Sorry, there was an error uploading your file.</div>';
                }
            }
        }
    ?>

    <!-- Form to Add Category -->
    <form action="" method="post" enctype="multipart/form-data" class="mt-4">
        <div class="mb-3">
            <label for="fileupload" class="form-label">Image</label>
            <input type="file" class="form-control" id="fileupload" name="fileupload" required>
        </div>
        
        <div class="mb-3">
            <label for="txttitle" class="form-label">Title</label>
            <input type="text" class="form-control" id="txttitle" name="txttitle" required>
        </div>
        
        <button type="submit" name="btnsave" class="btn btn-primary">Save</button>
    </form>

    <hr/>

    <!-- Display Categories Table -->
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Image</th>
                <th scope="col">Title</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "SELECT * FROM categorys";
                $result = $conn->query($sql);
                if($result && $result->num_rows > 0){
                    while($row = $result->fetch_object()){
                        $id = $row->catid;
                        $title = $row->cat_title;
                        $pict = $row->picture;
                        echo "<tr>
                                <td>$id</td>
                                <td><img src='category_image/$pict' width='100px' class='img-thumbnail'></td>
                                <td>$title</td>
                                <td><a href='delete_category.php?id=$id' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this category?');\">Delete</a></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No categories found.</td></tr>";
                }
            ?>
        </tbody>
    </table>
</div>
<?php include("footer.php"); ?>
