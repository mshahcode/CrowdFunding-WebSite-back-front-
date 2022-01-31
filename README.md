The project has been done with Rauf Nasirli CE-19 using PHP, MySQL, JpGraph, Bootstrap, HTML and CSS. Rauf's part was to work on Front-End and some Back-End. Mine was to work mainly on Back-End and some Front-End.

To check our contribution more thoroughly check our repository
BitBucket: https://bitbucket.org/raufnasirli/homework-project/src/master/

Rauf's contribution:

Two "Crowdfunding" images were created using Photoshop to beautify front-end part and Bootstrap cards were used to display projects. Log in page was designed with gradient colors and CSS was created for all pages. For Back End part connection to database was written and Log Out feature was created so that user can log out and sign in with different account. Media queries and bootstraps responsiveness was used to make all the pages fully responsive. Navigation bar and the Footer was created in Homepage and in Owner's project contributors table was styled with bootstrap.

My contribution:

Worked mainly on back-end and some front-end, specifically on Homepage, Owner's Project Page, Investment, Session Authentication, Bar Graph, Pie chart and Log In. Secured site with different methods. Several new controls were added,for instance, user can't invest to project which already got enough investment, user can't invest negative amount or 0 money, user can't be able to choose date previous than today's date, user can't be able to invest for outdated projects. Inactive feature was added, so that if user is inactive on site, after 15 minutes he will be redirected to sign in page. Accumulated bar graph was created to give overall statistics for all projects such as how much amount was invested and how much remains. Project owner can see Pie Chart graph with the percentage of invested and remained amount for his project and also can see a progress bar with animation which gives good understanding of project. Also second bar graph was added to easily see contributors and their contribution to the project in addition to the table. All graphs are dynamic, so if user invests in one project, values in graphs also will be changed. Site is fully secured and real_escape_string was used in post data to make data safe before sending a query to MySQL. Data such as the idProject in URL of the page was anonymized with function which creates random characters and PHP mysqli class was used. For Front-End an internal CSS was used to define a style for most of the pages.

