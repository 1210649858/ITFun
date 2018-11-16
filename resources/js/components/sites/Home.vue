<template>
    <div>
        <el-breadcrumb separator-class="el-icon-arrow-right">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>酷站管理</el-breadcrumb-item>
            <el-breadcrumb-item>酷站列表</el-breadcrumb-item>
        </el-breadcrumb>
        <div class="hengxian"></div>

        <el-form :inline="true" :model="search" class="search" ref="ruleForm">
            <el-form-item>
                <el-button type="success" size="small" @click="siteCreate">新增酷站</el-button>
            </el-form-item>
            <el-form-item label="所属分类" prop="site_node_id">
                <el-select size="small" v-model="search.site_node_id" filterable placeholder="请选择">
                    <el-option
                            v-for="item in site_nodes"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="酷站名称" prop="keyword">
                <el-input size="small" v-model="search.keyword"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button size="small" type="warning" @click="searchname" icon="el-icon-search">搜 索</el-button>
                <el-button size="small" type="info" @click="resetForm('ruleForm')" icon="el-icon-refresh">重 置</el-button>
            </el-form-item>
        </el-form>

        <el-table :data="sites" style="width: 100%">
            <el-table-column label="编号" prop="id" width="50"></el-table-column>
            <el-table-column label="酷站图片" width="150">
                <template slot-scope="scope">
                    <a :href="scope.row.url" target="_blank"><img :src="scope.row.photo.image"
                                                                  style="width: 60px;height: 60px"></a>
                </template>
            </el-table-column>
            <el-table-column label="酷站名称" prop="name" width="200"></el-table-column>
            <el-table-column label="所属分类" prop="site_node.name" width="150"></el-table-column>
            <el-table-column label="是否显示" width="150">
                <template slot-scope="scope" prop="is_show">
                    <i :class="scope.row.is_show ? 'el-icon-circle-check-outline' : 'el-icon-circle-close-outline'"
                       @click="change_attr(scope.row)"></i>
                    <!--<el-switch v-model="scope.row.is_show"></el-switch>-->
                </template>
            </el-table-column>

            <el-table-column label="创建时间" width="200">
                <template slot-scope="scope">
                    <i class="el-icon-time"></i><span style="margin-left: 10px">{{ scope.row.created_at | edit_date}}</span>
                </template>
            </el-table-column>
            <el-table-column label="操作" width="200">
                <template slot-scope="scope">
                    <router-link :to="{ name:'siteEdit',params: { id: scope.row.id }}">
                    <el-button size="mini" type="primary">编辑</el-button>
                    </router-link>
                    <el-button size="mini" type="danger" @click="siteDelete(scope.$index, scope.row)">删除</el-button>
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
                sites: [],
                site_nodes: [],
                search: {
                    site_node_id: '',
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
            //所有分类
            axios.get(`/admin/site_nodes`)
                .then((res) => {
                    //console.log(res)
                    this.site_nodes = res.data;
                })
        },
        filters:{
            edit_date:function (val) {
                return val.substring(0,10)
            }
        },
        methods: {
            init() {
                axios.get(`/admin/sites?page=${this.page.num}&keyword=${this.search.keyword}&site_node_id=${this.search.site_node_id}`)
                    .then((res) => {
                        //console.log(res)
                        this.sites = res.data.data;
                        this.page.total = res.data.total;
                        this.page.size = res.data.per_page;
                    })
            },
            siteCreate() {
                this.$router.push({name: 'siteCreate'})
            },
            siteDelete(index, row) {
                console.log(index, row);
            },
            //是否显示
            change_attr(row) {
                axios.patch(`/admin/site/change_attr`, {id: row.id, is_show: row.is_show})
                    .then((res) => {
                        this.$message({
                            type: 'success',
                            message: '改变成功!'
                        });
                        this.init()
                    })
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

    .el-icon-circle-check-outline {
        color: green;
    }

    .el-icon-circle-close-outline {
        color: red;
    }

    .el-icon-circle-check-outline, .el-icon-circle-close-outline {
        cursor: pointer;
        font-weight: bold;
        font-size: 160%;

    }
</style>