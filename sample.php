<?php
require "connect.php";

$sql = "SELECT * FROM `address` ORDER BY date_added DESC;";
$stmt = $pdo->prepare($sql);
$stmt->execute([]);
$address = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>




<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    Launch static backdrop modal
</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Delivery Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" method="POST" action="address/add_address.php" autocomplete="off"
                    novalidate>
                    <div class="col-md-4">
                        <label for="first_name" class="form-label">First name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                            placeholder="Enter First name" required>
                            <div class="invalid-feedback">
                             Input a valid First Name.
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="last_name" class="form-label">Last name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            placeholder="Enter Last name" required>
                            <div class="invalid-feedback">
                             Input a valid Last Name.
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Mobile Number</label>
                        <input type="tel" class="form-control" id="mobile_number" name="mobile_number"
                            placeholder="09*********" pattern="[0-9]{11}" required>
                            <div class="invalid-feedback">
                             Input a valid Mobile number.
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="region" class="form-label">Region</label>
                        <select class="form-select" name="region" id="region" autocomplete="region" required>
                        </select>
                        <input type="hidden" class="form-control form-control-md" name="region_text" id="region-text"
                            required>
                        <div class="invalid-feedback">
                            Select a valid Region.
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="province" class="form-label">Province</label>
                        <select class="form-select" name="province" id="province" autocomplete="province" required>
                        </select>
                        <input type="hidden" class="form-control form-control-md" name="province_text"
                            id="province-text" required>
                        <div class="invalid-feedback">
                            Select a valid Province.
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="city" class="form-label">City/Municipality</label>
                        <select class="form-select" name="city" id="city" autocomplete="city" required>
                        </select>
                        <input type="hidden" class="form-control form-control-md" name="city_text" id="city-text"
                            required>
                        <div class="invalid-feedback">
                            Select a valid City.
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="barangay" class="form-label">barangay</label>
                        <select class="form-select" name="barangay" id="barangay" autocomplete="barangay" required>
                        </select>
                        <input type="hidden" class="form-control form-control-md" name="barangay_text"
                            id="barangay-text" required>
                        <div class="invalid-feedback">
                            Select a valid Barangay.
                        </div>
                    </div>
                    <div class="col-md-9">
                        <label for="street" class="form-label">House No. and Street</label>
                        <input type="text" class="form-control" id="street" name="street"
                            placeholder="Enter House No. and Street" required>
                            <div class="invalid-feedback">
                             Input a valid Street.
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="zip_code" class="form-label">Zip Code</label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code"
                            placeholder="Enter Zip Code" required>
                        <div class="invalid-feedback">
                             Input a valid zip.
                        </div>
                    </div>
                    <div class="col-md-4" style="display: none;">
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
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>







<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
</script>
<script src="address/address_selector.js"></script>
<script src="validation.js"></script>