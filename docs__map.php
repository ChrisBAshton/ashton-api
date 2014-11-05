<?php

$categories = array(
    "details" => array(
        "name" => array(
            "description" => "My name.",
            "returns" => "string"
        ),
        "location" => array(
            "description" => "My current location.",
            "returns" => "string"
        ),
        "availability" => array(
            "description" => "My current work availability.",
            "returns" => "string"
        ),
        "resume" => array(
            "description" => "My resume, pulled in directly from the 'Summary' section of my LinkedIn profile.",
            "returns" => "string"
        ),
        "blogTitle" => array(
            "description" => "Title of my latest blog.",
            "returns" => "string"
        ),
        "blogExcerpt" => array(
            "description" => "Excerpt from my latest blog.",
            "returns" => "string"
        ),
        "picture" => array(
            "description" => "URL to my <a href='http://en.gravatar.com/' target='_blank'>Gravatar</a> profile picture.",
            "returns" => "string"
        )
    ),
    "social" => array(
        "tweet" => array(
            "description" => "My latest Tweet.",
            "returns" => "string"
        ),
        "twitter" => array(
            "description" => "URL to my Twitter profile.",
            "returns" => "string"
        ),
        "linkedin" => array(
            "description" => "URL to my LinkedIn profile.",
            "returns" => "string"
        ),
        "github" => array(
            "description" => "URL to my GitHub profile.",
            "returns" => "string"
        )
    ),
    "miscellaneous" => array(
        "codingdays" => array(
            "description" => "Number of days (approx.) since I began coding. I remember using HTML and PHP to make websites back in January 2009, so this figure is based loosely on that date. That said, I've played around with HTML and CSS since about 2005.",
            "returns" => "int"
        ),
        "daysuntilgraduation" => array(
            "description" => "Number of days until I graduate. One day this will be a negative figure and my API will crash and burn.",
            "returns" => "int"
        )
    )
);