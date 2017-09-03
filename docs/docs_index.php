<h1>Documentation</h1>

<h2>Get started</h2>

<p>
    To get started, you'll need to <a href="http://ashton.codes/contact/">request an API key</a>. An API key will be generated for you and emailed to you within a week, provided I'm not on holiday!
</p>

<p>
    This documentation mirrors the API calls exactly. For example, clicking on 'details' will take you to:

    <code>http://api.ashton.codes/docs/details/</code>

    To actually get 'details', simply replace 'docs' with 'get', and append your API key:

    <code>http://api.ashton.codes/get/details/?key=YOUR_API_KEY</code>
</p>

<h2>Data formats</h2>

<p>
    Return values can be encoded as json (default), xml, or csv - simply append the required datatype to the end of the URL, e.g.

    <code>http://api.ashton.codes/get/miscellaneous/codingDays/?key=YOUR_API_KEY&amp;type=xml</code>
</p>

<h2>Up-to-dateness</h2>

<p>
    Ok, that's a horrible heading, but can you think of a better alternative?
</p>

<p>
    The API return values are precalculated, and are updated once every 10 minutes. Therefore the return values can be up to 10 minutes out of date. Just give it a few minutes to catch up then try again.
</p>

<p>
    Why the precalculated values? The API has several external dependencies, such as Twitter and LinkedIn. These services have been known to go down, so rather than risk bringing down the API I decided to cache values regularly instead. This also makes for a much faster API call.
</p>

<h2>Usage limits</h2>

<p>
    At the moment, there is no usage limit - your API key grants you unlimited access to the API.
</p>