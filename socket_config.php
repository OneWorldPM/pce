<?php

/**
 * Never use same name for two different instances of the apps or two different apps
 * In Socket IO backend, I uses user id from php app to match many things
 * So user id might be same for different users on different apps
 *
 * -Athul AK
 */

$config = array(
    "socket_app_name" => "CCS_dev_rexter", //eg; cco_dev_athul
    "socket_lounge_room" => "CCS_LOUNGE_GROUP_dev_rexter", //eg; cco_lounge_group_dev_athul
    "socket_lounge_oto_chat_group" => "CCS_LOUNGE_OTO_dev_rexter", //eg; cco_lounge_oto_dev_athul
    "socket_active_user_list" => "CCS_ACTIVE_USERS_dev_rexter" //eg; cco_active_users_dev_athul
);

echo json_encode($config);
