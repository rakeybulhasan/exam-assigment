<?php

use App\Controllers\BuyerController;
use Core\Model;

require_once __DIR__ . '/vendor/autoload.php';
define("APPLICATION_PATH",  dirname(__FILE__));
$db = Model::getInstance();
$mysqli = $db->getConnection();

//var_dump(APPLICATION_PATH);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Exam Assignment</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <!-- Bootstrap core CSS -->
    <link href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" rel="stylesheet" crossorigin="anonymous">
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/business-frontpage.css" rel="stylesheet">
    <style>
        #overlay{
            position: fixed;
            top: 100px;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.6);
        }
    </style>
</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">XpeedStudio</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Page Content -->
<div class="container" style="padding-top: 50px; margin-bottom: 50px">

    <div class="alert" style="display: none">

    </div>
    <form id="buyer_form" name="buyer_form" method="post" action="">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="amount" class="col-sm-3 col-form-label">Amount <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <input type="number" name="amount" class="form-control" id="amount" value="">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="buyer" class="col-sm-3 col-form-label">Buyer <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" required name="buyer" maxlength="20" class="form-control" id="buyer" placeholder="Buyer Name">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="buyer_email" class="col-sm-3 col-form-label">Buyer Email <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" name="buyer_email" id="buyer_email" placeholder="Buyer Email">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-sm-3 col-form-label">Phone <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="phone" id="phone">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="entry_by" class="col-sm-3 col-form-label">Entry By <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="entry_by" id="entry_by" placeholder="Entry By">
                        <span class="help-block"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="receipt_id" class="col-sm-3 col-form-label">Receipt Id <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="receipt_id" id="receipt_id" value="" placeholder="Receipt Id">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="items" class="col-sm-3 col-form-label">Items <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="items" id="items" placeholder="Items">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="city" class="col-sm-3 col-form-label">City <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="city" id="city" placeholder="City">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="note" class="col-sm-3 col-form-label">Note</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" rows="3" name="note" id="note" placeholder="Note"></textarea>
                        <span class="help-block"></span>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="action" value="INSERT" id="action" />
        <button type="button" class="btn btn-primary form_submit">Save</button>
    </form>
    <!-- /.row -->

</div>

<div class="container">
    <form action="" method="get">
        <table width="100%">
            <tbody>
            <tr>
                <td><input type="text" placeholder="Receipt Id ......." class="form-control searchByReceiptId" id="searchByReceiptId" name="searchByReceiptId"></td>
                <td><input type="date" class="form-control fromDate" id="fromDate" name="fromDate" placeholder="From Date"></td>
                <td><input type="date" class="form-control toDate" id="toDate" name="toDate" placeholder="To Date"></td>
                <td><input type="submit" class="btn btn-primary searchButton" id="searchButton" name="searchButton" value="Search"></td>
            </tr>
            </tbody>
        </table>
    </form>
    <table id="buyer_table" class="table table-bordered">
        <thead>
        <tr>
            <th>SL</th>
            <th>Receipt Id</th>
            <th>Buyer</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Amount</th>
            <th>Items</th>
            <th>Note</th>
            <th>Date</th>
            <th>Entry By</th>
        </tr>
        </thead>
        <?php
        $buyerController = new BuyerController();

        $buyers = $buyerController->getBuyers();

//        var_dump($buyers);
        if($buyers){
            $i=1;
            foreach ($buyers as $buyer){
            ?>
            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $buyer['receipt_id'];?></td>
                <td><?php echo $buyer['buyer'];?></td>
                <td><?php echo $buyer['buyer_email'];?></td>
                <td><?php echo $buyer['phone'];?></td>
                <td><?php echo number_format($buyer['amount'],2,'.',',');?></td>
                <td><?php echo $buyer['items'];?></td>
                <td><?php echo $buyer['note'];?></td>
                <td><?php echo date("d-m-Y", strtotime( $buyer['entry_at']));?></td>
                <td><?php echo $buyer['entry_by'];?></td>
            </tr>
        <?php
            $i++;
            }
        }else{ ?>

        <tr>
            <td colspan="13">No record found.</td>
        </tr>
        <?php

        }

        ?>


        </tbody>

    </table>
</div>
<!-- /.container -->
<!-- Footer -->
<footer class="py-5">
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="assets/jquery/jquery.min.js"></script>
<script src="assets/jquery/jquery.inputmask.js"></script>
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>
<script type="text/javascript">
        function checkNumeric(inputtxt)
        {
            var numbers = '^[0-9]+$';
            if(inputtxt.value.match(numbers))
            {
                return true;
            }
            else
            {
                alert('Please input numeric only');
                return false;
            }
        }
        $('#phone').inputmask("8809999999999", {removeMaskOnSubmit: false, placeholder: '880xxxxxxxxxx'});

</script>
</body>

</html>
