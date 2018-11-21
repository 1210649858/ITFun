<template>
    <div>
        <el-breadcrumb separator-class="el-icon-arrow-right">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>课程管理</el-breadcrumb-item>
            <el-breadcrumb-item>课程概览</el-breadcrumb-item>
        </el-breadcrumb>
        <div class="hengxian"></div>

        <el-table :data="course_nodes" style="width: 100%">
            <el-table-column prop="name" width="200"></el-table-column>
            <el-table-column>
                <template slot-scope="scope">
                    <el-tag v-for="tag in scope.row.tags" :key="tag.id" class="el_tag">
                        <router-link :to="{name:'tagEdit',params:{id:tag.id}}">
                            {{tag.name}}
                        </router-link>
                    </el-tag>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                course_nodes: [],
            }
        },
        created() { //构造函数
            this.init()
        },
        methods: {
            init() {
                axios.get(`/admin/overviews`)
                    .then((res) => {
                        //console.log(res)
                        this.course_nodes = res.data;
                    })
            },
        }
    }
</script>

<style>
    .hengxian {
        margin-top: 10px;
        border-top: 1px solid #eeeeee;
    }
    .el_tag {
        margin: 5px 5px;
        float: left;
    }
</style>