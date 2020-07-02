$(function() {

    function getMemberList(gridSelector) {

        var gridType = $(gridSelector).attr('data-type');
        var gridCategory = $(gridSelector).attr('data-category');
        var currentUserId = $(gridSelector).attr('data-current-user-id');
        var listUrl = $(gridSelector).attr('data-list-url');
        var currentRoute = $(gridSelector).attr('data-current-route');

        var dbClients = "";

        if ($(gridSelector + ' .jsgrid-grid-header').attr('class') == undefined) {

            $(gridSelector).jsGrid({

                height: "450px",
                width: "100%",

                filtering: false,
                inserting: false,
                editing: false,
                sorting: true,
                paging: false,
                autoload: false,

                pageSize: 10,
                pageButtonCount: 5,

                // deleteConfirm: "Do you really want to delete the client?",

                confirmDeleting: false,

                noDataContent: "No data",

                invalidNotify: function(args) {

                    $('#alert-error-not-submit').removeClass('hidden');

                },

                loadIndication: true,
                // loadIndicationDelay: 500,
                loadMessage: "Please, wait...",
                loadShading: true,

                controller: {

                    loadData: function(filter) {

                        return $.grep(dbClients, function(client) {
                            return (!filter.email || (client.email != undefined && client.email != null && (client.email.toLowerCase().indexOf(filter.email.toLowerCase()) > -1))) &&
                                (!filter.role || (client.role != undefined && client.role != null && (client.role.toLowerCase().indexOf(filter.role.toLowerCase()) > -1)));
                        });

                    }
                },


                rowClass: function(item, itemIndex) {

                },

                rowClick: function(args) {

                    $(gridSelector).jsGrid("cancelEdit");

                },

            });

        }

        var field = [];

        // field.push({
        //     title: "S.NO",
        //     name: "s_no",
        //     type: "number",
        //     inserting: false,
        //     filtering: false,
        //     editing: false,
        //     width: 20
        // });

        field.push({
            title: "Email",
            name: "email",
            type: "text",
        });

        field.push({
            title: "Role",
            name: "role",
            type: "text",
        });

        field.push({
            type: "control",
            name: "Control",
            editButton: false,
            deleteButton: false,
            headerTemplate: function() {

                return this._createOnOffSwitchButton("filtering", this.searchModeButtonClass, false);

            },
            // width: 10,
        });

        $(gridSelector).jsGrid("option", "fields", field);

        var memberListPostData = {};

        // if (currentUserId != undefined && currentUserId != '') {

        //     memberListPostData.empcode = currentUserId;

        // }

        /* AJAX call to get list */
        $.ajax({

            url: listUrl,
            data: memberListPostData,
            dataType: "json"

        }).done(function(response) {

            if (response.success == "true") {

                response.data = formatDataItem(response.data);

                dbClients = response.data;

                $(gridSelector).jsGrid("option", "data", response.data);

                $('.jsgrid-grid-body').slimscroll({
                    height: '300px',
                });

            }

        });

        function formatDataItem(dataValue) {

            if (dataValue.length > 0) {

                for (var i = 0, len = dataValue.length; i < len; i++) {

                    dataValue[i].s_no = i + 1;

                }

            }

            return dataValue;

        }

    }

    $(document).on('click', '#membersTab', function() {

        var gridSelector = ".membersGrid";

        var dataUrl = $(gridSelector).attr('data-list-url');

        // dataUrl = "fd";

        if (dataUrl != undefined && dataUrl != "") {

            getMemberList(gridSelector);

            if ($('.membersTab').attr('class') != undefined) {

                $('.membersTab').show();

            }

        }

    });

    $(document).on('click', '.member-job-count-item', function() {

        var dataUrl = $('.membersGrid').attr('data-member-job-count-url');

        var empcode = $(this).attr('data-member-empcode');

        // var dataUrl = $(this).attr('data-list-url');

        // dataUrl = "fd";

        if (dataUrl != undefined && dataUrl != "") {

            getMemberJobCount(dataUrl, empcode);

        }

    });

});

