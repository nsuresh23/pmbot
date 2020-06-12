<?php

return [
    "generic_job_title" => "pmbot_generic",
    "generic_job_type" => "generic",
    // "job_add_am_empcode" => "d.nethaji@spi-global.com",
    // "job_add_am_empname" => "Nethaji",
    "job_add_am_empcode" => "R.Bharathidasan@spi-global.com",
    "job_add_am_empname" => "Bharathi",
    "job_add_status" => "pending",
    "emailImageDownloadPathParams" => "?fileserver=2&img_path=",
    "stageList" => [
        "s5" => "s5",
        "s50" => "s50",
        "s200" => "s200",
        "s300" => "s300",
        "s600" => "s600",
        "s650" => "s650",
    ],
    "roleList" => [
        // "art" => "art",
        // "bot" => "bot",
        // "admin" => "admin",
        "external" => "external",
        // "logistics" => "logistics",
        // "production" => "production",
        // "copy_editing" => "copy_editing",
        "account_manager" => "account_manager",
        "project_manager" => "project_manager",
    ],
    "locationList" => [
        "pondy" => "pondy",
        "chennai" => "chennai"
    ],
    "projectType" => [
        "King" => "King",
        "Queen" => "Queen",
    ],
    "jobDefaultDueDateTime" => [
        "oup" => "24",
    ],
    "taskCategory" => [
        "low" => "low",
        "medium" => "medium",
        "high" => "high",
        "critical" => "critical"
    ],
    "taskCategoryFollowupTime" => [
        "low" => "24",
        "medium" => "16",
        "high" => "8",
        "critical" => "4"
    ],
    "taskStatus" => [
        "pending" => "pending",
        "progress" => "progress",
        // "completed" => "completed",
        "hold" => "hold",
        "closed" => "closed",
    ],
    "taskType" => [
        "task" => "task",
        "inhouse_query" => "inhouse query",
        "external_query" => "external query",
        "pm_instruction" => "PM instruction",
        "pe_instruction" => "PE instruction",
    ],
    "jobCheckListStatus" => [
        "pending" => "pending",
        "progress" => "progress",
        "completed" => "completed",
        "hold" => "hold",
        "deleted" => "deleted",
    ],
    "emailStatus" => [
        "0" => "pending",
        "1" => "partial",
        "2" => "completed",
        "3" => "non_pmbot",
		"4" => "draft",
		"5" => "outbox",
		"6" => "sent",
    ],
    "stateList" => [
        "1" => "enabled",
        "0" => "disabled",
    ],
    "nonStakeHolderUserRoles" => [
        "admin",
        "project_manager",
        "account_manager",
    ],
    "globalCheckListAddUserRoles" => [
        "account_manager",
    ],
    "jobCheckListAddUserRoles" => [
        "project_manager",
        "account_manager",
    ],
    "taskFollowupResetUserRoles" => [
        "project_manager",
        "account_manager",
    ],
    "writeAccessUserRoles" => [
        "admin",
        "project_manager",
        "account_manager",
    ],
    "shUserRoles" => [
        "art",
        "logistics",
        "production",
        "copy_editing",
    ],
    "pmUserRoles" => [
        "project_manager",
    ],
    "amUserRoles" => [
        "account_manager",
    ],
    "adminUserRoles" => [
        "admin",
    ],
    "jobHistory" => [
        "receivedTables" => [
            "job"
        ],
        "createdTables" => [
            "task",
            "check_list",
            "task_note",
            "task_check_list",
            "task_additional_note",
        ],
        "changedTables" => [
            "job_history",
            "task_history",
            "checklist_history",
            "task_note_history",
            "task_check_list_history",
            "task_additional_note_history",
        ],
    ],
    "custom_urls" => [
        "job_add_url" => "http://localhost:81/pmbot/pmbotcustom/job-add-opm",
    ],
];
