<?php
require "connect.php";

$sql = "SELECT * FROM `address` ORDER BY date_added DESC;";
$stmt = $pdo->prepare($sql);
$stmt->execute([]);
$address = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Count the total number of orders
$totalAddress = count($address);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Address PHP CRUD</title>
    <link rel="icon" type="image/x-icon" href="image/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>



<body>
    <div class="modal-content slideDown">
        <div class="modal-header">
            <span style="visibility: hidden;">&times;</span>
            <h2>Address Selection(<?php echo $totalAddress ?>)</h2>
            <button class="add_address button green" id="add_address"><i class="fas fa-plus"></i> Add</button>
        </div>

        <div class="modal-body" style="max-height: 450px; overflow-y: auto; width: 100%;">
            <form action="checkout.php" class="modal-form" method="post">
                <!-- Adjusted action to point to checkout.php -->
                <br>
                <div class="radio-inputs">
                    <?php foreach ($address as $row) { ?>
                    <label>
                        <input class="radio-input" type="radio" name="selected_address"
                            value="<?php echo htmlspecialchars(json_encode($row)); ?>">
                        <!-- Added htmlspecialchars for security -->
                        <span class="radio-tile">
                            <span class="radio_button">
                                <button style="visibility:hidden;" id="modal-button_<?php echo $row['id']; ?>"
                                    onclick="editAddress(<?php echo $row['id']; ?>)">Edit</button>
                                <button id="modal-button_<?php echo $row['id']; ?>"
                                    onclick="deleteAddress(<?php echo $row['id']; ?>)"><i
                                        class="fas fa-trash-alt"></i></button>
                            </span>
                            <span class="radio-label">
                                <strong><?php echo $row['id']; ?> <?php echo htmlspecialchars($row['first_name']); ?>
                                    <?php echo htmlspecialchars($row['last_name']); ?></strong> |
                                <?php echo htmlspecialchars($row['mobile_number']); ?>
                            </span>
                            <span class="radio-label"><?php echo htmlspecialchars($row['street']); ?>,
                                <?php echo htmlspecialchars($row['barangay']); ?></span>
                            <span class="radio-label"><?php echo htmlspecialchars($row['city']); ?>,
                                <?php echo htmlspecialchars($row['province']); ?>,
                                <?php echo htmlspecialchars($row['region']); ?>,
                                <?php echo htmlspecialchars($row['zip_code']); ?></span>
                        </span>
                    </label>
                    <?php } ?>
                </div>
        </div>

        <div class="modal-footer">
            <input type="submit" class="button good" value="Save">
        </div>
        </form>
    </div>
    </div>



    <!-- ADD Address modal -->
    <div id="addressModal" class="address-modal">
        <div class="address-modal-content">
            <div class="modal-header">
                <span class="close" id="closeAddressModal">&times;</span>
                <h2>Add Delivery Address</h2>
            </div>
            <div class="container">
                <div class="form-wapper">

                    <div class="form-body">
                        <form class="row g-3 needs-validation" method="POST" action="address/add_address.php"
                            autocomplete="off" novalidate>
                            <div class="col-md-4">
                                <label for="first_name" class="form-label">First name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    placeholder="Enter First name" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="last_name" class="form-label">Last name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    placeholder="Enter Last name" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="mobile_number" class="form-label">Mobile Number</label>
                                <input type="tel" class="form-control" id="mobile_number" name="mobile_number"
                                    placeholder="09*********" pattern="[0-9]{11}" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="zip_code" class="form-label">Zip Code</label>
                                <input type="text" class="form-control" id="zip_code" name="zip_code"
                                    placeholder="Enter Zip Code" required>
                                <div class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="region" class="form-label">Region</label>
                                <select class="form-select" name="region" id="region" autocomplete="region" required>
                                </select>
                                <input type="hidden" class="form-control form-control-md" name="region_text"
                                    id="region-text" required>
                                <div class="invalid-feedback">
                                    Please select a valid Region.
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="province" class="form-label">Province</label>
                                <select class="form-select" name="province" id="province" autocomplete="province"
                                    required>
                                </select>
                                <input type="hidden" class="form-control form-control-md" name="province_text"
                                    id="province-text" required>
                                <div class="invalid-feedback">
                                    Please select a valid Province.
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="city" class="form-label">City/Municipality</label>
                                <select class="form-select" name="city" id="city" autocomplete="city" required>
                                </select>
                                <input type="hidden" class="form-control form-control-md" name="city_text"
                                    id="city-text" required>
                                <div class="invalid-feedback">
                                    Please select a valid City/Municipality.
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="barangay" class="form-label">barangay</label>
                                <select class="form-select" name="barangay" id="barangay" autocomplete="barangay"
                                    required>
                                </select>
                                <input type="hidden" class="form-control form-control-md" name="barangay_text"
                                    id="barangay-text" required>
                                <div class="invalid-feedback">
                                    Please select a valid Barangay.
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="street" class="form-label">House No. and Street</label>
                                <input type="text" class="form-control" id="street" name="street"
                                    placeholder="Enter House No. and Street" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="shipping_fee" class="form-label">Shipping Fee</label>
                                <input type="number" class="form-control" id="shipping_fee" name="shipping_fee"
                                    placeholder="Shipping Fee" readonly>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                                    <label class="form-check-label" for="invalidCheck">
                                        Agree to terms and conditions
                                    </label>
                                    <div class="invalid-feedback">
                                        You must agree before submitting.
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="true" name="cart_checkout" />
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Submit form</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>




    <!-- UPDATE Address Modal -->
    <?php foreach ($address as $row) { ?>
    <div id="editdataModal_<?php echo $row['id']; ?>" class="modal">
        <div class="address-modal-content">
            <div class="modal-header">
                <span class="close" id="closeAddressModal">&times;</span>
                <h2>Update Delivery Address</h2>
            </div>
            <div class="container">
                <div class="form-wapper">

                    <div class="form-body">
                        <form method="POST" action="address/update_address.php">
                            <div class="input-wrapper">
                                <div class="select-wrapper">
                                    <label for="first_name">First name</label>
                                    <input id="first_name" type="text" name="first_name" placeholder="Enter First name"
                                        value="<?php echo $row['first_name']; ?>" required>
                                </div>
                                <div class="select-wrapper">
                                    <label for="last_name">Last name</label>
                                    <input id="last_name" type="text" name="last_name" placeholder="Enter Last name"
                                        value="<?php echo $row['last_name']; ?>" required>
                                </div>
                            </div>
                            <div class="input-wrapper">
                                <div class="select-wrapper">
                                    <label for="mobile_number">Mobile Number</label>
                                    <input type="tel" id="mobile_number" name="mobile_number" placeholder="09*********"
                                        value="<?php echo $row['mobile_number']; ?>" pattern="[0-9]{11}" required>
                                </div>
                                <div class="select-wrapper">
                                    <label for="zip_code">Zip Code</label>
                                    <input id="zip_code" type="text" name="zip_code" placeholder="Enter Zip Code"
                                        value="<?php echo $row['zip_code']; ?>" required>
                                </div>
                            </div>
                            <div class="input-wrapper">
                                <div class="select-wrapper">
                                    <label for="region">Region</label>
                                    <select class="dropdown_address" name="region" id="region">
                                    </select>
                                    <input type="hidden" class="form-control form-control-md" name="region_text"
                                        id="region-text" value="<?php echo $row['region']; ?>" required>
                                </div>
                                <div class="select-wrapper">
                                    <label for="province">Province</label>
                                    <select class="dropdown_address" name="province" id="province">
                                    </select>
                                    <input type="hidden" class="form-control form-control-md" name="province_text"
                                        id="province-text" value="<?php echo $row['province']; ?>" required>
                                </div>
                            </div>
                            <div class="input-wrapper">
                                <div class="select-wrapper">
                                    <label for="city">City/Municipality</label>
                                    <select class="dropdown_address" name="city" id="city">
                                    </select>
                                    <input type="hidden" class="form-control form-control-md" name="city_text"
                                        id="city-text" value="<?php echo $row['city']; ?>" required>
                                </div>
                                <div class="select-wrapper">
                                    <label for="barangay">Barangay</label>
                                    <select class="dropdown_address" name="barangay" id="barangay">
                                    </select>
                                    <input type="hidden" class="form-control form-control-md" name="barangay_text"
                                        id="barangay-text" value="<?php echo $row['barangay']; ?>" required>
                                </div>
                            </div>
                            <div class="input-wrapper">
                                <label for="street">Street</label>
                                <input id="street" type="text" name="street" placeholder="Enter Street"
                                    value="<?php echo $row['street']; ?>" required>
                            </div>


                            <input type="hidden" value="true" name="cart_checkout" />
                            <div class="address_button">
                                <button class="delete_address_button">CANCEL</button>
                                <input type="submit" class="save_address_button" value="Save">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php } ?>



