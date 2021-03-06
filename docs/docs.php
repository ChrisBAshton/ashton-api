<?php
require '../header.php';
?>
<nav class="api_nav">
    <ul>
        <li>
            <a href="/docs/">Home</a>
        </li>
        <ul>
            <?php
                $categories = yaml_parse(file_get_contents(__DIR__ . '/../config/config.yml'));

                foreach($categories as $cat => $attrs) {

                    echo '<li><a href="/docs/' . $cat . '/">' . $cat . '</a></li>';

                    echo '<ul>';
                    foreach ($attrs as $attr => $attrValues) {
                        echo '<li><a href="/docs/' . $cat . '/' . $attr . '/">' . $attr . '</a></li>';
                    }
                    echo '</ul>';
                }
            ?>
        </ul>
    </ul>
</nav>

<article>
    <?php
        documentation_breadcrumb($category, $attribute);

        if (!$category) {
            include 'docs_index.php';
        }

        elseif (!$attribute) {
            include 'docs_category.php';
        }

        else {
            include 'docs_attribute.php';
        }

        api_call($category, $attribute);
    ?>
</article>

<?php

function documentation_breadcrumb($category, $attribute) {

    $baseUrl = '/docs';

    if (!$category) {
        echo "";
    }
    elseif (!$attribute) {
        echo "<a href='" . $baseUrl . "/'>Documentation</a> &gt; " . $category;
    }
    else {
        echo "<a href='" . $baseUrl . "/'>Documentation</a> &gt; <a href='" . $baseUrl . "/" . $category . "/'>" . $category . "</a> &gt; " . $attribute;
    }
}

function api_call($category, $attribute) {

    $api = 'https://api.ashton.codes/get';

    if (!$category) {
       return false;
    }
    elseif (!$attribute) {
        $api = $api . "/" . $category;
    }
    else {
        $api = $api . "/" . $category . "/" . $attribute;
    }

    $api = $api . "/?key=YOUR_API_KEY&type=DATA_TYPE";

    echo "<h3>Usage</h3>";
    echo "<code>" . $api . "</code>";
}

?>
<?php
require '../footer.php';
?>
