<?php

?>

@if ($archived)
    <h2>Archived Items</h2>
@else
    <h2>Bill List</h2>
@endif


<header>
    <style href={{ URL::asset('/css/style.css') }}></style>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</header>

<span class="error"></span>
<span class="success"></span>




<div class="action">

    <?php if ($archived == 1): ?>
    <a href="?archived=0" class="btn btn-secondary btn-sm">View bill list</a>
    <?php else: ?>
    <a href="?archived=1" class="btn btn-secondary btn-sm">View archived bills</a>
    <?php endif; ?>

    <?php if ($archived == 1): ?>
    <a href="javascript:void(0)" id="unArchive" class="btn btn-primary btn-sm">Unarchive</a>
    <?php else: ?>
    <a href="<?= route('bill.create') ?>" class="btn btn-primary btn-sm">Add New Bill</a>
    <a href="javascript:void(0)" id="archive" class="btn btn-primary btn-sm">Archive</a>
    <?php endif; ?>
    <button class="btn btn-success btn-sm" id="btnOpenModal">Mass Update</button>
</div>


<?php if (!empty($bills)): ?>
<div>
    <table id="myTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <!-- 8 col -->
                <th> <input type="checkbox" id="selectAll"> </th>
                <th>Account Number</th>
                <th>Bill ID</th>
                <th>Service</th>
                <th>Amount</th>
                <th>Payment Status</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bills as $row): ?>

            <tr>
                <td> <input type="checkbox" class="itemCheckbox" id="<?= $row['id'] ?>"></td>
                <td><?= $row['account_number'] ?></td>
                <td><?= $row['bill_id'] ?></td>
                <td><?= $row['service'] ?></td>
                <td>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">$</span>
                        <input type="number" value="<?= $row['amount'] ?>" class="form-control inline-input"
                            aria-describedby="basic-addon1" data-id={{ $row['id'] }} data-field="amount">
                    </div>
                </td>
                <td>
                    <select class="inline-select form-select" data-id={{ $row['id'] }} data-field="status">
                        @foreach ($states as $state)
                            <option value={{ $state }} @selected($row['status'] == $state)>
                                {{ $state }}</option>
                        @endforeach
                    </select>
                </td>
                <td><?= $row['category'] ?></td>
                <td>
                    <a href="{{ route('bill.show', ['bill' => $row['id']]) }}"
                        class="btn btn-sm btn-secondary">Detail</a>
                    <a id="edit" class=" btn btn-sm btn-primary"
                        href="{{ route('bill.edit', ['bill' => $row['id']]) }}">Edit</a>

                    <a href="javascript:void(0);" class="delete-btn btn btn-sm btn-danger"
                        data-id="{{ $row['id'] }}">Delete</a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>

    </table>


</div>
<?php else: ?>
<p>No bills found!</p>
<?php endif; ?>

<div class="modal" tabindex="-1" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Mass Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('btnOpenModal').addEventListener('click', function() {
        // Pass bill id into modal

        // Open modal
        const modalElement = document.getElementById('myModal');
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    });
</script>


<script>
    // Lưu giá trị cũ 
    $('.inline-input, .inline-select').each(function() {
        $(this).data('oldValue', $(this).val());
    });

    // Enter -> blur 
    $(document).on('keydown', '.inline-input', function(e) {
        if (e.key === 'Enter') {
            this.blur();
        }
    });

    // khi blur
    $(document).on('blur', '.inline-input', function() {
        const $e = $(this);
        const oldValue = String($e.data('oldValue') ?? '');
        const newValue = $.trim($e.val());
        if (newValue === oldValue) {
            return;
        }

        let data = {};
        data[$e.data('field')] = newValue;
        data['_token'] = $('meta[name="csrf-token"]').attr('content');
        save(data, $e.data('id'))

    });

    $(document).on('change', '.inline-select', function() {
        const $e = $(this);
        const oldValue = String($e.data('oldValue') ?? '');
        const newValue = $.trim($e.val());
        if (newValue === oldValue) {
            return;
        }

        let data = {};
        data[$e.data('field')] = newValue;
        data['_token'] = $('meta[name="csrf-token"]').attr('content');
        save(data, $e.data('id'))

    });




    function save(data, id) {
        $.ajax({
            url: '{{ route('bill.update', ['bill' => 'ID']) }}'.replace('ID', id),
            type: 'PATCH',
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message)

                } else {
                    alert(response.message)
                }
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                $('.error').text(xhr.responseText);
            },
        });
    }
</script>


<script>
    console.log("Loading DataTable...");
    $(document).ready(function() {
        var table = $('#myTable').DataTable({
            lengthMenu: [2, 5, 10, 25, 50, 100, 1000],
            columnDefs: [{
                orderable: false,
                targets: [0]
            }]
        });
        // lưu trữ
        $("#archive").click(function() {
            var ids = [];
            table.$('.itemCheckbox:checked').each(function() {
                ids.push(this.id);
            });
            if (ids.length === 0) {
                alert("No bills selected!");
                return;
            }
            if (!confirm("Archive the selected bills?")) {
                return;
            }
            $.ajax({
                url: "{{ route('bill.archive') }}",
                type: "POST",
                data: {
                    ids: ids,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    if (response.success) {
                        // console.log(response);
                        alert("Bill archived successfully!");
                        location.reload();
                    } else {
                        $('.error').text(response.message);
                    }
                },
                error: function() {
                    alert("Something went wrong while archiving.");
                }
            });
        });
        // hủy lưu trữ
        $("#unArchive").click(function() {
            var ids = [];
            table.$('.itemCheckbox:checked').each(function() {
                ids.push(this.id);
            });
            if (ids.length === 0) {
                alert("Chưa chọn hóa đơn nào!");
                return;
            }
            if (!confirm("Hủy lưu trữ các hóa đơn đã chọn?")) {
                return;
            }
            $.ajax({
                url: "{{ route('bill.archive') }}",
                type: "POST",
                data: {
                    ids: ids,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    if (response.success) {
                        alert("Bill unArchived successfully!");
                        location.reload();
                    } else {
                        $('.error').text(response.message);
                    }
                },
                error: function() {
                    alert("Something went wrong while unarchiving.");
                }
            });
        });

        $("#selectAll").on("change", function() {
            var checked = $(this).prop("checked");
            table.cells(null, 0).every(function() {
                var cell = this.node();
                $(cell)
                    .find(".itemCheckbox")
                    .prop("checked", checked);
            });
        });

        $(document).on("change", ".itemCheckbox", function() {
            var countSelected = table
                .rows(function(idx, data, node) {
                    return $(node).find(".itemCheckbox").prop("checked");
                })
                .count();

            $("#selectAll").prop("checked", table.rows().count() === countSelected);
        });
        // xóa bill
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            if (!confirm('Confirm delete?')) {
                return;
            }
            $.ajax({
                url: "{{ route('bill.destroy', '') }}/" + id,
                type: "DELETE",
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        $('.error').text(response.message);
                    }
                },
                error: function() {
                    $('.error').text('Something went wrong while deleting.');
                }
            });
        });

    });
</script>
