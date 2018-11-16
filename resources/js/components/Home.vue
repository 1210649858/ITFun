<template>
    <div>
        <el-carousel :interval="4000" type="card" height="260px">
            <el-carousel-item v-for="item in items" :key="item.id">
                <img :src="item.url">
            </el-carousel-item>
        </el-carousel>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                items:[
                    {id:1,url:'https://images.itfun.tv/photo/2017/eba4bebb4c7520bca5b21d9c5276f763.jpg'},
                    {id:2,url:'https://images.itfun.tv/photo/2017/a0d11761646f9e7e967261aad86f5ed0.jpg'},
                    {id:3,url:'https://images.itfun.tv/photo/2018/01bd9a2af1839d826cf5521627ced567.jpg'},
                    {id:4,url:'https://images.itfun.tv/photo/2017/38f78c60568fc2ad56c79dea46248d8a.jpg'},
                    {id:5,url:'https://images.itfun.tv/photo/2017/01823aa6da9745bfef6f5960b4f503b2.jpg'},
                    {id:6,url:'https://images.itfun.tv/photo/2017/fa72168bc8840e2f299b9a90e752b2d9.jpg'},
                ]
            };
        },
    }
</script>

<style>
    .el-carousel__item h3 {
        color: #475669;
        font-size: 14px;
        opacity: 0.75;
        line-height: 600px;
        margin: 0;
    }

    .el-carousel__item:nth-child(2n) {
        background-color: #99a9bf;
    }

    .el-carousel__item:nth-child(2n+1) {
        background-color: #d3dce6;
    }
</style>
