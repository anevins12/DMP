# Sentiment from the holidays
This was a project for the final year of University to extract and conclude the nation's feelings on significant events such as Christmas day. 

## About the app
* The application was built in Codeigniter
* It used the 'ANEW' dataset (not commited) to quantify semtimental value for words in a string
* Tweets were scraped from Twitter consecutively during the Christmas holiday (UK) period
* For each tweet, the user and their location was scraped
* Tweets that were deemed either more happy or sad than normal were cherrypicked and collated into a visual infographic
* The majority of data was presented in an infographic depicted as a Bubble chart, which used size as quantity

## Key files
* Controller for processing infographic view: https://github.com/anevins12/DMP/blob/master/application/controller/tweets.php
* View for infographic that utilises D3 library: https://github.com/anevins12/DMP/blob/master/application/view/all/index.php


