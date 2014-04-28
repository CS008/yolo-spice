<nav>
    <ol>
        <?php
        if ($path_parts['filename'] == "home") {
            print '<li class="activePage">Home</li>';
        }
        else {
            print '<li><a href="home.php">Home</a></li>';
        }
        
        if ($path_parts['filename'] == "adrian") {
            print '<li class="activePage">Adrian\'s Reviews</li>';
        }
        else {
            print '<li><a href="adrian.php">Adrian\'s Reviews</a></li>';
        }
        
        if ($path_parts['filename'] == "bill") {
            print '<li class="activePage">Bill\'s Reviews</li>';
        }
        else {
            print '<li><a href="bill.php">Bill\'s Reviews</a></li>';
        }
        
        if ($path_parts['filename'] == "mike") {
            print '<li class="activePage">Michael\'s Reviews</li>';
        }
        else {
            print '<li><a href="mike.php">Michael\'s Review</a></li>';
        }
        
        if ($path_parts['filename'] == "contact-us") {
            print '<li class="activePage">Contact Us!</li>';
        }
        else {
            print '<li><a href="contact-us.php">Contact Us!</a></li>';
        }
        
        if ($path_parts['filename'] == "comments") {
            print '<li class="activePage">LEAVE A CMOMONATN</li>';
        }
        else {
            print '<li><a href="comments.php">Comments</a></li>';
        }

        ?>
    </ol>
</nav>
