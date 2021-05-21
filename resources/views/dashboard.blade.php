<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <div class="row g-0 mb-3">
                            <div class="col">
                                <h2>{{ Auth::user()->name }}&rsquo;s Widgets</h2>
                            </div>
                            <div class="col text-right">
                                <button type="button" id="btnAddWidget" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </div>

                    <table id="widgetTable" class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="widgetModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add/Edit Widget</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" style="display:none"></div>
            <form id="widgetForm">
            <input type="hidden" name="edit_widget_id" id="edit_widget_id" value="">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" id="name" class="form-control"/>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="text" name="price" id="price" class="form-control"/>
            </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="btnSaveWidget">Save</button>
          </div>
        </div>
      </div>
    </div>

    <script type="text/javascript">
        var ghWidgetModal = new bootstrap.Modal(document.getElementById('widgetModal'));

        function edtWgt(piWgtId) {  // Open edit modal
            $.ajax({
                url: "/widgets/" + piWgtId,
                method: 'GET',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(result){
                    if (result.errors)
                    {
                        alert('Unable to get widget.')
                    }
                    else
                    {
                        $("#edit_widget_id").val(result.id);
                        $("#name").val(result.name);
                        $("#price").val(result.price);
                        ghWidgetModal.show();
                    }
                },
                error: function (data, textStatus, errorThrown) {
                    console.error(data);
                }
            });
        }

        function delWgt(piWgtId) {  // Delete widget
            $.ajax({
                url: "/widgets/" + piWgtId,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(result){
                    if (result.errors)
                    {
                        alert('Unable to delete widget.')
                    }
                    else
                    {
                        $('#widgetTable').DataTable().ajax.reload();
                    }
                },
                error: function (data, textStatus, errorThrown) {
                    console.error(data);
                }
            });
        }

      $(function () {
        var ghWidgetTable = $('#widgetTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('widgets.index') }}",
            columnDefs: [
                { targets: [0,2], className: 'text-right'}
            ],
            columns: [
                {data: 'id', name: 'id', type: 'num'},
                {data: 'name', name: 'name'},
                {data: 'price', name: 'price', type: 'num'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });

        $('#btnAddWidget').click(function(e) {
            $("#edit_widget_id").val('');
            $("#name").val('');
            $("#price").val('');
            ghWidgetModal.show();
        });

        $('#btnSaveWidget').click(function(e) {
            if ($('#edit_widget_id').val() != '') {
                cCURL = '/widgets/' + $('#edit_widget_id').val();
                cMethod = 'PUT';
            }
            else {
                cCURL = '/widgets';
                cMethod = 'POST';
            }

            $.ajax({
                url: cCURL,
                method: cMethod,
                data: {
                    _token: '{{ csrf_token() }}',
                    name: $('#name').val(),
                    price: $('#price').val()
                },
                success: function(result){
                    if (result.errors)
                    {
                        $('.alert-danger').html('');
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<li>' + value + '</li>');
                        });
                    }
                    else
                    {
                        $('.alert-danger').hide();
                        $('#widgetModal').modal('hide');
                        $('#widgetTable').DataTable().ajax.reload();
                    }
                },
                error: function (data, textStatus, errorThrown) {
                    console.error(data);
                }
            });
        });

      });
    </script>
</x-app-layout>
