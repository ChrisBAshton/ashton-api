<h1><?php echo $attribute ?></h1>

<?php
    foreach ($categories as $categoryName => $attributes) {
        foreach ($attributes as $attributeName => $attr) {
            if ($attribute == $attributeName) {
                echo "<h3>Description</h3>";
                echo "<p>" . $attr['description'] . "</p>";
                echo "<h3>Return type</h3>";
                echo "<p>" . $attr['returns'] . "</p>";
                break;
            }
        }
    }
?>
