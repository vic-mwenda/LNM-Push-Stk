<!DOCTYPE html>
<html>
<head>
    <title>Phone Number Lookup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container mt-5">
    <h2>Confirm Payment</h2>
    <div id="alertContainer"></div>

    <form id="transactionForm">
        <div class="form-group">
            <label for="phone">Transaction Code:</label>
            <input type="text" class="form-control" id="phone" name="trans_id" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#transactionForm').submit(function (event) {
        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'lookup.php',
            data: formData,
            success: function (response) {
                var result = JSON.parse(response);

                displayAlert(result.title, result.message, result.type);
            }
        });
    });

    function displayAlert(title, message, type) {
        var alertContainer = $('#alertContainer');
        alertContainer.empty();

        var alertClass = '';
        if (type === 'success') {
            alertClass = 'alert-success';
        } else if (type === 'error') {
            alertClass = 'alert-danger';
        }

        var alertHTML = '<div class="alert ' + alertClass + '">' +
                        '<strong>' + title + '</strong> ' + message +
                        '</div>';

        alertContainer.append(alertHTML);
    }
</script>

</body>
</html>
