<template>
    <div class="container">
        <a href="#create" id="add" data-toggle="collapse" class="btn btn-success">新增</a>
        <hr />

        <div class="collapse" id="create">
            <div class="card card-body">
                <form method="post" action="#" enctype="multipart/form-data" id="form1" @submit.prevent="store()">
                    <div class="form-group">
                        <div class="col-4">
                            <img :src="input.oldimg" alt srcset class="img-fluid" />
                        </div>
                        <label for="img">圖片</label>
                        <input v-if="this.input.edit == null" required type="file" class="form-control" @change="processFile($event)" id="img" name="img" value />
                        <input v-else type="file" class="form-control" @change="processFile($event)" id="img" name="img" value />
                    </div>
                    <div class="form-group">
                        <label for="title">名稱</label>
                        <input required type="text" class="form-control" v-model="input.title" id="title" name="title" />
                    </div>
                    <div class="form-group">
                        <label for="liqueur_id">系列</label>
                        <select name="liqueur_id" id="liqueur_id" v-model="input.liqueur_id" class="form-control">
                            <option v-for="(item ,index) in liqueur_kind" :key="index" :value="item.id">
                                {{ item.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="content">介紹</label>
                        <vue-editor id="content" name="content" v-model="input.content" :editor-toolbar="customToolbar" />
                    </div>
                    <div class="form-group">
                        <label for="capacity">容量</label>
                        <input required type="text" class="form-control" v-model="input.capacity" id="capacity" name="capacity" />
                    </div>
                    <div class="form-group">
                        <label for="density">濃度</label>
                        <input required type="text" class="form-control" v-model="input.density" id="density" name="density" />
                    </div>
                    <div class="form-group">
                        <label for="color">色澤</label>
                        <input required type="text" class="form-control" v-model="input.color" id="color" name="color" />
                    </div>
                    <div class="form-group">
                        <label for="aroma">香氣</label>
                        <input required type="text" class="form-control" v-model="input.aroma" id="aroma" name="aroma" />
                    </div>
                    <div class="form-group">
                        <label for="body">酒體</label>
                        <input required type="text" class="form-control" v-model="input.body" id="body" name="body" />
                    </div>
                    <div class="form-group">
                        <label for="taste">味覺</label>
                        <input required type="text" class="form-control" v-model="input.taste" id="taste" name="taste" />
                    </div>
                    <div class="form-group">
                        <label for="aftertaste">餘覺</label>
                        <input required type="text" class="form-control" v-model="input.aftertaste" id="aftertaste" name="aftertaste" />
                    </div>
                    <div class="form-group">
                        <label for="price">價錢</label>
                        <input required type="number" class="form-control" v-model="input.price" id="price" name="price" />
                    </div>
                    <div class="form-group">
                        <label for="note">備註</label>
                        <input type="text" class="form-control" v-model="input.note" id="note" name="note" />
                    </div>
                    <div class="form-group" v-if="input.edit != null">
                        <label for="sort">權重</label>
                        <input type="number" class="form-control" v-model="input.sort" id="sort" name="sort" />
                    </div>
                    <button type="submit" class="btn btn-primary" data-target="#create">
                        儲存
                    </button>
                </form>
            </div>
            <hr>
        </div>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>圖片</th>
                    <th>系列</th>
                    <th>名稱</th>
                    <th>介紹</th>
                    <th>容量</th>
                    <th>濃度</th>
                    <th>色澤</th>
                    <th>香氣</th>
                    <th>酒體</th>
                    <th>味覺</th>
                    <th>餘覺</th>
                    <th>價錢</th>
                    <th>備註</th>
                    <th>權重</th>
                    <th width="80px"></th>
                </tr>
            </thead>
            <tbody class="tbody">
                <tr v-for="(item, index) in product_data" :key="index">
                    <td>
                        <img :src="item.img" alt srcset class="img-fluid" />
                    </td>
                    <td>{{ item.liqueur.name }}</td>
                    <td>{{ item.title }}</td>
                    <td>{{ item.content }}</td>
                    <td>{{ item.capacity }}</td>
                    <td>{{ item.density }}</td>
                    <td>{{ item.color }}</td>
                    <td>{{ item.aroma }}</td>
                    <td>{{ item.body }}</td>
                    <td>{{ item.taste }}</td>
                    <td>{{ item.aftertaste }}</td>
                    <td>{{ item.price }}</td>
                    <td>{{ item.note }}</td>
                    <td v-if="item.sort == null">0</td>
                    <td v-else>{{ item.sort }}</td>
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
import { VueEditor } from "vue2-editor";

export default {
    components: { VueEditor },

    mounted() {
        console.log("Component mounted.");
    },
    created() {
        //獲取酒的種類
        axios
            .post("/admin/liqueurProduct_kind")
            .then(response => (this.liqueur_kind = response.data))
            .catch(function (error) {
                console.log(error);
            });
        //獲取酒的產品
        axios
            .post("/admin/liqueurProduct_text")
            .then(response => {
                this.product_data = response.data;
                this.upload();
            })
            .catch(function (error) {
                console.log(error);
            });
    },
    data() {
        return {
            liqueur_kind: [],
            product_data: [],
            input: {
                newimg: null,
                oldimg: null,
                liqueur_id: "",
                title: "",
                content: "",
                capacity: "",
                density: "",
                color: "",
                aroma: "",
                body: "",
                taste: "",
                aftertaste: "",
                price: "",
                note: "",
                sort: 0
            },
            customToolbar: [
                ["bold", "italic", "underline"],
                [{ list: "ordered" }, { list: "bullet" }],
                ["code-block"]
            ]
        };
    },
    methods: {
        //當頁面讀取完成後執行datatable
        upload() {
            $(document).ready(function () {
                $("#example").DataTable({
                    order: [1, "desc"]
                });
            });
        },

        //按下submit
        store(index) {
            if (this.input.edit == null) {
                axios
                    .post("/admin/liqueurProduct", {
                        liqueur_id: this.input.liqueur_id,
                        img: this.input.oldimg,
                        content: this.input.content,
                        title: this.input.title,
                        capacity: this.input.capacity,
                        density: this.input.density,
                        color: this.input.color,
                        aroma: this.input.aroma,
                        body: this.input.body,
                        taste: this.input.taste,
                        aftertaste: this.input.aftertaste,
                        price: this.input.price,
                        note: this.input.note
                    })
                    .then(res => {
                        this.clear();
                        this.sweetalert("add");
                        this.product_data.push(res.data);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            } else {
                //console.log(index);
                axios
                    .put(`/admin/liqueurProduct/${this.input.edit}`, {
                        liqueur_id: this.input.liqueur_id,
                        img: this.input.oldimg,
                        content: this.input.content,
                        title: this.input.title,
                        capacity: this.input.capacity,
                        density: this.input.density,
                        color: this.input.color,
                        aroma: this.input.aroma,
                        body: this.input.body,
                        taste: this.input.taste,
                        aftertaste: this.input.aftertaste,
                        price: this.input.price,
                        note: this.input.note,
                        sort: this.input.sort
                    })
                    .then(res => {
                        this.sweetalert("edit");
                        this.clear();
                        //兩個方法都可以重新渲染
                        this.$set(this.product_data, index, res.data);
                        // this.product_data.splice(index,1, res.data)
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        },
        //刪除
        deletedata(index) {
            //console.log(index);
            let target = this.product_data[index];

            Swal.fire({
                title: `確定要刪除 ${target.title} ?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "確定",
                cancelButtonText: "取消"
            }).then(result => {
                if (result.value) {
                    axios
                        .delete("/admin/liqueurProduct/" + target.id)
                        .then(res => {
                            this.product_data.splice(index, 1);
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
            let target = this.product_data[index];
            console.log(index);
            console.log(target);

            axios
                .get(`/admin/liqueurProduct/${target.id}/edit`)
                .then(res => {
                    //console.log(res.data);
                    this.input.index = index;
                    this.input.edit = res.data.id;
                    this.input.oldimg = res.data.img;
                    this.input.liqueur_id = res.data.liqueur_id;
                    this.input.title = res.data.title;
                    this.input.content = res.data.content;
                    this.input.capacity = res.data.capacity;
                    this.input.density = res.data.density;
                    this.input.color = res.data.color;
                    this.input.aroma = res.data.aroma;
                    this.input.body = res.data.body;
                    this.input.taste = res.data.taste;
                    this.input.aftertaste = res.data.aftertaste;
                    this.input.price = res.data.price;
                    this.input.note = res.data.note;
                    this.input.sort = res.data.sort;
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
                    .post("/admin/liqueurProduct_upload_img", fd)
                    .then(response => (this.input.oldimg = response.data))
                    .catch(function (error) {
                        console.log(error);
                    });
            } else {
                axios
                    .post("/admin/liqueurProduct_delete_img", {
                        file_link: this.input.oldimg
                    })
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                this.input.newimg = event.target.files[0];
                const fd = new FormData();
                fd.append("file", this.input.newimg, this.input.newimg.name);
                axios
                    .post("/admin/liqueurProduct_upload_img", fd)
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
                (this.input.content = ""),
                (this.input.title = ""),
                (this.input.liqueur_id = ""),
                (this.input.capacity = ""),
                (this.input.density = ""),
                (this.input.color = ""),
                (this.input.aroma = ""),
                (this.input.body = ""),
                (this.input.taste = ""),
                (this.input.aftertaste = ""),
                (this.input.price = ""),
                (this.input.note = ""),
                (this.input.sort = ""),
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
