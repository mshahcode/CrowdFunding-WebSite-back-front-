<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_pie.php');

include("auth_session.php");
include("db.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$query2 = "SELECT projects.projectName, projects.requestedFund, SUM(projects_investors.investmentFund) AS 'Total Raised',
 (projects.requestedFund - SUM(projects_investors.investmentFund)) as 'Remaining Funding' 
 FROM projects_investors, projects WHERE  projects_investors.idProject = projects.idProject
  AND projects.idProject = '" . $_SESSION['projectid'] . "' GROUP BY projects.idProject";

$result2 = $con->query($query2) or die();

$current_row = $result2->fetch_row();

$data = array(round(($current_row[2]/($current_row[3]+ $current_row[2]))*100)
,100 - round(($current_row[2]/($current_row[3]+ $current_row[2]))*100)
);
 
$graph = new PieGraph(300,300);
$graph->SetShadow();
 
$graph->title->Set("Statistics");
 
$p1 = new PiePlot($data);
$p1->SetCenter(0.4);
$p1->SetLegends(array("Collected","Left"));

 
$graph->Add($p1);
$graph->Stroke();
 
?>