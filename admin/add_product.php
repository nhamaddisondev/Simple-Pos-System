<?php include("header.php"); ?>
<div class="container mt-5">
    <h3>Add Product (<a href="product.php">Back</a>)</h3>
    <?php 
        if(isset($_POST['btnsave'])){
            $code = $_POST['txtcode'];
            $title = $_POST['txttitle'];
            $filename = $_FILES['fileupload']["name"];
            $slcategory = $_POST["slcategory"];
            $price = $_POST["txtprice"];

            $target_file = "products_image/".$filename;

            // Check if file is uploaded successfully
            if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file)) {          
                $sql = "INSERT INTO products SET 
                            code='".$code."',
                            proname='".$title."',
                            catid='".$slcategory."',
                            price='".$price."',
                            picture='".$filename."'";
                $result = $conn->query($sql);
                
                if($result){
                    echo '<div class="alert alert-success">Product uploaded successfully. Thank you!</div>';
                } else {
                    echo '<div class="alert alert-danger">Error: ' . $conn->error . '</div>';
                }

            } else {
                echo '<div class="alert alert-warning">Sorry, there was an error uploading your file.</div>';
            }
        }
    ?>

    <form action="" method="post" enctype="multipart/form-data" class="mt-4">
        <div class="mb-3">
            <label for="txtcode" class="form-label">Code</label>
            <input type="text" class="form-control" id="txtcode" name="txtcode" required>
        </div>
        
        <div class="mb-3">
            <label for="txttitle" class="form-label">Title</label>
            <input type="text" class="form-control" id="txttitle" name="txttitle" required>
        </div>
        
        <div class="mb-3">
            <label for="txtprice" class="form-label">Price</label>
            <input type="text" class="form-control" id="txtprice" name="txtprice" required>
        </div>
        
        <div class="mb-3">
            <label for="fileupload" class="form-label">Picture</label>
            <input type="file" class="form-control" id="fileupload" name="fileupload" required>
        </div>
        
        <div class="mb-3">
            <label for="slcategory" class="form-label">Category</label>
            <select class="form-select" id="slcategory" name="slcategory" required>
                <option value="0">Select category</option>
                <?php 
                    $sql = "SELECT * FROM categorys";
                    $result = $conn->query($sql);
                    if($result && $result->num_rows > 0){
                        while($row = $result->fetch_object()){
                            echo "<option value=\"{$row->catid}\">{$row->cat_title}</option>";
                        }
                    }
                ?>
            </select>
        </div>

        <button type="submit" name="btnsave" class="btn btn-primary">Save</button>
    </form>
</div>
<?php include("footer.php"); ?>
