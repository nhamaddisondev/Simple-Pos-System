<?php include("header.php"); ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="text-center">Product List</h3>
            <div class="text-end mb-3">
                <a href="cart.php" class="btn btn-info btn-sm">View Cart</a>
                <a href="add_product.php" class="btn btn-success btn-sm">Add Product</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered mt-3" id="tblproduct">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Code</th>
                            <th scope="col">Picture</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include("../connection.php");
                        $sql = "SELECT * FROM products";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_object()) {
                                $id = $row->proid;
                                $code = $row->code;
                                $proname = $row->proname;
                                $price = $row->price;
                                $picture = $row->picture;

                                echo "<tr>
                                    <td>{$id}</td>
                                    <td>{$code}</td>
                                    <td><img src=\"products_image/{$picture}\" class=\"img-thumbnail\" width=\"100\"></td>
                                    <td>{$proname}</td>
                                    <td>{$price}</td>
                                    <td>
                                        <button type='button' class='buy btn btn-primary btn-sm' data-id='{$id}' data-name='{$proname}' data-price='{$price}'>Add to Cart</button>
                                        <a href='edit_product.php?id={$id}' class='btn btn-warning btn-sm'>Edit</a>
                                        <button type='button' class='del btn btn-danger btn-sm' data-id='{$id}'>Delete</button>
                                    </td>
                                </tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// JavaScript for "Add to Cart" functionality
$(document).ready(function () {
    let cart = JSON.parse(localStorage.getItem('cart')) || {};

    $('.buy').click(function () {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let price = parseFloat($(this).data('price'));

        if (cart[id]) {
            cart[id].qty += 1;
        } else {
            cart[id] = { name, price, qty: 1 };
        }

        // Save cart to local storage
        localStorage.setItem('cart', JSON.stringify(cart));
        alert(`${name} added to cart!`);
    });
});
</script>

<?php include("footer.php"); ?>