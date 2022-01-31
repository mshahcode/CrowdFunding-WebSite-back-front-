<?php
include("auth_session.php");
include("db.php");

$query = "SELECT users.firstname, users.lastname, projects_investors.investmentFund FROM users 
                JOIN projects_investors ON users.idUser = projects_investors.idUser 
                JOIN projects ON projects_investors.idProject = projects.idProject WHERE projects.idProject ='" . $_SESSION['projectid'] . "'";

$result = $con->query($query) or die();
$rows = $result->num_rows;

$query2 = "SELECT projects.projectName, projects.requestedFund, SUM(projects_investors.investmentFund) AS 'Total Raised',
 (projects.requestedFund - SUM(projects_investors.investmentFund)) as 'Remaining Funding' 
 FROM projects_investors, projects WHERE  projects_investors.idProject = projects.idProject
  AND projects.idProject = '" . $_SESSION['projectid'] . "' GROUP BY projects.idProject";

$result2 = $con->query($query2) or die();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="1800;url=logout.php" />
    <title>Owners info</title>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">


    <style>
        h3,h2{
            text-align: center;
        }

        a{
            float: right;
            padding: 30px;
        }
    </style>
</head>

<body>
    <div class="bg-light">
        <h3 style="padding-top: 5x; color: #00b09b;"><br><b>Contribution of participants to <?php echo $_SESSION['title']; ?></b></h3><br>
    </div>
    <div class="container">
        <br>
        <h3><b>Visual representation of contributions</b></h3>
        <img src="piechart.php" alt="statistics" class="img-fluid mx-auto d-block">
        <br>
        <div style="text-align: center;"></div>
        <?php
            $current_row = $result2->fetch_row();
            echo "<div style=\"text-align: center;\">";
            echo "<p style=\"font-size: 19px;\">Total raised is " . round($current_row[2],2) . "$";
            echo " and the remaining funding still expected is " . round($current_row[3],2) . "$";
            echo "<br></p>";
            echo "</div>";
        ?>
        <br>
        <br>
        <div style="text-align: center;">
            <p style="color: #00b09b ;"><b>Progress Bar</b></p>
        </div>
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo round(($current_row[2]/($current_row[3]+ $current_row[2]))*100) ?>%"></div>
        </div>
        <br>
            
        
        <table class="table table-striped ">
            <thead>
                <tr>
                    <th>Participant</th>
                    <th>Contribution ($)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_row()) {
                    echo "<tr>";
                    echo "<td>" . $row[0]. ' ' . $row[1] . "</td>";
                    echo "<td>" . $row[2] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <h2><b>Statistics of Contributors</b></h2>
        <img src="bargraph2.php" alt="statistics" class="img-fluid">
        <br>
        <a class="btn btn-info" href="homepage.php" >Return to homepage</a>

    </div>
</body>

</html>