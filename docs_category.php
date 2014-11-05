<h1><?php echo $category; ?></h1>

<?php
    if ($category === 'details') {
?>
    <p>
        Returns all of the 'details' attributes.
    </p>
<?php        
    }
    elseif ($category === 'social') {
?>
    <p>
        Returns all of the 'social' attributes.
    </p>
<?php        
    }
    elseif ($category === 'miscellaneous') {
?>
    <p>
        Returns all of the 'miscellaneous' attributes.
    </p>
<?php
    }
?>