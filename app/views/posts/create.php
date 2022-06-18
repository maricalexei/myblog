<?php
require APPROOT . '/views/includes/head.php'
?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php'
    ?>
</div>
<div class="container center">
    <h1>
        Create new post
    </h1>

    <form action="<?php URLROOT ?>/posts/create" method="post">
        <div class="form-item">
            <input type="text" name="title" placeholder="Title...">
            <span class="invalidFeedback">
                <?php echo $data['titleError']; ?>
            </span>
        </div>
        <div class="form-item">
            <textarea name="body" placeholder="Enter your post..."></textarea>
            <span class="invalidFeedback">
                <?php echo $data['bodyError']; ?>
            </span>
        </div>

        <button class="btn green" name="submit" type="submit">Submit</button>
    </form>
</div>