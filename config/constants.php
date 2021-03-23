<?php

return [
    "generic_job_title" => "pmbot_generic",
    "generic_job_type" => "generic",
    "pageSize" => "25",
    "pageButtonCount" => 10,
    // "job_add_am_empcode" => "d.nethaji@spi-global.com",
    // "job_add_am_empname" => "Nethaji",
    "job_add_am_empcode" => "r.bharathidasan@spi-global.com",
    "job_add_am_empname" => "bharathi",
    "job_add_status" => "progress",
    "calendaf_task_count_label" => "Tasks",
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
        "quality" => "quality",
    ],
    "locationList" => [
        "pondy" => "pondy",
        "chennai" => "chennai",
        "manila" => "manila",
        "us" => "us"
    ],
    "reportType" => [
        "internal" => "Internal",
        "external" => "External",
        "both" => "Both",
    ],
    "projectType" => [
        "King" => "King",
        "Queen" => "Queen",
    ],
    "jobDefaultDueDateTime" => [
        "oup" => "24",
    ],
    "jobCategory" => [
        "low" => "low",
        "medium" => "medium",
        "high" => "high",
        "critical" => "critical"
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
        "7" => "archived",
        "55" => "outbox_wip",
        "99" => "undelivered",
    ],
    "emailClassificationMoveToList" => [
        [
            "id" => "0",
            "text" => "Please select"
        ],
        [
            "id" => "not_set",
            "text" => "not set"
        ],
        [
            "id" => "negative",
            "text" => "negative"
        ],
        [
            "id" => "positive",
            "text" => "positive"
        ],
        [
            "id" => "error",
            "text" => "error"
        ],
    ],
    "emailClassificationList" => [
        [
            "id" => "neutral",
            "text" => "neutral"
        ],
        [
            "id" => "negative",
            "text" => "negative"
        ],
        [
            "id" => "positive",
            "text" => "positive"
        ],
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
    "jobEditUserRoles" => [
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
    "qcUserRoles" => [
        "quality",
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
    "email_template_list" => [
        "template_1" => "Interim check-in on manuscript progress",
        "template_2" => "Manuscript preparation followup",
        "template_3" => "Tentative date",
        "template_4" => "Introduction email I",
        "template_5" => "Introduction email II",
        "template_6" => "Scheduled submission",
        "template_7" => "Feedback",
    ],
    "email_template_variables" => [
        "author_name" => "{{author_name}}",
        "author_email" => "{{author_email}}",
        "pm_name" => "{{pm_name}}",
        "pe_name" => "{{pe_name}}",
        "project_start_date" => "{{project_start_date}}",
        "pm_signature" => "{{pm_signature}}",
    ],
    "email_editor_style" => "<style>body {font-size: 11.0pt; font-family: Calibri; color: #1f497d;} p{margin: 0in; margin-bottom: .0001pt; font-size: 11.0pt; font-family: Calibri; color: #1F497D;} div{margin: 0in; margin-bottom: .0001pt; font-size: 11.0pt; font-family: Calibri; color: #1F497D;} table, table td, table th, table caption { border: 1px solid grey; border-spacing: 0px; } td, th { font-size: 11.0pt; font-family: Calibri; border: 1px solid grey; border-spacing: 0px; } .emailsig_block{margin: 0in; margin-bottom: .0001pt; font-size: 11.0pt; font-family: Calibri; color: #1F497D;}</style>",
    "sort_type_list" => [
        "newer" => "newest",
        "older" => "oldest",
        "random" => "random",
    ],
    "custom_urls" => [
        "job_add_url" => "http://localhost:81/pmbot/pmbotcustom/job-add-opm",
    ],
];
