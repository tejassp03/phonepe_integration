<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js">
</script>
<?php
include "../config.php";
session_start();

    $loginName="";
	$loginEmailId="";
	$mobile="";
    $cardtype="";
	$category="";
    $duration="";
    $nohrs="";
    $amount="";
	$candassignrefer="";
	$businessreferal="";
	$totaljoined='';
	$tinno='';
	if(isset($_COOKIE['login_name'])){
	$loginEmailId=$_COOKIE['login_mail'];
	$loginName=$_COOKIE['login_name'];
	$mobile=$_COOKIE['mobile'];
	$category=$_COOKIE['category'];

	
	}
    
   
        $memamt=1000;
        $memtype="ELTS ".$memamt;
        $sql="select * from premiumdetails where CardType='$memtype'";
        $res=mysqli_query($con,$sql);
        while($row=mysqli_fetch_array($res))
        {
            $duration=$row['Duration'];
            $nohrs=$row['noHrs'];
            $amount=$row['Amount'];
            $cardtype=$row['CardType'];
        }
    


?>
<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../BADashboard/assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>ELTS Membership</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../BADashboard/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../BADashboard/assets/vendor/fonts/boxicons.css" />
    <script src="../BADashboard/assets/vendor/libs/jquery/jquery.js"></script>

    <!-- Core CSS -->
    <link rel="stylesheet" href="../BADashboard/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../BADashboard/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../BADashboard/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../BADashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../BADashboard/assets/vendor/libs/bs-stepper/bs-stepper.css" />
    <link rel="stylesheet" href="../BADashboard/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../BADashboard/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../BADashboard/assets/js/config.js"></script>
</head>
<style>
    @media screen and (max-width: 768px) {
        #price
        {
            flex-direction: column !important;
        }
    }
#topsearch {
    margin: 0;
}

.c-top {
    padding: 15px 15px 10px 20px !important;
}

.modal-body {
    transition: height 0.5s ease;
    overflow: hidden;
}

.table {
    margin: auto;
    width: auto !important;
    overflow-x: scroll !important;
    counter-reset: serial-number;
    /* Set the serial number counter to 0 */
}

.rounded-pill {
    padding: 0.1rem 0.6rem;
    font-size: 0.8rem;
}



#orderreview td{
    padding: 0.625rem 0.85rem !important;
}

#memtable td:first-child:before {
    counter-increment: serial-number;
    /* Increment the serial number counter */
    content: counter(serial-number);
    /* Display the counter */

}
.text-primary
{
    color: #007bff !important;
   
}
.btn-primary
{
    background-color: #007bff !important;
}

.loading-spinner{
  width:30px;
  height:30px;
  border:2px solid indigo;
  border-radius:50%;
  border-top-color:#0001;
  display:inline-block;
  animation:loadingspinner .7s linear infinite;
}
@keyframes loadingspinner{
  0%{
    transform:rotate(0deg)
  }
  100%{
    transform:rotate(360deg)
  }
}
.center {
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -20%);
}
#checkbox {
  height: 1em;
  width: 1em;
  vertical-align: middle;
}
</style>

