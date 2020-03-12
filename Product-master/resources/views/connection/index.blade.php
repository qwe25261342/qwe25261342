@extends('layouts/app')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <a href="/home/product_type/create" class="btn btn-success">聯絡資訊</a>
    <hr>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>

                <th>name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Message</th>
                <th width="80"></th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td>name</td>
                <td>Email</td>
                <td>Phone</td>
                <td>Message</td>
                {{-- <td>
                    <button class="btn btn-danger btn-sm" onclick="show_confirm({{$item->id}})">刪除</button>

                    <form id="delete-form-{{$item->id}}" action="/home/product_type/delete/{{$item->id}}" method="POST"
                        style="display: none;">
                        @csrf
                    </form>
                </td> --}}
            </tr>

        </tbody>
    </table>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "order": [[ 2, 'desc' ]]
        });
    });

        function show_confirm(id)
        {
            var r=confirm("你確定要刪除嗎!");
            if (r==true)
            {
                //使用者確認刪除
                // document.getElementById('delete-form-'+id).submit();
                document.getElementById(`delete-form-${id}`).submit();
            }
        }
</script>
@endsection
