<template>
    <div>
        <el-breadcrumb separator-class="el-icon-arrow-right">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>课程管理</el-breadcrumb-item>
            <el-breadcrumb-item>课程列表</el-breadcrumb-item>
        </el-breadcrumb>
        <div class="hengxian"></div>

        <el-form :inline="true" :model="search" class="search" ref="ruleForm">
            <el-form-item>
                <el-button type="success" size="small" @click="courseCreate">新增课程</el-button>
            </el-form-item>
            <el-form-item label="课程内容" prop="keyword">
                <el-input size="small" v-model="search.keyword" placeholder="请输入课程内容"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button size="small" type="warning" @click="searchname" icon="el-icon-search">搜 索</el-button>
                <el-button size="small" type="info" @click="resetForm('ruleForm')" icon="el-icon-refresh">重 置</el-button>
            </el-form-item>
        </el-form>

        <el-table :data="courses" style="width: 100%">
            <el-table-column label="编号" prop="id" width="50"></el-table-column>
            <el-table-column label="缩略图" width="100">
                <template slot-scope="scope">
                    <img :src="scope.row.photo.image"style="width: 60px;height: 60px">
                </template>
            </el-table-column>
            <el-table-column label="课程名称" prop="name" width="100" show-overflow-tooltip>
                <template slot-scope="scope">
                    <a class="show_notice" href="https://laravelacademy.org/laravel-docs-5_7" target="_blank">{{scope.row.name}}</a>
                </template>
            </el-table-column>
            <el-table-column label="价格" prop="price" width="100"></el-table-column>
            <el-table-column label="标签" prop="course_id" width="200">
                <template slot-scope="scope">
                    <el-tag v-for="idem in scope.row.course" :key="idem.id">
                        {{idem.name}}
                    </el-tag>
                </template>
            </el-table-column>

            <el-table-column label="喜欢" prop="likes_count" width="50">
                    <el-tag></el-tag>
            </el-table-column>
            <el-table-column label="推荐" prop="best" width=80>
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.best == 1">推荐</el-tag>
                </template>
            </el-table-column>
            <el-table-column label="发布" prop="publish" width="80">
                <template slot-scope="scope">
                    <el-tag type="warning" v-if="scope.row.publish == 1">发布</el-tag>
                </template>
            </el-table-column>
            <el-table-column label="完结" prop="complete" width="80">
                <template slot-scope="scope">
                    <el-tag type="success" v-if="scope.row.complete == 1">完结</el-tag>
                </template>
            </el-table-column>

            <el-table-column label="创建时间" width="150">
                <template slot-scope="scope">
                    <i class="el-icon-time"></i><span style="margin-left: 10px">{{ scope.row.created_at | edit_date}}</span>
                </template>
            </el-table-column>
            <el-table-column label="操作" width="150">
                <template slot-scope="scope">
                    <router-link :to="{ name:'courseEdit',params: { id: scope.row.id }}">
                        <el-button type="primary" icon="el-icon-edit" circle></el-button>
                    </router-link>
                    <router-link :to="{ name:'chapters',params: { course_id: scope.row.id }}">
                        <el-button type="warning" icon="el-icon-document" circle></el-button>
                    </router-link>
                    <el-button type="danger" icon="el-icon-delete" circle @click="courseDelete(scope.$index, scope.row)"></el-button>
                </template>
            </el-table-column>
        </el-table>
        <div class="block el-pagination" style="float: left;margin-top: 10px;">
            <span class="el-pagination__total" style="margin-left: 20%;">共 {{page.total}} 条数据</span>
            <!--分页-->
            <el-pagination background layout="prev, pager, next"
                           :total="page.total" :page-size="page.size"
                           @current-change="changePage" :current-page.sync="page.currentPage"
                           style="margin-top:-30px;margin-left:300%">
            </el-pagination>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                courses: [],
                search: {
                    keyword: '',
                },
                page: {
                    total: 0,
                    size: 0,
                    currentPage: 1,
                    num: 1
                }
            }
        },
        created() { //构造函数
            this.init()
        },
        filters:{
            edit_date:function (val) {
                return val.substring(0,10)
            }
        },
        methods: {
            init() {
                axios.get(`/admin/courses?page=${this.page.num}&keyword=${this.search.keyword}`)
                    .then((res) => {
                        //console.log(res)
                        this.courses = res.data.data;
                        this.page.total = res.data.total;
                        this.page.size = res.data.per_page;
                    })
            },
            courseCreate() {
                this.$router.push({name: 'courseCreate'})
            },
            courseDelete(index, row) {
                this.$confirm('亲 (●ﾟωﾟ●)确定要删除吗?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    axios.delete(`/admin/courses/${row.id}`)
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
            //选择页码
            changePage(val) {
                this.page.num = val;
                this.init()
            },
            //搜索
            searchname() {
                this.init();
            },
            //重置
            resetForm(formName) {
                this.$refs[formName].resetFields();
                this.init();
            },
        }
    }
</script>

<style>
    .search {
        margin-top: 10px;
    }

    .hengxian {
        margin-top: 10px;
        border-top: 1px solid #eeeeee;
    }
</style>