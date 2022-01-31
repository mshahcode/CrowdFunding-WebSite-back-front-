<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <style>
        .gradient-custom-2 {
            background: #fccb90;

            background: -webkit-linear-gradient(to right, #00b09b, #96c93d);

            background: linear-gradient(to right, #00b09b, #96c93d);
        }

@media (min-width: 768px) {
  .gradient-form {
    height: 100vh !important;
  }
}
@media (min-width: 769px) {
  .gradient-custom-2 {
    border-top-right-radius: .3rem;
    border-bottom-right-radius: .3rem;
  }
}
    </style>
</head>
<body>
<section class="h-100 gradient-form" style="background-color: white;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black" style="border: 2px black solid;">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <img src="crowdfunding.png" class="img-fluid"  style="width: 300px;" alt="logocrowdfunding">
                  <p></p>
                  <h4 class="mt-1 mb-5 pb-1">Sign in</h4>
                </div>

                <form action="login.php" method="post"> 

                  <div class="form-outline mb-4">
                        <label class="form-label" for="email">Username</label>
                      <input type="email" name="email" class="form-control" placeholder="Email address" required/>
                    
                  </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required/>
                  </div>

                  <?php
                  session_start();
                  if(isset($_SESSION["Error"])){
                      echo "<small class=\"text-danger\">" . $_SESSION['Error'] . "</small><br><br>";
                      unset($_SESSION['Error']);
                  } 
                  ?>
                  <div class="text-center pt-1 mb-5 pb-1">
                    <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit"><b>Log in</b></button>
                  </div>

                </form>

              </div>
            </div>
            
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
            
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h3 class="">Crowdfunding</h3>
                <p style="font-size: 15px;" class="small mb-0">Creative work shows us what’s possible.</p>
                <p style="font-size: 15px;" class="small mb-0">We make ideas happen.</p>
                <p style="font-size: 15px;" class="small mb-0">Help fund it here.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>