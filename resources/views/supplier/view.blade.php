@extends('master')

@section('title')
    Supplier
@endsection


@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Supplier</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Suppliers
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1;?>
                            @foreach($suppliers as $supplier)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td><img src="{{ asset($supplier->image) }}" border="0" width="40"
                                             class="img-circle"></td>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->email }}</td>
                                    <td>{{ $supplier->address }}</td>
                                    <td>
                                        <a href="{{ url('/supplier/'.$supplier->id.'/edit') }}"
                                           class="btn btn-success" title="Edit">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        <a href="#" id="{{ $supplier->id }}"
                                           class="btn btn-danger"
                                           title="Delete" onclick="return myFunction(this.id);">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </a>
                                        <form action="{{ action('SupplierController@destroy', $supplier->id) }}"
                                              method="post" style="display: none" id="delete-form{{ $supplier->id }}">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>

    </div>
    <!-- /.row -->
@endsection

<script>
    function myFunction(id) {
        if (confirm("Are You Sure to delete this")) {
            event.preventDefault();
            document.getElementById('delete-form' + id).submit();
        } else {
            return false;
        }
    }
</script>
