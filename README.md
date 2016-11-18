#### Restaurant_health-inspection_CMPE226-
EATSOME in SF is a web application, which allows the restaurant business users to analyze how well the restaurant is doing,
 from there past inspections or violations. 
 This analysis will give business user’s a chance to view the history of their examinations in order to help them in improvise with their business so that they could gain more profits and attract more consumers. 
 This application also helps the consumers get an idea of how hygienic the food is at particular restaurant in SF. 


The Health Department has developed an inspection report and scoring system. 
After conducting an inspection of the facility, the Health Inspector calculates a score based on the violations observed. 
Violations can fall into 
####High-risk category : 
records specific violations that directly relate to the transmission of food borne illnesses, the adulteration of food products and the contamination of food-contact surfaces. 
####Moderate risk category: 
records specific violations that are of a moderate risk to the public health and safety. 
####Low risk category: 
records violations that are low risk or have no immediate risk to the public health and safety. 
The scorecards issued by the inspector are maintained at the food establishment and are available to the public in this dataset.

Depending on the score and violations, they might conduct follow-up inspections and revise their score. Every restaurant in San Francisco City has a yearly, surprise inspection in order to remain in operation. At inspection, points are assigned for every violation, dependent on violation type and category. The number of points is summed to the restaurant’s score.

We analyzed Violation, Inspection and Score information in relation to Business over different parameters with details obtained from the health inspection data set.

####TECHNOLOGY STACK AND DATA SET####

To develop the above described web application we have used the following technologies
•	HTML 5, CSS, JavaScript, JQUERY, AJAX, Bootstrap – front end
•	PHP – backend
•	MYSQL – data store
•	Apache web server – deployment server
•	Google chart API – charting library
¬	User invokes data operation through http request
¬	Web server serves the Web browser with dynamic and   static requests through PHP code running on server




####DATA SET####

We got this data set in the following below link

https://data.sfgov.org/Health-and-Social-Services/Restaurant-Scores/stya-26eb

Data was pretty much well organized, but it had lots of null values as well as redundancies. We had to clean the data and performed normalization. All our data tables are in 3rd normal form.
