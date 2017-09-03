# Ashton API

Welcome to my API, official website at http://api.ashton.codes/. The API drives much of https://ashton.codes, through its two features: REST API and OEmbed.

## RESTful API

The API follows this pattern:

`http://api.ashton.codes/[METHOD]/[CATEGORY]/[ATTRIBUTE]/`

* Method can be `docs` (to view API docs) or `get` to actually call the API
* Category is currently either `details`, `social` or `miscellaneous`
* Attribute is a specific unit of data under the category, e.g. `details => blogUrl`

Example:

http://api.ashton.codes/docs/details/description/

This is the documentation page for the `description` attribute.

http://api.ashton.codes/get/details/description/?key=[YOUR_KEY]&format=[FORMAT - optional]

This is calling the API. You can request an API key via [GitHub Issues](https://github.com/ChrisBAshton/ashton-api/issues).

You can specify a format for your data: currently JSON (default), XML or CSV.

## OEmbed

In progress. Provides iframed content you can include on your website.

http://api.ashton.codes/oembed/?url=http://api.ashton.codes/card/instagram

## Directory structure

The `api` directory contains the business logic for updating the cached version of the data (called via a cron job every 10 minutes) and the authentication logic for being read from.

`config` describes the REST categories & attributes so that I can follow the DRY principle, and also specifies the (publicly inaccessible) location of the cached API contents.

`docs` contains the HTML which renders the API docs. Also contains `get.php` which is called when the API is called. I should probably move this somewhere better.

`oembed` contains the OEmbed logic and templates.

`private` is git-ignored and should be uploaded to the private location on the server as specified in `config/paths.yml`. It contains the Ashton API keys as well as keys & tokens used by the underlying Ashton API for third-party services such as Twitter.
