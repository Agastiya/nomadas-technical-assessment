@if($entry->status == "pending")
    <a href="javascript:void(0)" onclick="openProcessModal({{ $entry->id }})"
        class="btn btn-sm btn-link text-primary">
        <i class="la la-tasks"></i> Process
    </a>
@endif

<script>
    function openProcessModal(id) {
        swal({
            title: 'Process Request',
            text: "Choose action for this loan request",
            icon: 'info',
            buttons: {
                approve: {
                    text: 'Approve',
                    value: 'approve',
                    visible: true,
                    className: "bg-success",
                },
                reject: {
                    text: 'Reject',
                    value: 'reject',
                    visible: true,
                    className: "bg-danger",
                },
                cancel: {
                    text: 'Cancel',
                    value: null,
                    visible: true,
                    className: "bg-secondary",
                },
            },
        }).then((value) => {
            if (value === 'approve') {
                executeAjax(id, 'approved');
            } else if (value === 'reject') {
                swal({
                    title: 'Reason',
                    content: {
                        element: "textarea",
                        attributes: {
                            placeholder: "Enter the reason",
                            rows: 5,
                        },
                    },
                    buttons: {
                        submitReject: {
                            text: 'Submit Reject',
                            value: 'submit_reject',
                            visible: true,
                            className: "bg-danger",
                        },
                        cancelReject: {
                            text: 'Cancel',
                            value: null,
                            visible: true,
                            className: "bg-secondary",
                        },
                    },
                }).then((reason) => {
                    if (reason === 'submit_reject') {
                        const rejectReason = document.querySelector('.swal-content textarea').value;
                        if (!rejectReason) {
                            swal.showValidationMessage('Reason is required for rejection.');
                            return;
                        }
                        executeAjax(id, 'rejected', rejectReason);
                    }
                });
            }
        })
    };

    function executeAjax(id, action, reason = '') {
        $.ajax({
            url: "{{ url('admin/loan') }}/" + id + "/process-request",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                status: action,
                reject_reason: reason
            },
            success: function (result) {
                new Noty({ type: "success", text: "Request success updated" }).show();
                crud.table.ajax.reload();
            },
            error: function (result) {
                new Noty({ type: "error", text: "Error" }).show();
            }
        });
    };

</script>