@extends('layouts/nav')

@section('css')
<style>
.color{
    padding: 10px 20px;
    width: 160px;
    min-height: 58px;
    height: 100%;
    font-size: 16px;
    line-height: 20px;
    color: #757575;
    text-align: center;
    border: 1px solid #eee;
    background-color: #fff;
    -webkit-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
.outbox{
    width: 606px;
    min-height: 500px;
    box-sizing: border-box;
    padding: 48px 48px 40px;
    margin-bottom: 60px;
    background: #fafafa;
}
.outbox .title{
    font-size: 40px;
    font-weight: 400;
    line-height: 48px;
}
.outbox .model{
    font-size: 20px;
    line-height: 24px;
    color: #757575
}

.outbox .price{
    color: #ff6700;
}
.active{
    color: #424242;
    border-color: #ff6700;
    transition: opacity,border .2s linear;
}

</style>

@endsection

@section('content')
<section class="engine">
    </section><section class="features3 cid-rRF3umTBWU" id="features3-7" style="padding-top:100px">

    <div class="container">
        <div class="row">
            <div class="col-6">
            </div>

            <div class="col-6">
                <div class="outbox">
                    <div class="title">Redmi Note 8T</div>
                    <div class="model">3GB+32GB, 星際藍</div>
                    <div class="price">NT$4,599</div>
                    <div>容量
                        <div class="row">
                            <div class="col-4">
                                <div class="color">
                                    3GB+32GB
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="color">
                                    3GB+64GB
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>顏色
                        <div class="row">
                            <div class="col-4 ">
                                <div class="color active " >
                                    紅
                                </div>

                            </div>
                            <div class="col-4">
                                <div class="color">
                                    綠
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="color">
                                    藍
                                </div>

                            </div>
                            <div class="col-4">
                                <div class="color">
                                    紫
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="">數量
                        <input type="number">
                    </div>
                    <span>Redmi Note 8T</span>
                    <span>星際藍</span>
                    <span>3GB+32GB *</span>
                    <span>1</span>
                    <span>NT$4,599</span>
                    <div class="">總計 NT$4,599</div>

                    <input type="text" name="color" id="color">
                    <input type="text" name="capacity" id="capacity">
                    <input id="myTextBox" type="text"/>
                    <div>
                    <button>立即購買</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section('js')
<script>
    $('.color *').attr('style','');
    $('.outbox .color').click(function(){
        $('.outbox .color').removeClass('active');
        $(this).addClass('active');
    });
    $(this).attr("color");

    $("#myTextBox").bind("change paste keyup", function() {
        alert($(this).val());
    });
    

</script>

@endsection
