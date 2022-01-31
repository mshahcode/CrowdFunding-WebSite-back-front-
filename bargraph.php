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

$query2 = "SELECT projects.projectName, projects.requestedFund, SUM(projects_investors.investmentFund) AS 'Total Raised',
 (projects.requestedFund - SUM(projects_investors.investmentFund)) as 'Remaining Funding' 
 FROM projects_investors, projects WHERE  projects_investors.idProject = projects.idProject GROUP BY projects.idProject ORDER BY projects.projectName";

$result2 = $con->query($query2) or die();

$datay1=array();
$datay2=array();

// echo "<p>Total raised: " . $current_row[2] . "</p>";
// echo "<p>The remaining funding still expected: " . $current_row[3] . "</p>";
while ($row = $result2->fetch_row()) {
    $datay1[] = $row[2];
    $datay2[] = $row[3];
}

// Create the graph.
$graph = new Graph(1200,500);
$graph->SetScale('textlin');
$graph->SetMarginColor('white');
$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);


$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(array('BUBBLe iT!','Eone Switch','LYNX','PANGEA Eco Jacket','Tuck Bike','UFACTORY Lite 6','WHATTFORNOW','xTool M1','ZEPHIR PROJECT'));
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

    
// Setup title
$graph->title->Set('Statistics of all projects');


 
// Create the first bar
$bplot = new BarPlot($datay1);
$bplot->SetColor('darkred');
$bplot->SetLegend('Gathered');
 
// Create the second bar  
$bplot2 = new BarPlot($datay2);
$bplot2->SetColor('darkgreen');
$bplot2->SetLegend('Remained');

 
// And join them in an accumulated bar
$accbplot = new AccBarPlot(array($bplot,$bplot2));
$graph->Add($accbplot);

$graph->xaxis->SetColor('black','black');

$graph->yaxis->SetColor('black','black');


$graph->legend->SetPos(0.03, 0.1, 'right', 'center');
$graph->SetMargin(50,15,30,50);
$graph->xaxis->title->Set("Projects");

$graph->Stroke();
?>