@if($entry->status == "approved")
    <a href="javascript:void(0)" onclick="openReturnModal({{ $entry->id }})" class="btn btn-sm btn-link text-primary">
        <i class="la la-undo"></i> Return
    </a>
@endif

<script>
    function openReturnModal(id) {
        swal({
            title: 'Return Date',
            content: {
                element: 'input',
                attributes: {
                    type: 'date',
                    id: 'return-date-input',
                    placeholder: 'Enter the return date',
                },
            },
            buttons: {
                cancel: {
                    text: 'Cancel',
                    value: null,
                    visible: true,
                    className: 'bg-secondary',
                },
                save: {
                    text: 'Save',
                    value: 'save',
                    visible: true,
                    className: 'bg-primary',
                },
            },
        }).then((value) => {
            if (value === 'save') {
                const returnDateInput = document.getElementById('return-date-input');
                const returnDate = returnDateInput ? returnDateInput.value : '';

                if (!returnDate) {
                    swal('Error', 'Return date is required', 'error');
                    return;
                }

                $.ajax({
                    url: "{{ url('admin/loan') }}/" + id + "/return-request",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        return_date: returnDate,
                    },
                    success: function () {
                        new Noty({ type: 'success', text: 'Request successfully updated' }).show();
                        crud.table.ajax.reload();
                    },
                    error: function () {
                        new Noty({ type: 'error', text: 'Error' }).show();
                    },
                });
            }
        });
    }
</script>