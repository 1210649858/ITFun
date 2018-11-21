<template>
    <div>
        <el-breadcrumb separator-class="el-icon-arrow-right">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>课程章节</el-breadcrumb-item>
            <el-breadcrumb-item>章节列表</el-breadcrumb-item>
        </el-breadcrumb>
        <div class="hengxian"></div>

        <router-link :to="{ name: 'chapters_create'}">
            <el-button type="success" size="small" class="create">新增章节</el-button>
        </router-link>

        <el-table :data="chapters" style="width: 100%">
            <el-table-column label="编号" prop="id" width="50"></el-table-column>
            <el-table-column label="名称" prop="title" show-overflow-tooltip width="400">
                <template slot-scope="scope">
                    <a class="show_notice" href="https://laravelacademy.org/post/9567.html">{{scope.row.title}}</a>
                </template>
            </el-table-column>
            <el-table-column label="免费" prop="free" width="200">
                <template slot-scope="scope">
                    <i :class="scope.row.free ? 'el-icon-check' : 'el-icon-close'" @click="change_attr(scope.row)"></i>
                </template>
            </el-table-column>
            <el-table-column label="发布" prop="publish">
                <template slot-scope="scope">
                    <el-tag type="warning" v-if="scope.row.publish == 0">待发布</el-tag>
                    <el-tag type="success" v-else="scope.row.publish == 1">已发布</el-tag>
                </template>
            </el-table-column>
            <el-table-column label="排序" prop="sort" width="100">
                <template slot-scope="scope">
                    <el-input v-model="scope.row.sort" size="small" @change="handleChange(scope.row.id,scope.row.sort)"></el-input>
                </template>
            </el-table-column>
            <el-table-column label="操作">
                <template slot-scope="scope">
                    <router-link :to="{ name: 'chapters_edit', params: { course_id: course_id,id: scope.row.id }}">
                        <el-button size="mini">编辑</el-button>
                    </router-link>
                    <el-button size="mini" type="danger" @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                chapters: [],
                course_id: '',
            }
        },
        created() { //构造函数
            this.init()
        },
        methods: {
            init() {
                let course_id = this.$route.params.course_id
                this.course_id = course_id;
                axios.get(`/admin/courses/${course_id}/edit`)
                    .then((res) => {
                        //console.log(res);
                        this.chapters = res.data.chapters.chapters;
                    })
            },
            courseCreate() {
                this.$router.push({name: 'courseCreate'})
            },
            //是否免费
            change_attr(row) {
                axios.patch(`/admin/chapters/change_attr`, {
                    id: row.id,
                    free: row.free
                }).then((res) => {
                    this.$message({
                        type: 'success',
                        message: '改变成功!',
                    });
                    this.init();
                })
            },
            //排序
            handleChange(row, sort_value) {
                axios.patch(`/admin/chapters/change_sort`, {
                    id: row,
                    sort: sort_value
                }).then((res) => {
                    this.$message({
                        type: 'success',
                        message: '排序成功!',
                    });
                    this.init();
                })
            },
            handleDelete(index, row) {
                this.$confirm('亲 (●ﾟωﾟ●)确定要删除吗?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    axios.delete(`/admin/chapters/${row.id}`)
                        .then((res) => {
                            this.$message({
                                type: 'success',
                                message: 'OK,删除成功!'
                            });
                            this.init();
                        });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                });
            },
        }
    }
</script>

<style>
    .hengxian {
        margin-top: 10px;
        border-top: 1px solid #eeeeee;
    }
    .create {
        margin-top: 20px;
    }

    .el-icon-check {
        color: #5EB95E;
        font-weight: bold;
        cursor: pointer;
    }

    .el-icon-close {
        color: red;
        font-weight: bold;
        cursor: pointer;
    }

</style>