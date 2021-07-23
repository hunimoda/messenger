<a class="link-to-chatroom" href="./chatting.php?friend_no=<?php echo $user['user_no']; ?>&friend_name=<?php echo $user_name; ?>">
    <div class="user__row">
        <div class="user__column">
            <img class="user__image <?php if ($user['user_id'] == $_SESSION['userid']) echo 'user__image--large'; ?>" src="https://picsum.photos/id/<?php echo $user['user_no']; ?>0/300/300.jpg">
        </div>
        <div class="user__column">
            <div class="user__subrow">
                <h2 class="user__name">
                    <?php echo $user_name; ?>
                </h2>
            </div>
            <div class="user__subrow">
                <p class="user__message <?php if (!$user_message) echo 'user__message--no-margin'; ?>">
                    <?php echo $user_message; ?>
                </p>
            </div>
        </div>
    </div>
</a>