</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
</script>
<script src="address/address_selector.js"></script>
<script src="validation.js"></script>
<script>
const addressModal = document.getElementById('addressModal');
const addButton = document.querySelectorAll('.add_address');
const closeAddressModal = document.getElementById('closeAddressModal');

// Function to open address editing modal
const openAddressModal = function() {
    addressModal.style.display = "block";
};

// Function to close address editing modal
const closeAddressModalFunction = function() {
    addressModal.style.display = "none";
};

// Add click event listeners for "Edit" buttons
for (let i = 0; i < addButton.length; i++) {
    addButton[i].addEventListener('click', openAddressModal, false);
}

// Close address editing modal when close button is clicked
closeAddressModal.addEventListener('click', closeAddressModalFunction, false);

// Close address editing modal when clicking outside of it
window.onclick = function(event) {
    if (event.target == addressModal) {
        addressModal.style.display = "none";
    }
};
</script>

<script>
function editAddress(addressId) {
    // Find the correct modal using the product ID
    var modalId = 'editdataModal_' + addressId;
    $('#' + modalId).modal('show');
}
</script>

<script>
function deleteAddress(addressId) {
    // Confirm before proceeding with deletion
    if (confirm("Are you sure you want to delete this Address?")) {
        // Send an AJAX request to delete.php for deletion
        $.ajax({
            url: 'address/delete_address.php',
            method: 'GET',
            data: {
                id: addressId
            },
            success: function(response) {
                console.log('AJAX Success:', response);
                if (response.trim() === 'success') {
                    alert('Address deleted successfully!');
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert('Failed to delete the address. Please try again.');
                    // alert('Blessing completed successfully!');
                    location.reload(); // Reload the page to reflect changes
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle errors as needed
            }
        });
    }
}
</script>

<script>
// Get the region dropdown
const regionDropdown = document.getElementById('region');

// Add event listener to the region dropdown
regionDropdown.addEventListener('change', function() {
    // Get the selected region value
    const selectedRegion = regionDropdown.value;

    // Define the shipping fee data based on your JSON structure
    const regionData = {
        "01": 40, // Region I (Ilocos Region)
        "02": 40,
        "03": 40,
        "04": 40,
        "05": 40,
        "06": 40,
        "07": 80,
        "08": 80,
        "09": 80,
        "10": 120,
        "11": 120,
        "12": 120,
        "13": 120,
        "14": 40,
        "15": 40,
        "16": 120,
        "17": 120,
    };

    // Retrieve the shipping fee based on the selected region code
    const shippingFee = regionData[selectedRegion] || 0;

    // Update the shipping fee input field
    document.getElementById('shipping_fee').value = shippingFee;
});
</script>

</html>