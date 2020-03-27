<template>
    <table id="example" class="table table-striped table-bordered " style="width:100%">
        <thead>
            <tr>
                <th>img</th>
                <th>name</th>
                <th>title</th>
                <th>content</th>
                <th>sort</th>
                <th width='80px'></th>
            </tr>
        </thead>
        <tbody class="tbody">


            <tr v-for="item in liqueur_kind">
                <td>

                        <img :src="item.img" alt="" srcset="" class="img-fluid">


                </td>
                <td></td>

                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
                <td>
                    <a href="#edit" class="btn btn-success btn-sm" data-toggle="collapse">修改</a>
                    <button class="btn btn-danger btn-sm" onclick="show_confirm()">刪除</button>


                </td>

            </tr>



        </tbody>


    </table>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')

        },
        created(){
            axios.post('/admin/liqueurStory_text')
                .then(response=>{this.liqueur_kind = response.data
                    this.upload()
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        data(){
            return{
               liqueur_kind:null,
               loading: true,
            }
        },
        methods:{
            upload(){
                $(document).ready(function() {
                $('#example').DataTable({
                    "order": [ 1, 'desc' ]
                });
            } );
            },
        }
    }

</script>
