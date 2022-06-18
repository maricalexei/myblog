<nav class="top-nav">
<ul>
    <li>
        <a href="<?php echo URLROOT ?>/pages/index">Home</a>
    </li>
    <li>
        <a href="<?php echo URLROOT ?>/pages/about">About</a>
    </li>
    <li>
        <a href="<?php echo URLROOT ?>/pages/projects">Projects</a>
    </li>
    <li>
        <a href="<?php echo URLROOT ?>/posts/index">Posts</a>
    </li>
    <li>
        <a href="<?php echo URLROOT ?>/pages/contact">Contact</a>
    </li>
    <li class="btn-login">
        <?php if(isset($_SESSION['user_id'])) :  ?>
        <a href="<?php echo URLROOT ?>/users/logout">log out</a>
        <?php else : ?>
        <a href="<?php echo URLROOT ?>/users/login">log in</a>
        <?php endif ?>
    </li>
</ul>
</nav>