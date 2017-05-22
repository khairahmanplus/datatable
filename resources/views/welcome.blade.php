<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Datatable</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>
    </head>
    <body >

        <div class="container" id="app">
            <h2>Users</h2>
            <hr>

            <table class="table" id="users-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
            </table>
        </div>

        <script src="{{ asset('js/app.js') }}" charset="utf-8"></script>
        <script>
            $(function () {

                /**
                 * Set
                 */
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                /**
                 *
                 */
                var table = $('#users-table').DataTable({
                    processing: true,
                    serverSide: true,
                    "columnDefs": [
                        {
                            targets: -1,
                            searchable: false,
                            orderable: false
                        }
                    ],
                    ajax: {
                        url: '{{ route('users') }}',
                        dataType: 'json',
                        type: 'POST'
                    },
                    columns: [
                        { data: 'name' },
                        { data: 'email' },
                        { data: 'actions' }
                    ],
                    dom:    "<'row'<'col-sm-9'B><'col-sm-3'f>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-4'i><'col-sm-8'p>>",
                    buttons: [
                        {
                            text: 'New User',
                            action: function (  e, dt, node, config  ) {

                            },
                            className: 'btn-primary'
                        }
                    ]
                });
            });
        </script>
    </body>
</html>
