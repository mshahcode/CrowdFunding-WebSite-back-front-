<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');
require_once ('jpgraph/jpgraph_line.php');
require_once ('jpgraph/jpgraph_bar.php');
require_once ('jpgraph/jpgraph_utils.inc.php');
require_once ('jpgraph/jpgraph_mgraph.php');
include("auth_session.php");
include("db.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$query2 = "SELECT users.firstname, users.lastname, projects_investors.investmentFund FROM users 
                JOIN projects_investors ON users.idUser = projects_investors.idUser 
                JOIN projects ON projects_investors.idProject = projects.idProject WHERE projects.idProject ='" . $_SESSION['projectid'] . "'";
$result2 = $con->query($query2) or die();

$datay1=array();
$datay2=array();

// echo "<p>Total raised: " . $current_row[2] . "</p>";
// echo "<p>The remaining funding still expected: " . $current_row[3] . "</p>";
while ($row = $result2->fetch_row()) {
    $datay1[] = $row[0] . " " . $row[1];
    $datay2[] = $row[2];
}

// Create the graph.
$graph = new Graph(1200,500);
$graph->SetScale('intlin');
 
// Add a drop shadow
$graph->SetShadow();
 
// Adjust the margin a bit to make more room for titles
$graph->SetMargin(100,100,20,150);
 
// Create a bar pot
$bplot = new BarPlot($datay2);

$graph->xaxis->SetTickLabels($datay1);
$graph->xaxis->SetLabelAngle(80);


 
// Adjust fill color
$bplot->SetFillColor('orange');
$graph->Add($bplot);
 
// Setup the titles
$graph->title->Set('Money donated by each Contributor');


 
// Display the graph
$graph->Stroke();
?>