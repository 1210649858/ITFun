<template>
    <div>
        <el-breadcrumb separator-class="el-icon-arrow-right">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>课程管理</el-breadcrumb-item>
            <el-breadcrumb-item>课程分类</el-breadcrumb-item>
        </el-breadcrumb>

        <div class="hengxian"></div>

        <el-button type="success" size="small" class="create" @click="Create = true">新增分类</el-button>
        <el-button type="danger" size="small" class="el-icon-delete" @click="destroyChecked"> 删除</el-button>

        <el-table :data="course_nodes" style="width: 100% ;margin-top: 5px" @selection-change="check">
            <el-table-column type="selection"></el-table-column>
            <el-table-column label="编号" prop="id" width="80"></el-table-column>
            <el-table-column label="名称" width="150">
                <template slot-scope="scope">
                    <el-button type="warning" size="mini">{{ scope.row.name}}</el-button>
                </template>
            </el-table-column>
            <el-table-column label="slug" prop="slug"></el-table-column>
            <el-table-column label="排序" prop="sort" width="80">
                <template slot-scope="scope">
                    <el-input v-model="scope.row.sort"  @change="change(scope.$index, scope.row)" size="small"></el-input>
                </template>
            </el-table-column>
            <el-table-column label="操作">
                <template slot-scope="scope">
                    <el-button size="mini" @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                    <el-button size="mini" type="danger" @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <!--新增模态框-->
        <el-dialog title="新增分类" :visible.sync="Create">
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">
                <el-form-item label="分类名" prop="name">
                    <el-input v-model="ruleForm.name"></el-input>
                </el-form-item>

                <el-form-item label="slug" prop="slug">
                    <el-input v-model="ruleForm.slug"></el-input>
                </el-form-item>

                <el-form-item label="排序" :label-width="formLabelWidth">
                    <el-input-number v-model="ruleForm.sort" @change="handleChange" :min="1" :max="99"
                                     label="描述文字"></el-input-number>
                </el-form-item>


                <el-form-item>
                    <el-button type="primary" @click="submitForm('ruleForm')">立即创建</el-button>
                    <el-button @click="resetForm('ruleForm')">重置</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
        <!--新增模态框-->

        <!--编辑模态框-->
        <el-dialog title="编辑分类" :visible.sync="Edit">
            <el-form :model="course_node" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">
                <el-form-item label="分类名" prop="name">
                    <el-input v-model="course_node.name"></el-input>
                </el-form-item>

                <el-form-item label="slug" prop="slug">
                    <el-input v-model="course_node.slug"></el-input>
                </el-form-item>

                <el-form-item label="排序" :label-width="formLabelWidth">
                    <el-input-number v-model="course_node.sort" @change="handleChange" :min="1" :max="99"
                                     label="描述文字"></el-input-number>
                </el-form-item>


                <el-form-item>
                    <el-button type="primary" @click="updateForm('ruleForm')">立即创建</el-button>
                    <el-button @click="resetForm('ruleForm')">重置</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
        <!--编辑模态框-->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                course_nodes: [],
                course_node: {},
                Create: false,
                Edit: false,
                ruleForm: {
                    name: '',
                    slug:'',
                    sort: '99',
                },
                rules: {
                    name: [
                        {required: true, message: '请输入分类名', trigger: 'blur'},
                        {min: 2, max: 10, message: '长度在 2 到 10 个字符', trigger: 'blur'}
                    ],
                    slug: [
                        {required: true, message: '请输入slug', trigger: 'blur'},
                        {min: 2, max: 10, message: '长度在 2 到 10 个字符', trigger: 'blur'}
                    ],
                },
                formLabelWidth: '100px',
                Selection:[]
            }
        },
        created() { //构造函数
            this.init()
        },
        methods: {
            init() {
                axios.get(`/admin/course_nodes`)
                    .then((res) => {
                        //console.log(res)
                        this.course_nodes = res.data;
                    })
            },
            //新增
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        axios.post(`/admin/course_nodes`, this.ruleForm)
                            .then((res) => {
                                this.Create = false;
                                this.$message({
                                    message: '(＾－＾)新增成功',
                                    type: 'success'
                                });
                                this.init();
                                this.$router.push({name: 'course_nodes'})
                            });
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            //重置
            resetForm(formName) {
                this.$refs[formName].resetFields();
            },
            //获取编辑ID
            handleEdit(index, row) {
                this.Edit = true;
                axios.get(`/admin/course_nodes/${row.id}/edit`)
                    .then((res) => {
                        this.course_node = res.data;
                    })
            },
            //编辑
            updateForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        axios.put(`/admin/course_nodes/${this.course_node.id}`, this.course_node)
                            .then((res) => {
                                this.Edit = false;
                                this.$message({
                                    message: '(∩ _ ∩)编辑成功',
                                    type: 'success'
                                });
                                this.init();
                                this.$router.push({name: 'course_nodes'})
                            });
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            //删除
            handleDelete(index, row) {
                this.$confirm('亲 (●ﾟωﾟ●)确定要删除吗?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    axios.delete(`/admin/course_nodes/${row.id}`)
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
            //多选
            check(val){
                this.Selection = val;
            },
            //多选删除
            destroyChecked(){
                if (this.Selection.length == 0) {
                    this.$message.error('您至少要选中一条记录~');
                }else {
                    this.$confirm('亲 (●ﾟωﾟ●)确定要删除吗?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                    }).then(() => {
                        let checked_id = this.Selection.map((item) => {
                            return item.id;
                        });
                        axios.post(`/admin/course_nodes/destroy_checked`,{checked_id:checked_id})
                            .then(() => {
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
                }
            },
            handleChange(val) {
                //console.log(val);
            },
            change(index, row) {
                axios.patch(`/admin/course_nodes/change_sort`,row)
                    .then(() => {
                        this.$message({
                            type: 'success',
                            message: '排序成功!'
                        });
                        this.init();
                    });
            },
        }
    }
</script>

<style>
    .create {
        margin-top: 20px;
    }

    .hengxian {
        margin-top: 20px;
        border-top: 1px solid #eeeeee;
    }
</style>