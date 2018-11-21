<template>
    <div>
        <el-breadcrumb separator-class="el-icon-arrow-right">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item :to="{ path: '/tags' }">标签列表</el-breadcrumb-item>
            <el-breadcrumb-item>编辑标签</el-breadcrumb-item>
        </el-breadcrumb>

        <div class="hengxian"></div>

        <el-form :model="tag" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">
            <el-form-item label="标签分类" prop="site_node_id">
                <el-select v-model="tag.course_node_id" placeholder="请选择标签分类">
                    <el-option v-for="item in course_nodes"
                               :key="item.id"
                               :label="item.name"
                               :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>

            <el-form-item label="标签名称" prop="name">
                <el-input v-model="tag.name"></el-input>
            </el-form-item>

            <el-form-item label="是否显示" prop="is_show">
                <el-switch v-model="tag.is_show"></el-switch>
            </el-form-item>

            <el-form-item label="排序" :label-width="formLabelWidth" prop="sort">
                <el-input-number v-model="tag.sort" @change="handleChange" :min="1" :max="99"
                                 label="描述文字"></el-input-number>
            </el-form-item>

            <el-form-item>
                <el-button type="primary" @click="submitForm('ruleForm')">立即创建</el-button>
                <el-button @click="resetForm('ruleForm')">重置</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                course_nodes: [],
                tag: {
                    course_node_id: '',
                    name: '',
                    is_show: true,
                    sort:'99',
                },
                rules: {
                    course_node_id: [
                        {required: true, message: '请选择标签分类', trigger: 'change'}
                    ],
                    name: [
                        {required: true, message: '请输入标签名称', trigger: 'blur'},
                        {min: 2, max: 20, message: '长度在 2 到 20 个字符', trigger: 'blur'}
                    ],
                }
            };
        },
        created() { //构造函数
            this.init()
        },
        methods: {
            init() {
                //所有分类
                axios.get(`/admin/course_nodes`)
                    .then((res) => {
                        //console.log(res)
                        this.course_nodes = res.data;
                    })
                let id= this.$route.params.id;
                axios.get(`/admin/tags/${id}/edit`)
                    .then((res) => {
                        //console.log(res)
                        this.tag = res.data;
                        let data =this.tag.is_show;//单独取值
                        this.tag.is_show =!!data;//重新赋值
                    })
            },
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        axios.put(`/admin/tags/${this.tag.id}`, this.tag)
                            .then((res) => {
                                this.$message({
                                    message: '(∩ _ ∩)编辑成功',
                                    type: 'success'
                                });
                                this.init();
                                this.$router.push({name: 'tags'})
                            });
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            handleChange(value) {
                console.log(value);
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            },

        }
    }
</script>

<style>
    .demo-ruleForm {
        margin-top: 30px;
    }
</style>