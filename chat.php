<a href="./chatting.php?friend_no=<?php echo $friend_userno; ?>&friend_name=<?php echo $friend_name; ?>" class="link-to-chatroom">
    <div class="user__row">
        <div class="user__column">
            <img class="user__image user__image--medium" src="<?php echo $image; ?>">
        </div>
        <div class="user__column">
            <div class="user__subrow">
                <h2 class="user__name">
                    <?php echo $friend_name; ?>
                </h2>
                <span class="chat__last-timestamp">
                    <?php
                        $display_time = '';
                        $exploded_date = explode(' ', $last_timestamp);
                        
                        $last_date = $exploded_date[0];
                        $current_date = date('Y-m-d');
                        
                        $date_diff = date_diff(new DateTime($current_date), new DateTime($last_date))->format("%a");
                        $year_diff = date_diff(new DateTime($current_date), new DateTime($last_date))->format("%y");
                        
                        $year = date("Y", strtotime($last_timestamp));
                        $month = date("m", strtotime($last_timestamp));
                        $date = date("d", strtotime($last_timestamp));

                        if ($date_diff <= 0) {            
                            $hour = date("H", strtotime($last_timestamp));
                            $minute = date("i", strtotime($last_timestamp));
                            
                            if ($hour < 12)
                            $display_time = "오전 ".ltrim($hour, '0')."시 {$minute}분";
                            else if ($hour == 12)
                            $display_time = "오후 {$hour}시 {$minute}분";
                            else
                            $display_time = "오후 ".($hour - 12)."시 {$minute}분";
                        }
                        else if ($date_diff == 1)
                            $display_time = "어제";
                        else if ($year_diff == 0) {
                            $display_time = ltrim($month, '0')."월 {$date}일";
                        }
                        else
                            $display_time = "$year.$month.$date";

                        echo $display_time;
                    ?>
                    <!-- (오늘일 경우)          오후 8시 35분 -->
                    <!-- (어제일 경우)          어제 -->
                    <!-- (동해 2일 이상 전)     7월 17일  -->
                    <!-- 작년 이전              2020.07.17 -->
                </span>
            </div>
            <div class="user__subrow">
                <p class="user__message chat__message">
                    <?php echo $last_message; ?>
                </p>
                <div class="new-message-count"></div>
            </div>
        </div>
    </div>
</a>