<body>



                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">

                    <div class="text-center img-fluid" >
                    <img src="assets/img/eltslogo.png" style="object-fit:contain;width:7rem;" class="rounded" alt="...">
                    </div>

                        <!--Wizard -->
             
  <div class="container py-4">
    <div class="row d-flex justify-content-center">
      <div class="col-md-12 col-lg-10 col-xl-8">
        <div class="card">
          <div class="card-body p-md-5">
            <div>
              <h4>Transaction Status</h4>
              <p class="text-muted pb-2" id="statustext">
               Your transaction is being processed. Please wait for confirmation and then your ELTS Membership will be activated.</p>
            </div>

            <div class="px-3 py-4 border border-warning border-2 rounded  d-flex justify-content-between">
              <div class="d-flex flex-row align-items-center">
                <img src="assets/img/memicon.png" class="rounded" width="60" />
                <div class="d-flex flex-column ms-4">
                  <span class="h5 mb-1"><?php echo $cardtype;?></span>
                  <span class="small text-warning" >PENDING</span>
                </div>
              </div>
              <div id="price" class="d-flex flex-row align-items-center">
                <input type="text" id="memamount" value="<?php echo base64_encode($amount); ?>" style="display:none;">
                <span class="h2 mx-1 mb-0"><sup class="dollar font-weight-bold text-muted">₹</sup><?php echo $amount;?></span>
                <span class="text-muted font-weight-bold mt-2">/<?php echo $duration;?> Days</span>
              </div>
            </div>
 
        <h5 class="text-light fw-semibold mt-4">Transaction Details</h5>
        <dl class="row mt-2">
          <dt class="col-sm-3">Transaction ID</dt>
          <dd class="col-sm-9">MT8386DH873DH</dd>

          <dt class="col-sm-3">Membership</dt>
          <dd class="col-sm-9">ELTS 1000</dd>

          <dt class="col-sm-3">Amount</dt>
          <dd class="col-sm-9">₹1000</dd>

          <dt class="col-sm-3">Status</dt>
          <dd class="col-sm-9">Pending</dd>

          

        </dl>

            <!-- <h6 class="mt-4">Coupon Code?</h6>
            <div class="form-outline">
            <div class="input-group">
          <input type="text" class="form-control" placeholder="Enter Code" aria-label="Enter Code" aria-describedby="button-addon2">
          <button class="btn btn-outline-primary" type="button" id="button-addon2">Apply</button>
        </div>
            </div>
            <div class="d-flex flex-row align-items-center mt-3 gap-2">
            <input id="checkbox" type="checkbox"  />
                <label for="checkbox"> I agree to these <a href="#">Terms and Conditions</a>.</label>
            </div> -->
            
            <div class="mt-4">
              <button class="btn btn-primary btn-block btn-lg" id="refresh-button" onclick="location.reload()">
                Check Status &nbsp;<i class='bx bx-refresh'></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

                        <!--end wizard -->
                        <div class="modal center" id="modal-loading" data-bs-backdrop="static" data-bs-keyboard="false">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                            <div class="modal-body text-center">
                                <div class="loading-spinner mb-2"></div>
                                <div>Redirecting to Payment Gateway</div>
                                <p>Do not close or refresh the browser untill payment is successful.</p>
                            </div>
                            </div>
                        </div>
                        </div>

                    </div>
                    <!-- / Footer -->
            
                    <div class="content-backdrop fade"></div>
             

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>

        </div>
        <!-- / Layout wrapper -->



        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->
        <script src="../BADashboard/assets/vendor/libs/jquery/jquery.js"></script>
        <!-- <script src="../BADashboard/assets/vendor/libs/popper/popper.js"></script> -->
        <script src="../BADashboard/assets/vendor/js/bootstrap.js"></script>

        <script src="../BADashboard/assets/vendor/js/menu.js"></script>
        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="../BADashboard/assets/vendor/libs/apex-charts/apexcharts.js"></script>
        <script src="../BADashboard/assets/vendor/libs/bs-stepper/bs-stepper.js" ></script>

        <!-- Main JS -->
        <script src="../BADashboard/assets/js/main.js"></script>

        <!-- Page JS -->
        <script src="../BADashboard/assets/js/dashboards-analytics.js"></script>


        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>

        <script>

$(document).ready(function() {



 btnSubmit = document.querySelector('#submit-button');
const amt=atob(document.querySelector('#memamount').value);

 if (btnSubmit) {
    btnSubmit.addEventListener('click', event => {
        $('#modal-loading').modal('show');
        $.ajax({
      url: 'curlrequest.php',
      type: 'POST',
      data: { amount: amt },
      success: function(response) {
        location.href = response; // Redirect to the URL received in the response
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log('Error: ' + errorThrown); // Log any errors to the console
      }
    });
          

        
        });
    }
});



       
        // Amount validation

        </script>

</body>

</html>