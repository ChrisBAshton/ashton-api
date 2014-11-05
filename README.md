# Ashton API

Welcome to my API, official website at http://api.ashton.codes/. There are 3 main sections:

## api_read

Handles taking a key and checking user is authorised, before grabbing the cached JSON file and returning the requested category/attribute.

## api_write

cron.php is run every 10 minutes. This grabs all my latest data (e.g. latest Tweet, LinkedIn Summary, etc) and stores the data as a JSON file under data/chris.json, which is gitignored because the version on Git would be constantly out of date.

## Top level files

* _process.php - interprets the URL and passes parameters to the appropriate template.
* docs.php - renders the documentation
* get.php - gets the requested attribute(s)

## What isn't in this repo?

* api_read/api_keys.php - contains the API keys people can use to call the API. Yes, that's just me so far.
* api_write/linkedin/linkedin.php - contains my LinkedIn OAuth keys.
* api_write/twitter/twitter.php - contains my Twitter OAuth keys.