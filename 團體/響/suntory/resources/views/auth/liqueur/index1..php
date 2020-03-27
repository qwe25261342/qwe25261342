@extends('layouts/app');
@csrf

@section('css')
<style>
    .d-flex .col-2 .btn-danger {
        position: absolute;
        border-radius: 50%;
        top: -15px;
        right: -5px;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endsection


@section('content')
<div class="container">

    <a href="#create" data-toggle="collapse" class="btn btn-success">新增</a>

    <div class="collapse" id="create">
        <div class="card card-body">
            <form method="post" action="#" enctype="multipart/form-data" id="form1">
                @csrf
                <div class="form-group">
                    <label for="name">酒類名稱</label>
                    <input type="text" class="form-control" id="name" name="name">酒類名稱 </div>
                <div class="form-group">
                    <div id="upload-img" class="d-flex flex-wrap">
                        {{-- <div class="col-2">
                            <img src="/upload/img/15847228415fd0b37cd7dbbb00f97ba6ce92bf5add.博愛廠" alt="" srcset=""
                                class=" img-fluid">
                            <button class="btn btn-danger" type="button" data-delete="">X</button>
                        </div> --}}

                    </div>
                    <label for="img">banner照片</label>
                    <input type="file" class="form-update" id="img" name="img[]" onchange="uploadFile()" multiple>
                </div>
                <button type="button" class="btn btn-primary" data-toggle="collapse"
                    data-target="#create">Submit</button>
            </form>
        </div>
    </div>
    <table id="example" class="table table-striped table-bordered " style="width:100%">
        <thead>
            <tr>
                <th>img</th>
                <th>name</th>
                <th>sort</th>
                <th width='80px'></th>
            </tr>
        </thead>
        <tbody class="tbody">
            @foreach ($data as $item)
            <tr>
                <td>
                    <a href="#look{{$item->id}}" class="btn btn-dark btn-sm" data-toggle="collapse">查看</a>
                    
                </td>
                <td>{{$item->name}}</td>

                <td>
                    {{$item->sort}}
                </td>
                <td>
                    <a href="#edit{{$item->id}}" class="btn btn-success btn-sm" data-toggle="collapse">修改</a>
                    <button class="btn btn-danger btn-sm" onclick="show_confirm({{$item->id}})">刪除</button>

                    <form id="news_delete{{$item->id}}" action="/admin/liqueur/{{$item->id}}" method="POST"
                        style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
                <div class="collapse" id="edit{{$item->id}}">
                    <div class="card card-body">

                    </div>
                </div>
                <div class="collapse" id="look{{$item->id}}">
                    <div class="card card-body">

                    </div>
                </div>
            </tr>

            @endforeach

        </tbody>


    </table>

</div>



@endsection


@section('js')
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script>
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
    });

    $(document).ready(function() {
        $('#example').DataTable({
            "order": [ 1, 'desc' ]
        });
    } );

    function show_confirm(id)
    {
    var r=confirm("你要刪除嗎!");
    if (r==true)
    {
        document.getElementById('news_delete'+id).submit();
    }
    else
    {

    }
    }

    //ajax 上傳圖片
    function uploadFile() {
        console.log()


        for (var i = 0; i < $('#img')[0].files.length ; i++)
        {
            var file = $('#img')[0].files[i]
            if (file){


                $.upload(file);
            }
        }
    }
    //上傳含式
    $.upload = function (file) {
                let out = new FormData();
                console.log(out);

                out.append('file', file, file.name);
                console.log(out)
                $.ajax({
                    method: 'POST',
                    url: '/admin/liqueur_upload_img',
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: out,
                    success: function (ret) {
                        console.log(ret.img)
                        let id = ret.id;
                        let img = ret.img;

                        //$('.upload-img').innerHtml=`<img src="${img}" alt="" srcset="" class="col-2 img-fluid">`;

                        $("#upload-img").append(`<div class="col-2" data-id="${id}">
                            <img src="${img}" alt="" srcset=""
                                class=" img-fluid">
                            <button class="btn btn-danger" type="button"  onclick="delete_img(${id})" >X</button>
                        </div>`)

                        // $('#content').summernote('insertImage', img);
                        //顯示後綁定方法


                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error(textStatus + " " + errorThrown);
                    }
                });
    }




</script>
<script>
    //刪除上傳照片(未保存)含式
function delete_img(id){

// 將綁在按鈕上的data-newsimgid的值取出
console.log(id);

$.ajax({
    //   傳送路徑
      url: "/admin/liqueur_delete_img",
    //   方法
      method: 'POST',
    //   資料
      data: {
        id:id
      },
    //   如果成功回傳
      success: function(result){
        //   將col-2綁上ID 指定的ID做remove(移除)
        //$(`.col-2[data-newsimgid=${imgid}]`).remove();
        $(`.col-2[data-id=${id}]`).remove();
      }
});
};
</script>
<script>
    //Submit按下時寄送表單
    $('.card .btn-primary').click(function(){
        console.log($("#upload-img .col-2[data-id]"))
        var aaa = [];
        for(var i = 0; i<$("#upload-img .col-2[data-id]").length; i++){
            var b =$("#upload-img .col-2[data-id]")[i].getAttribute('data-id')
            var newLength = aaa.push(b);
        }
        $('#form1').serializeArray()
        var name = $('#name').val()
        $.ajax({
            //   傳送路徑
            url: "/admin/liqueur",
            //   方法
            method: 'POST',
            //   資料
            data: {
                imgs: aaa,
                name: $('#name').val()
            },
            //   如果成功回傳
            success: function(result){
                //   將col-2綁上ID 指定的ID做remove(移除)
                //$(`.col-2[data-newsimgid=${imgid}]`).remove();
                //$(`.col-2[data-id=${id}]`).remove();
                $('#form1')[0].reset();
                $("#upload-img .col-2").remove()
                $(".tbody").append(`
                <tr>
                    <td>
                        <a href="#look${result}" class="btn btn-dark btn-sm" data-toggle="collapse">查看</a>
                    </td>
                    <td>${name}</td>

                    <td>
                        0
                    </td>
                    <td>
                        <a href="#edit${result}" class="btn btn-success btn-sm" data-toggle="collapse">修改</a>
                        <button class="btn btn-danger btn-sm" onclick="show_confirm(${result})">刪除</button>

                        <form id="news_delete${result}" action="/admin/liqueur/${result}" method="POST"
                            style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>`)
                $("#example_wrapper").before(`
                <div class="collapse" id="edit${result}">
                        <div class="card card-body">

                        </div>
                    </div>
                <div class="collapse" id="look${result}">
                        <div class="card card-body">

                        </div>
                </div>
                `)

            }
        });
    })
</script>
@endsection
