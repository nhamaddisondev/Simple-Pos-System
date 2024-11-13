<?php include("header.php"); ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="text-center">Cart & Invoice</h3>
            <div class="mb-3">
                <label for="customerName" class="form-label">Customer Name:</label>
                <input type="text" id="customerName" class="form-control" placeholder="Enter Customer Name">
            </div>
            <table class="table table-bordered" id="tblorder">
                <thead class="table-light">
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="productlist">
                    <!-- Product items will be added here -->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end">Total</td>
                        <td><span id='total'>0.00</span></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end">Discount</td>
                        <td><input type="text" id='discount' class="form-control" style="width: 100px;"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end">Grand Total</td>
                        <td><input type="text" id='grandtotal' class="form-control" style="width: 100px;" readonly></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end">Paid</td>
                        <td><input type="text" id="totalPaid" class="form-control" style="width: 100px;"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end">Return</td>
                        <td><input type="text" id="totalReturn" class="form-control" style="width: 100px;" readonly></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <div class="text-center mt-3">
                <button type="button" class="btn btn-success" id="printAndSave">Print and Save</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    let cart = JSON.parse(localStorage.getItem('cart')) || {};
    let totalAmount = 0;

    // Load cart items
    $.each(cart, function (id, item) {
        let amount = item.price * item.qty;
        totalAmount += amount;

        $('#productlist').append(`
            <tr>
                <td>${item.name}</td>
                <td>${item.qty}</td>
                <td>${item.price.toFixed(2)}</td>
                <td>${amount.toFixed(2)}</td>
                <td><button class="btn btn-danger btn-sm remove-item" data-id="${id}">Remove</button></td>
            </tr>
        `);
    });

    $('#total').text(totalAmount.toFixed(2));

    // Remove item from cart
    $(document).on('click', '.remove-item', function () {
        let id = $(this).data('id');
        totalAmount -= cart[id].price * cart[id].qty;
        delete cart[id];
        localStorage.setItem('cart', JSON.stringify(cart));
        $(this).closest('tr').remove();
        $('#total').text(totalAmount.toFixed(2));
    });

    // Update totals, discounts, and grand total
    function updateTotals() {
        let discount = parseFloat($('#discount').val()) || 0;
        let grandTotal = totalAmount - discount;
        $('#grandtotal').val(grandTotal.toFixed(2));

        let paid = parseFloat($('#totalPaid').val()) || 0;
        let returnAmount = paid - grandTotal;
        $('#totalReturn').val(returnAmount.toFixed(2));
    }

    $('#discount').on('input', updateTotals);
    $('#totalPaid').on('input', updateTotals);

    // Print and save invoice with database entry
    $('#printAndSave').on('click', function () {
        let customerName = $('#customerName').val();
        let invoiceDetails = [];

        $('#productlist tr').each(function () {
            let itemName = $(this).find('td').eq(0).text();
            let qty = $(this).find('td').eq(1).text();
            let price = $(this).find('td').eq(2).text();
            let amount = $(this).find('td').eq(3).text();
            invoiceDetails.push({ itemName, qty, price, amount });
        });

        // AJAX call to save order to the database
        $.ajax({
            url: 'save_order.php',
            type: 'POST',
            data: {
                customerName: customerName,
                invoiceDetails: JSON.stringify(invoiceDetails),
                total: $('#total').text(),
                discount: $('#discount').val(),
                grandTotal: $('#grandtotal').val()
            },
            success: function (response) {
                alert(response); // Show success message
                // Print invoice logic
                let printContent = generateInvoiceContent(customerName, invoiceDetails);
                let printWindow = window.open('', '', 'height=600,width=800');
                printWindow.document.write('<html><head><title>Invoice</title></head><body>');
                printWindow.document.write(printContent);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();

                // Clear cart and reset fields
                clearCart();
            },
            error: function () {
                alert('Error saving order. Please try again.');
            }
        });
    });

    function generateInvoiceContent(customerName, invoiceDetails) {
        let content = `<h2>Invoice</h2>
                       <p><strong>Customer Name:</strong> ${customerName}</p>
                       <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; margin-top: 20px;">
                           <thead>
                               <tr>
                                   <th>Item</th>
                                   <th>Qty</th>
                                   <th>Price</th>
                                   <th>Amount</th>
                               </tr>
                           </thead>
                           <tbody>`;
        
        invoiceDetails.forEach(item => {
            content += `<tr>
                            <td>${item.itemName}</td>
                            <td>${item.qty}</td>
                            <td>${item.price}</td>
                            <td>${item.amount}</td>
                        </tr>`;
        });

        content += `</tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right;">Grand Total</td>
                            <td>${$('#grandtotal').val()}</td>
                        </tr>
                    </tfoot>
                </table>`;
        
        return content;
    }

    function clearCart() {
        // Clear product list
        $('#productlist').empty();
        $('#total').text('0.00');
        $('#discount').val('');
        $('#grandtotal').val('0.00');
        $('#totalPaid').val('');
        $('#totalReturn').val('0.00');
        $('#customerName').val('');
        
        // Reset cart object
        totalAmount = 0;
        cart = {};
        localStorage.setItem('cart', JSON.stringify(cart)); // Reset cart in localStorage
    }
});
</script>

<?php include("footer.php"); ?>