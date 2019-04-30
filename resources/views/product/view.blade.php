@extends('master')

@section('title')
    Product
@endsection


@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Products</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Products
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                @if(\Illuminate\Support\Facades\Auth::user()->role == 'Company')
                                    <th>Supplier</th>
                                @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'Supplier')
                                    <th>Company</th>
                                @else
                                    <th>Supplier | Company</th>
                                @endif
                                @if(\Illuminate\Support\Facades\Auth::user()->role != 'Supplier')
                                    <th>Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1;?>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->qty}}</td>
                                    @if(\Illuminate\Support\Facades\Auth::user()->role == 'Company')
                                        <td>{{ $product->supplier->name }}</td>
                                    @elseif(\Illuminate\Support\Facades\Auth::user()->role == 'Supplier')
                                        <td>{{ $product->company->name }}</td>
                                    @else
                                        <td>Supplier : {{ $product->supplier->name }} | Company
                                            : {{ $product->company->name }}</td>
                                    @endif
                                    @if(\Illuminate\Support\Facades\Auth::user()->role != 'Supplier')
                                        <td>
                                            <a href="{{ url('/product/'.$product->id.'/edit') }}"
                                               class="btn btn-success" title="Edit">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                            <a href="#" id="{{ $product->id }}"
                                               class="btn btn-danger"
                                               title="Delete" onclick="return myFunction(this.id);">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a>
                                            <form action="{{ action('ProductController@destroy', $product->id) }}"
                                                  method="post" style="display: none"
                                                  id="delete-form{{ $product->id }}">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                            </form>
                                        </td>
                                    @endif
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
