<header>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</header>

<main>


    <span class="error"></span>
    <span class="success"></span>

    <div>
        <form method="POST" id="add-form" action="<?= route('bill.store') ?>">

            @csrf

            <div class="form-control">
                <div class="form-field">
                    <label class="required" for="account_number">Account Number</label>
                    <select class="form-input" name="account_number" id="account_number" required>
                        <option value=""></option>
                        <?php foreach ($accountNumbers as $accountNumber) : ?>
                        <option value="<?= $accountNumber ?>"><?= $accountNumber ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <div class="form-control">
                <div class="form-field">
                    <label class="required" for="bill_id">
                        Bill ID
                    </label>
                    <input class="form-input" type="text" name="bill_id" id="bill_id" onchange="checkExistBill();"
                        required>
                    <span class="bill_error">
                    </span>


                </div>
                <div class="form-field">
                    <label class="required" for="amount">Amount</label>
                    <input class="form-input" type="number" name="amount" id="amount" required>
                </div>
            </div>

            <div class="form-control">
                <div class="form-field">
                    <label class="required" for="service">Service</label>
                    <select class="form-input" name="service" id="service" required>
                        <option value=""></option>
                        <?php foreach ($services as $service) : ?>
                        <option value="<?= $service ?>"> <?= $service ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-field">
                    <label class="required" for="category">Category</label>
                    <select class="form-input" name="category" id="category" required>
                        <option value=""></option>
                        <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category ?>"><?= $category ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <div class="form-control">
                <div class="form-field">
                    <label class="required" for="status">Payment Status</label>
                    <select class="form-input" name="status" id="status">
                        <option value=""></option>
                        <?php foreach ($states as $state) : ?>
                        <option value="<?= $state ?>"> <?= $state ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="form-control">
                <div class="form-comment">
                    <label for="comment">Comment</label>
                    <textarea class="form-input" name="comment" id="comment" rows="5"></textarea>
                </div>
            </div>
            <div class="form-control">
                <button id="submit-form" class="form-input submit" type="submit"> Save</button>
            </div>
        </form>
    </div>
</main>


<script type="text/javascript">
    $(document).ready(function() {


        // Kiểm tra bill_id
        $('#bill_id').on('keyup change', function() {
            var billId = $(this).val();
            var excludeId = $('input[name="id"]').val() || '';
            if (billId.length === 0) {
                $('.bill_error').text('');
                return;
            }
            $.ajax({
                url: '{{ route('bill.check') }}',
                type: 'POST',
                dataType: 'json',
                data: {
                    bill_id: billId,
                    exclude_id: excludeId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (!response.success) {
                        $('.error').text(response.message);
                        $('#submit-form').prop('disabled', true);
                    } else {
                        $('.error').text('');
                        $('#submit-form').prop('disabled', false);
                    }
                },
                error: function() {
                    console.log('Error checking bill ID');
                }
            });
        });

        // submit form
        $('#submit-form').on('click', function(e) {
            e.preventDefault();

            var form = $('#add-form');
            var formData = form.serialize();
            console.log('Form data:', formData);

            $('.error').text('');
            $('.success').text('');

            $.ajax({
                url: '{{ route('bill.store') }}',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log('Success response:', response);
                    if (response.success) {
                        $('.success').text(response.message);
                        form[0].reset();
                    } else {
                        $('.error').text(response.message || 'Có lỗi xảy ra!');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error:', xhr.responseText);
                    $('.error').text(xhr.responseText);
                },
            });
        });
    });
</script>
