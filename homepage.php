<?php
include("auth_session.php");
include("securedData.inc.php");
include("db.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$_SESSION['code'] = array();


$query = "SELECT projects.projectName, projects.projectDescription, users.firstname, users.lastname, projects.projectEndDate, projects.requestedFund, users.idUser, projects.idProject FROM users 
                    JOIN projects ON users.idUser = projects.idUser";

$result = $con->query($query) or die();
$result2 = $con->query($query) or die();
$rows = $result->num_rows;

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <meta http-equiv="refresh" content="1800;url=logout.php" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">

    <style>
        a{
            border:1px solid black;
            border-radius: 10px;
        }

        h2{
            text-align: center;
        }
        html {
            scroll-behavior: smooth;
        }

        
    </style>
</head>

<body>

    
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
	  <div class="container-fluid ">
        <img src="crowdfunding2.png" style="width: 225px;"  class="img-fluid" alt="crowdfunding">
		  <ul class="navbar-nav ml-auto">
			<li class="nav-item">
                <a class="nav-link" href="logout.php" style="background-color:#00b09b; color:white; border-color:#00b09b;">Log out</a>
			</li>			
		  </ul>		  
	  </div>
	</nav>


    <div class="container">
        <br>

        <?php
        $isowner = false;
        while ($row = $result->fetch_row()) {
            if ($row[6] == $_SESSION['userid']) {
                $_SESSION['projectid'] = $row[7];
                $_SESSION['title'] = $row[0];
                $isowner = true;
                break;
            }
        }
        ?>
        
        <h2><b>Dashboard</b></h2>
        <br>

        <div class="row">
            <?php
                while ($row = $result2->fetch_row()) {
                    //  d-flex below
                    echo "<div class=\"col-md-4 col-sm-12 mb-4 d-flex align-items-stretch\">";
                    echo "<div class=\"card\">";
                    echo "<div class=\"card-body\">";
                    echo "<h4 class=\"card-title\">". $row[0] . "</h4>";
                    echo "<h6 class=\"card-subtitle mb-2 text-muted\">Description</h6>";
                    echo "<p style=\"font-size: 14px; overflow-y: scroll; height: 85px;\" class=\"card-text\"><i>" . $row[1] . "</i></p>";
                    echo "<p class=\"card-text\">Owner: " . $row[2] . " " . $row[3] . "</p>";
                    echo "<p class=\"card-text\">End Date: " . $row[4] . "</p>";
                    echo "<p class=\"card-text\">Requested fund: " . $row[5] . "$</p>";

                    $query3 = "SELECT * FROM projects_investors WHERE idUser = '". $_SESSION['userid'] ."' and idProject = '". $row[7] ."'";
                    $result3 = $con->query($query3) or die();
                    $rows3 = $result3->num_rows;


                    $query4 = "SELECT projects.projectName, projects.requestedFund, SUM(projects_investors.investmentFund) AS 'Total Raised',
                    (projects.requestedFund - SUM(projects_investors.investmentFund)) as 'Remaining Funding' 
                    FROM projects_investors, projects WHERE  projects_investors.idProject = projects.idProject
                    AND projects.idProject = '" . $row[7] . "' GROUP BY projects.idProject";
                    $result4 = $con->query($query4) or die();

                    $current_row = $result4->fetch_row();

                    if($isowner && $row[6] == $_SESSION['userid']){
                        echo "<a class='btn btn-info btn-sm' href='owner_stats.php'>DETAILS</a>";

                    }else{
                        if(date("Y-m-d") > $row[4]){
                            echo "<p class=\"card-text\"><b>" . "Can't Invest. Outdated project!" . "</b></p>";
                        }else if($current_row[3]==0){
                            echo "<p class=\"card-text\"><b>" . "Can't Invest. Investment completed!" . "</b></p>";
                        }else if($rows3 > 0){
                            echo "<p class=\"card-text\"><b>" . "Can't Invest. Already contributed!" . "</b></p>";
                        }else{
                            $theCode = random_pw(8);
                            $_SESSION['code'][$theCode] = $row[7];
                            echo '<a class=\'btn btn-success btn-sm\' href="invest.php?link=' . $theCode . '">INVEST</a>';
                        }   
                    }
                    echo "</div>";   
                    echo "</div>";
                    echo "</div>";
                }
                ?>
                <br>
        </div>
        <br>
        <h2>Overall Statistics of Projects</h2>
        <img src="bargraph.php" alt="statistics" class="img-fluid">
        
    </div>
    <br>
    <footer class="bg-light text-black text-center text-lg-start">
    <div class="container p-4">
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                <h5 class="text-uppercase">Definition</h5>
                <p><i>
                Crowdfunding is the use of small amounts of capital from a large number of individuals to finance a new business venture. Crowdfunding makes use of the easy accessibility of vast networks of people through social media and crowdfunding websites to bring investors and entrepreneurs together, with the potential to increase entrepreneurship by expanding the pool of investors beyond the traditional circle of owners, relatives, and venture capitalists.
            </i></p>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Contacts</h5>

                <ul class="list-unstyled mb-0">
                <li>
                    <a href="#" class="btn btn-secondary btn-sm stretched-link mt-1">(+994) 558201103</a>
                </li>
                <li>
                    <a href="#" class="btn btn-secondary btn-sm stretched-link mt-1">(+994) 552281337</a>
                </li>
                <li>
                    <a href="#" class="btn btn-secondary btn-sm stretched-link mt-1">crowdfunding@gmail.com</a>
                </li>
                <li>
                    <a href="#" class="btn btn-secondary btn-sm stretched-link mt-1 ">HRcrowdfunding@gmail.com</a>
                </li>
                </ul>

            </div>
        
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase mb-0">Social Media</h5>

                <ul class="list-unstyled">
                <li>
                    <a href="#" class="btn btn-secondary btn-sm stretched-link mt-2">Instagram</a>
                </li>
                <li>
                    <a href="#" class="btn btn-secondary btn-sm stretched-link mt-1">Facebook</a>
                </li>
                <li>
                    <a href="#" class="btn btn-secondary btn-sm stretched-link mt-1">Twitter</a>
                </li>
                <li>
                    <a href="#" class="btn btn-secondary btn-sm stretched-link mt-1 ">VK</a>
                </li>
                </ul>
            </div>

            
        </div>
    </div>
</footer>

</body>

</html>