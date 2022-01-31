<?php
include("auth_session.php");
include("securedData.inc.php");
require('db.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="1800;url=logout.php" />

    <title>Sign in</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <?php
    if (isset($_REQUEST['invested'])) {
        $prjid = $_SESSION['code'][$_GET['link']];
        if($prjid > 0 ){
            $_SESSION['prjid2'] = $prjid;
        }
        $invested_date = date('Y-m-d', strtotime($_POST['duedate']));
        $usid = $_SESSION['userid'];
        $invested = $_POST['invested'];

        $query = "INSERT INTO projects_investors (idUser, idProject, investmentFund, investmentDate) VALUES ('". $usid ."', '". $_SESSION['prjid2'] . "', '".$invested. "', '".$invested_date . "')";
        
        $query2 = "SELECT projects.projectName, projects.requestedFund, SUM(projects_investors.investmentFund) AS 'Total Raised', 
        (projects.requestedFund - SUM(projects_investors.investmentFund)) as 'Remaining Funding', projects.projectEndDate
        FROM projects_investors, projects WHERE  projects_investors.idProject = projects.idProject
        AND projects.idProject = '" . $_SESSION['prjid2'] . "' GROUP BY projects.idProject";

        $result2 = $con->query($query2) or die();

        $current_row = $result2->fetch_row();
        if($invested_date < date('Y-m-d')){
            $_SESSION['Error4'] = "Due Date is less than current date!";
            header("Location: invest.php");
        }else if($invested_date > $current_row[4]){
            $_SESSION['Error3'] = "Due Date is higher than end date of project. Choose earlier! ";
            header("Location: invest.php");
        }else if($invested > $current_row[3]){
            $_SESSION['Error1'] = "You can't invest. Invested amount is greater than needed one!";
            $_SESSION['Error2'] = "The remaining funding still expected: " . $current_row[3] . "";
            header("Location: invest.php");
        }else{
            if($con->query($query)){
                header("Location: homepage.php");
            }
        }
    } else {
    ?>
    <section class="vh-100 bg-light">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

                <h2 class="mb-5" style="color:#00b09b;"><b>Investment</b></h2>
                
                <form action="" method="post"> 

                <div class="form-outline mb-4">
                    <label class="form-label" for="amount">Amount</label>
                    <input type="number" step="0.01" min="0.01" name="invested" placeholder="Amount proposed" required class="form-control" />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="date">Date</label>
                    <input type="date" name="duedate" placeholder="Due Date" required class="form-control" />
                </div>

                
                <?php
                    if(isset($_SESSION['Error1']))
                    {
                        echo "<small class=\"text-danger\">" . $_SESSION['Error1'] . "</small><br>";
                        echo "<small class=\"text-danger\">" . $_SESSION['Error2'] . "</small><br>";
                        unset($_SESSION['Error1']);
                        unset($_SESSION['Error2']);
                    } 
                    if(isset($_SESSION['Error4'])){
                        echo "<small class=\"text-danger\">" . $_SESSION['Error4'] . "</small><br>";
                        unset($_SESSION['Error4']);
                    }
                    if(isset($_SESSION["Error3"])){
                        echo "<small class=\"text-danger\">" . $_SESSION['Error3'] . "</small><br>";
                        unset($_SESSION['Error3']);
                    }                       
                ?>
                <small class="form-text text-muted mt-2"> You can write up to 2 decimal points!</small>
                <br><br>
                <button class="btn btn-success btn-block" type="submit">DONATE</button>

                <hr class="my-4">
                </form>

                <div class="mt-3" style="text-align: center;">
                    <a class="btn btn-primary" href="homepage.php" >Return to homepage</a>
                </div> 

            </div>
            </div>
        </div>
        </div>
    </div>
    </section>
    <?php
    }
    ?>
</body>
</html>