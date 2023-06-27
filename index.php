<?php
include 'includes/header.php';
?>

<body className='snippet-body'>
<div class="container bg-light d-md-flex align-items-center">
    <div class="card box1 shadow-sm p-md-5 p-md-5 p-4">
        <div class="fw-bolder mb-4">
            <span>KES</span>
            <span class="ps-1">599,00</span>
        </div>

        <div class="d-flex flex-column">
            <div class="d-flex align-items-center justify-content-between text">
                <span class="">Commission</span>
                <span>KES<span class="ps-1">1.99</span></span>
            </div>
            <div class="d-flex align-items-center justify-content-between text mb-4">
                <span>Total</span>
                <span>KES
                        <span class="ps-1">600.99</span>
                    </span>
            </div>
            <div class="border-bottom mb-4"></div>
            <div class="d-flex flex-column mb-4">
                <span class="far fa-file-alt text"><span class="ps-2">Invoice ID:</span></span>
                <span class="ps-3">SN8478042099</span>
            </div>
            <div class="d-flex flex-column mb-5">
                <span class="far fa-calendar-alt text"><span class="ps-2">payment date:</span></span>
                <span class="ps-3">01 july,2023</span>
            </div>
            <div class="d-flex align-items-center justify-content-between text mt-5">
                <div class="d-flex flex-column text">
                    <span>Customer Support:</span><span>online chat 24/7</span>
                </div>
                <div class="btn btn-primary rounded-circle">
                    <span class="fas fa-comment-alt"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="card box2 shadow-sm">
        <div class="d-flex align-items-center justify-content-between p-md-5 p-4">
            <span class="h5 fw-bold m-0">Payment methods</span>
            <div class="btn btn-primary bar"><span class="fas fa-bars"></span></div>
        </div>
        <ul class="nav nav-tabs mb-3 px-md-4 px-2">
            <li class="nav-item">
                <a class="nav-link px-2" aria-current="page" href="#">Credit Card</a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-2 active" href="#">Mobile Payment</a>
            </li>
            <li class="nav-item ms-auto">
                <a class="nav-link px-2" href="#">+ More</a>
            </li>
        </ul>
        <form action="stkpay.php" method="get">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex flex-column px-md-5 px-4 mb-4">
                        <span>Mobile Number</span>
                        <div class="inputWithIcon">
                            <input class="form-control" name="phone" type="text">
                            <span class="">
                                    <img src="assets/images/mpesa-logo.png" alt="">
                                </span>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-column px-md-5 px-4 mb-4">
                        <span>Name</span>
                        <div class="inputWithIcon">
                            <input class="form-control text-uppercase" type="text" value="Vic Mwenda">
                            <span class="far fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 px-md-5 px-4 mt-3">
                    <button class="btn btn-primary w-100" name="submit" type="submit">Pay KES 599.00</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
include 'includes/footer.php';
?>
