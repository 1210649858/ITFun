<template>
    <div>
        <el-carousel :interval="4000" type="card" height="260px">
            <el-carousel-item v-for="item in items" :key="item.id">
                <img :src="item.url">
            </el-carousel-item>
        </el-carousel>

        <el-alert class="home_desc" title="ITFun.tv后台管理系统" type="success" :closable="false"
                  description="这是一个基于Laravel集成ElementUI使用接口开发模式开发的一套后台管理系统。主要业务用于管理ITFun后台的各个模块，如：酷站管理、广告管理、新闻管理、课程管理、用户管理等。
            本次项目由长乐教育黄老师开发完成，其中包含使用的技术点有：
            1、在Laravel框架的基础上集成ElementUI前端框架。实现多用户登录，后台管理员'Admin',前端用户'User'，后台管理员登录后，前端通过设置全局session获取用户信息。
            2、模态框技术的使用，部分模块的新增、编辑使用模态框，功能完善，页面不刷新。
            3、页面布局、搜索、分页、单选/多选删除。
            4、本次系统还在不断完善中，敬请期待....
            "
                  show-icon>
        </el-alert>

        <el-alert
                title="辅助工具和资料"
                type="warning"
                description="1、phpstrom编辑器 2、mamp集成开发环境 3、api接口测试软件postman 4、laravel和 elementUI开发文档 5、Git版本控制"
                :closable="false"
                show-icon>
        </el-alert>
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

    .el-alert__title.is-bold {
        font-weight: 900;
    }

    .el-alert__title {
        font-size: 25px;
        line-height: 30px;
    }

    .el-alert .el-alert__description {
        font-size: 14px;
        margin: 10px 0 0;
    }

    .el-alert--warning{
        margin-top: 10px;
    }
    .some_total{
        margin-top: 50px;
    }
</style>
