<div class="horizontal">
<nav>
    <ol>
        <?php
        if ($path_parts['filename'] == "home") {
            print '<li><a href="home.php">Home Page</a></li>';
        }
        else {
            print '<li><a href="home.php">Home Page</a></li>';
        }
        
        if ($path_parts['filename'] == "adrian") {
            print '<li><a href="adrian.php">Adrian\'s Reviews</a></li>';
        }
        else {
            print '<li><a href="adrian.php">Adrian\'s Reviews</a></li>';
        }
        
        if ($path_parts['filename'] == "bill") {
            print '<li><a href="bill.php">Bill\'s Reviews</a></li>';
        }
        else {
            print '<li><a href="bill.php">Bill\'s Reviews</a></li>';
        }
        
        if ($path_parts['filename'] == "mike") {
            print '<li><a href="mike.php">Michael\'s Reviews</a></li>';
        }
        else {
            print '<li><a href="mike.php">Michael\'s Reviews</a></li>';
        }
        
        if ($path_parts['filename'] == "contact-us") {
print '<li><a href="contact-us.php">Contact Us!</a></li>';        }
        else {
            print '<li><a href="contact-us.php">Contact Us!</a></li>';
        }
        
        if ($path_parts['filename'] == "comments") {
            print '<li><a href="comments.php">Comment Page</a></li>';
        }
        else {
            print '<li><a href="comments.php">Comment Page</a></li>';
        }

        ?>
    </ol>
</nav>
</div>