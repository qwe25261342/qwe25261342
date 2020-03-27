<template>
    <div class="container">
        <a id="add" href="#create" data-toggle="collapse" class="btn btn-success" @click="clear()">新增</a>

        <hr />

        <div class="collapse" id="create">
            <div class="card card-body">
                <form method="post" action="#" enctype="multipart/form-data" id="form1" @submit.prevent="store(input.index)">
                    <div class="form-group">
                        <div class="col-4">
                            <img :src="input.oldimg" alt srcset class="img-fluid" />
                        </div>
                        <label for="img">比賽Logo</label>
                        <input v-if="this.input.edit == null" required type="file" class="form-control" @change="processFile($event)" id="img" name="img" value />
                        <input v-else type="file" class="form-control" @change="processFile($event)" id="img" name="img" value />
                    </div>
                    <div class="form-group">
                        <label for="contest">比賽名稱</label>
                        <input type="text" class="form-control" v-model="input.contest" id="contest" name="contest" required />
                    </div>
                    <div class="form-group">
                        <label for="liqueur_product_id">得獎的酒</label>
                        <select name="liqueur_product_id" id="liqueur_product_id" v-model="input.liqueur_product_id" class="form-control">
                            <option v-for="item in liqueur_products" :key="item.id" :value="item.id">
                                {{ item.title }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="year">得獎時間(年)</label>
                        <input type="number" class="form-control" v-model="input.year" id="year" name="year" required />
                    </div>
                    <div class="form-group">
                        <label for="award">獎項</label>
                        <input type="text" class="form-control" v-model="input.award" id="award" name="award" required />
                    </div>

                    <button type="submit" class="btn btn-primary" data-target="#create">
                        儲存
                    </button>
                </form>
            </div>
            <hr />
        </div>

        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th width="20px">No.</th>
                    <th width="80px">比賽Logo</th>
                    <th width="80px">比賽名稱</th>
                    <th width="80px">得獎的酒</th>
                    <th width="100px">得獎時間(年)</th>
                    <th>獎項</th>
                    <th width="80px"></th>
                </tr>
            </thead>
            <tbody class="tbody">
                <tr v-for="(item, index) in liqueur_text" :key="index">
                    <td>{{ (index + 1) }}</td>
                    <td>
                        <img :src="item.img" alt srcset class="img-fluid" />
                    </td>
                    <td>{{ item.contest }}</td>
                    <td>{{ item.liqueur_product.title }}</td>
                    <td>{{ item.year }}</td>
                    <td>{{ item.award }}</td>
                    <!-- <td v-if="item.sort == null">0</td>
                    <td v-else>{{ item.sort }}</td> -->
                    <td>
                        <a href="#create" class="btn btn-success btn-sm" data-toggle="collapse" @click="editdata(index)">修改</a>
                        <button class="btn btn-danger btn-sm" @click="deletedata(index)">
                            刪除
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from "axios";
export default {
    mounted() {
        console.log("Component mounted.");
    },
    created() {
        //獲取酒的產品
        axios
            .post("/admin/liqueurSure_product")
            .then(response => (this.liqueur_products = response.data))
            .catch(function (error) {
                console.log(error);
            });
        //獲取酒的獎項資料
        axios
            .post("/admin/liqueurSure_text")
            .then(response => {
                this.liqueur_text = response.data;
                this.upload();
            })
            .catch(function (error) {
                console.log(error);
            });
    },
    data() {
        return {//定義變數
            liqueur_text: [],
            liqueur_products: [],
            input: {
                newimg: null,
                oldimg: null,
                contest: "",
                liqueur_product_id: "",
                year: "",
                award: "",
                // sort: 0,
                edit: null, //若有值則為編輯，若無為新增
                index: null //編輯或刪除第幾項
            }
        };
    },
    methods: {
        //按下submit
        store(index) {
            if (this.input.edit == null) {
                axios
                    .post("/admin/liqueurSure", {
                        img: this.input.oldimg,
                        contest: this.input.contest,
                        liqueur_product_id: this.input.liqueur_product_id,
                        year: this.input.year,
                        award: this.input.award
                    })
                    .then(res => {
                        this.clear();
                        this.sweetalert("add");
                        this.liqueur_text.push(res.data);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            } else {
                //console.log(index);
                axios
                    .put(`/admin/liqueurSure/${this.input.edit}`, {
                        img: this.input.oldimg,
                        contest: this.input.contest,
                        liqueur_product_id: this.input.liqueur_product_id,
                        year: this.input.year,
                        award: this.input.award
                    })
                    .then(res => {
                        this.sweetalert("edit");
                        this.clear();
                        //兩個方法都可以重新渲染
                        this.$set(this.liqueur_text, index, res.data);
                        // this.liqueur_text.splice(index,1, res.data)
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        },
        //當頁面讀取完成後執行datatable
        upload() {
            $(document).ready(function () {
                $("#example").DataTable({
                    order: [1, "desc"]
                });
            });
        },
        //刪除
        deletedata(index) {
            //console.log(index);
            let target = this.liqueur_text[index];

            Swal.fire({
                title: `確定要刪除第 ${index + 1} 筆?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "確定",
                cancelButtonText: "取消"
            }).then(result => {
                if (result.value) {
                    axios
                        .delete("/admin/liqueurSure/" + target.id)
                        .then(res => {
                            this.liqueur_text.splice(index, 1);
                            this.sweetalert("del");
                        })
                        .catch(err => {
                            console.log(err);
                        });
                }
            });
        },
        //讀取編輯資料
        editdata(index) {
            let target = this.liqueur_text[index];
            axios
                .get(`/admin/liqueurSure/${target.id}/edit`)
                .then(res => {
                    //console.log(res.data);
                    let {
                        id,
                        img,
                        contest,
                        liqueur_product_id,
                        year,
                        award
                        // sort
                    } = res.data;
                    this.input.index = index;
                    this.input.edit = id;
                    this.input.oldimg = img;
                    this.input.contest = contest;
                    this.input.liqueur_product_id = liqueur_product_id;
                    this.input.year = year;
                    this.input.award = award;
                    // this.input.sort = sort;
                    // console.log(res.data)
                })
                .catch(err => {
                    console.log(err);
                });
        },
        //判斷是否有圖片上傳
        processFile(event) {
            if (this.input.oldimg == null) {
                this.input.newimg = event.target.files[0];
                const fd = new FormData();
                fd.append("file", this.input.newimg, this.input.newimg.name);
                axios
                    .post("/admin/liqueurSure_upload_img", fd)
                    .then(response => (this.input.oldimg = response.data))
                    .catch(function (error) {
                        console.log(error);
                    });
            } else {
                axios
                    .post("/admin/liqueurSure_delete_img", {
                        file_link: this.input.oldimg
                    })
                    .then(function (response) {
                        //console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                this.input.newimg = event.target.files[0];
                const fd = new FormData();
                fd.append("file", this.input.newimg, this.input.newimg.name);
                axios
                    .post("/admin/liqueurSure_upload_img", fd)
                    .then(response => (this.input.oldimg = response.data))
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        },
        //清除表單資料
        clear() {
            (this.input.newimg = null),
                (this.input.oldimg = ""),
                (this.input.contest = ""),
                (this.input.liqueur_product_id = ""),
                (this.input.year = ""),
                (this.input.award = "");
            // (this.input.sort = "");
            $("#img").val("");
        },

        sweetalert(action) {
            if (action != "del") {
                Swal.fire({
                    icon: "success",
                    title: "儲存成功",
                    timer: 1500
                }).then(result => {
                    $("#add").click();
                });
            } else {
                Swal.fire({
                    icon: "success",
                    title: "刪除成功",
                    timer: 1500
                });
            }
        }
    }
};
</script>