function getMemberJobCount(memberJobCountUrl, empcode) {

    if (memberJobCountUrl != undefined && memberJobCountUrl != '' && empcode != undefined && empcode != '') {

        jobOverViewCountReset();

        var memberPostData = {};

        memberPostData.empcode = empcode;

        // if (currentUserId != undefined && currentUserId != '') {

        //     memberListPostData.empcode = currentUserId;

        // }

        /* AJAX call to get list */
        $.ajax({

            url: memberJobCountUrl,
            data: memberPostData,
            dataType: "json"

        }).done(function(response) {

            if (response.success == "true") {

                jobOverViewCountUpdate(response);

                if ($('.selected-member-header').attr('class') != undefined) {

                    if (empcode != undefined && empcode != '' && empcode != 'overview') {

                        $('.selected-member-header').text(empcode);

                        $('.selected-member-header-block').show();

                    }

                }

            }

        });

    }

}

function jobOverViewCountReset() {

    if ($('.selected-member-header').attr('class') != undefined) {

        $('.selected-member-header').text('');

        $('.selected-member-header-block').hide();

    }

    if ($('.jobs-inhand').attr('class') != undefined) {

        if ($('.jobs-inhand').attr('data-count') != undefined) {

            $('.jobs-inhand').attr('data-count', '0');

        }

        if ($('.jobs-inhand-count').attr('class') != undefined) {

            $('.jobs-inhand-count').text('0');

        }

    }

    if ($('.jobs-ontrack').attr('class') != undefined) {

        if ($('.jobs-ontrack').attr('data-count') != undefined) {

            $('.jobs-ontrack').attr('data-count', '0');

        }

        if ($('.jobs-ontrack-count').attr('class') != undefined) {

            $('.jobs-ontrack-count').text('0');

        }

        if ($('.jobs-ontrack-task-count').attr('class') != undefined) {

            $('.jobs-ontrack-task-count').text('0');

        }

        if ($('.jobs-ontrack-checklist-count').attr('class') != undefined) {

            $('.jobs-ontrack-checklist-count').text('0');

        }

    }

    if ($('.jobs-delay').attr('class') != undefined) {

        if ($('.jobs-delay').attr('data-count') != undefined) {

            $('.jobs-delay').attr('data-count', '0');

        }

        if ($('.jobs-delay-count').attr('class') != undefined) {

            $('.jobs-delay-count').text('0');

        }

        if ($('.jobs-delay-task-count').attr('class') != undefined) {

            $('.jobs-delay-task-count').text('0');

        }

        if ($('.jobs-delay-checklist-count').attr('class') != undefined) {

            $('.jobs-delay-checklist-count').text('0');

        }

    }

    if ($('.jobs-hold').attr('class') != undefined) {

        if ($('.jobs-hold').attr('data-count') != undefined) {

            $('.jobs-hold').attr('data-count', '0');

        }

        if ($('.jobs-hold-count').attr('class') != undefined) {

            $('.jobs-hold-count').text('0');

        }

        if ($('.jobs-hold-task-count').attr('class') != undefined) {

            $('.jobs-hold-task-count').text('0');

        }

        if ($('.jobs-hold-checklist-count').attr('class') != undefined) {

            $('.jobs-hold-checklist-count').text('0');

        }

    }

    if ($('.jobs-appreciation').attr('class') != undefined) {

        if ($('.jobs-appreciation').attr('data-count') != undefined) {

            $('.jobs-appreciation').attr('data-count', '0');

        }

        if ($('.jobs-appreciation-count').attr('class') != undefined) {

            $('.jobs-appreciation-count').text('0');

        }

    }

    if ($('.jobs-escalation').attr('class') != undefined) {

        if ($('.jobs-escalation').attr('data-count') != undefined) {

            $('.jobs-escalation').attr('data-count', '0');

        }

        if ($('.jobs-escalation-count').attr('class') != undefined) {

            $('.jobs-escalation-count').text('0');

        }

        if ($('.jobs-escalation-stakeholders-count').attr('class') != undefined) {

            $('.jobs-escalation-stakeholders-count').text('0');

        }

        if ($('.jobs-escalation-pm-count').attr('class') != undefined) {

            $('.jobs-escalation-pm-count').text('0');

        }

        if ($('.jobs-escalation-nonspi-count').attr('class') != undefined) {

            $('.jobs-escalation-nonspi-count').text('0');

        }

    }

    if ($('.jobs-completed').attr('class') != undefined) {

        if ($('.jobs-completed').attr('data-count') != undefined) {

            $('.jobs-completed').attr('data-count', '0');

        }

        if ($('.jobs-completed-count').attr('class') != undefined) {

            $('.jobs-completed-count').text('0');

        }

        if ($('.jobs-completed-ontime-count').attr('class') != undefined) {

            $('.jobs-completed-ontime-count').text('0');

        }

        if ($('.jobs-completed-ahead-count').attr('class') != undefined) {

            $('.jobs-completed-ahead-count').text('0');

        }

        if ($('.jobs-completed-delay-count').attr('class') != undefined) {

            $('.jobs-completed-delay-count').text('0');

        }

    }

}

function jobOverViewCountUpdate(response) {

    if (response != undefined && 'data' in response) {

        var responseData = response.data;

        if ('inhand' in responseData) {

            var inhandResponseData = responseData.inhand;

            if ($('.jobs-inhand').attr('class') != undefined) {

                if ('count' in inhandResponseData) {

                    if ($('.jobs-inhand').attr('data-count') != undefined) {

                        $('.jobs-inhand').attr('data-count', inhandResponseData.count);

                    }

                    if ($('.jobs-inhand-count').attr('class') != undefined) {

                        $('.jobs-inhand-count').text(inhandResponseData.count);

                    }

                }

            }

        }

        if ('ontrack' in responseData) {

            var ontrackResponseData = responseData.ontrack;

            if ($('.jobs-ontrack').attr('class') != undefined) {

                if ('count' in ontrackResponseData) {

                    if ($('.jobs-ontrack').attr('data-count') != undefined) {

                        $('.jobs-ontrack').attr('data-count', ontrackResponseData.count);

                    }

                    if ($('.jobs-ontrack-count').attr('class') != undefined) {

                        $('.jobs-ontrack-count').text(ontrackResponseData.count);

                    }

                }

                if ('task_count' in ontrackResponseData) {

                    if ($('.jobs-ontrack-task-count').attr('class') != undefined) {

                        $('.jobs-ontrack-task-count').text(ontrackResponseData.task_count);

                    }

                }

                if ('job_checklist_count' in ontrackResponseData) {

                    if ($('.jobs-ontrack-checklist-count').attr('class') != undefined) {

                        $('.jobs-ontrack-checklist-count').text(ontrackResponseData.job_checklist_count);

                    }

                }

            }

        }

        if ('delay' in responseData) {

            var delayResponseData = responseData.delay;

            if ($('.jobs-delay').attr('class') != undefined) {

                if ('count' in delayResponseData) {

                    if ($('.jobs-delay').attr('data-count') != undefined) {

                        $('.jobs-delay').attr('data-count', delayResponseData.count);

                    }

                    if ($('.jobs-delay-count').attr('class') != undefined) {

                        $('.jobs-delay-count').text(delayResponseData.count);

                    }

                }

                if ('task_count' in delayResponseData) {

                    if ($('.jobs-delay-task-count').attr('class') != undefined) {

                        $('.jobs-delay-task-count').text(delayResponseData.task_count);

                    }

                }

                if ('job_checklist_count' in delayResponseData) {

                    if ($('.jobs-delay-checklist-count').attr('class') != undefined) {

                        $('.jobs-delay-checklist-count').text(delayResponseData.job_checklist_count);

                    }

                }

            }

        }

        if ('hold' in responseData) {

            var holdResponseData = responseData.hold;

            if ($('.jobs-hold').attr('class') != undefined) {

                if ('count' in holdResponseData) {

                    if ($('.jobs-hold').attr('data-count') != undefined) {

                        $('.jobs-hold').attr('data-count', holdResponseData.count);

                    }

                    if ($('.jobs-hold-count').attr('class') != undefined) {

                        $('.jobs-hold-count').text(holdResponseData.count);

                    }
                }

                if ('task_count' in holdResponseData) {

                    if ($('.jobs-hold-task-count').attr('class') != undefined) {

                        $('.jobs-hold-task-count').text(holdResponseData.task_count);

                    }

                }

                if ('job_checklist_count' in holdResponseData) {

                    if ($('.jobs-hold-checklist-count').attr('class') != undefined) {

                        $('.jobs-hold-checklist-count').text(holdResponseData.job_checklist_count);

                    }

                }

            }

        }

        if ('appreciation' in responseData) {

            var appreciationResponseData = responseData.appreciation;

            if ($('.jobs-appreciation').attr('class') != undefined) {

                if ('count' in appreciationResponseData) {

                    if ($('.jobs-appreciation').attr('data-count') != undefined) {

                        $('.jobs-appreciation').attr('data-count', appreciationResponseData.count);

                    }

                    if ($('.jobs-appreciation-count').attr('class') != undefined) {

                        $('.jobs-appreciation-count').text(appreciationResponseData.count);

                    }

                }

            }

        }

        if ('escalation' in responseData) {

            var escalationResponseData = responseData.escalation;

            if ($('.jobs-escalation').attr('class') != undefined) {

                if ('count' in escalationResponseData) {

                    if ($('.jobs-escalation').attr('data-count') != undefined) {

                        $('.jobs-escalation').attr('data-count', escalationResponseData.count);

                    }

                    if ($('.jobs-escalation-count').attr('class') != undefined) {

                        $('.jobs-escalation-count').text(escalationResponseData.count);

                    }

                }

                if ('stakeholders_count' in escalationResponseData) {

                    if ($('.jobs-escalation-stakeholders-count').attr('class') != undefined) {

                        $('.jobs-escalation-stakeholders-count').text(escalationResponseData.stakeholders_count);

                    }

                }

                if ('pm_count' in escalationResponseData) {

                    if ($('.jobs-escalation-pm-count').attr('class') != undefined) {

                        $('.jobs-escalation-pm-count').text(escalationResponseData.pm_count);

                    }

                }

                if ('nonspi_count' in escalationResponseData) {

                    if ($('.jobs-escalation-nonspi-count').attr('class') != undefined) {

                        $('.jobs-escalation-nonspi-count').text(escalationResponseData.nonspi_count);

                    }

                }

            }

        }

        if ('completed' in responseData) {

            var completedResponseData = responseData.completed;

            if ($('.jobs-completed').attr('class') != undefined) {

                if ('count' in completedResponseData) {

                    if ($('.jobs-completed').attr('data-count') != undefined) {

                        $('.jobs-completed').attr('data-count', completedResponseData.count);

                    }

                    if ($('.jobs-completed-count').attr('class') != undefined) {

                        $('.jobs-completed-count').text(completedResponseData.count);

                    }

                }


                if ('ontime_count' in completedResponseData) {

                    if ($('.jobs-completed-ontime-count').attr('class') != undefined) {

                        $('.jobs-completed-ontime-count').text(completedResponseData.ontime_count);

                    }

                }

                if ('ahead_count' in completedResponseData) {

                    if ($('.jobs-completed-ahead-count').attr('class') != undefined) {

                        $('.jobs-completed-ahead-count').text(completedResponseData.ahead_count);

                    }

                }

                if ('delay_count' in completedResponseData) {

                    if ($('.jobs-completed-delay-count').attr('class') != undefined) {

                        $('.jobs-completed-delay-count').text(completedResponseData.delay_count);

                    }

                }

            }

        }

    }

}
