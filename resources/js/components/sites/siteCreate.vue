<template>
    <div>
        <el-breadcrumb separator-class="el-icon-arrow-right">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item :to="{ path: '/sites' }">酷站列表</el-breadcrumb-item>
            <el-breadcrumb-item>新增酷站</el-breadcrumb-item>
        </el-breadcrumb>

        <div class="hengxian"></div>

        <el-form :model="site" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">
            <el-form-item label="酷站分类" prop="site_node_id">
                <el-select v-model="site.site_node_id" placeholder="请选择酷站分类">
                    <el-option v-for="item in site_nodes"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>

            <el-form-item label="酷站名称" prop="name">
                <el-input v-model="site.name"></el-input>
            </el-form-item>

            <el-form-item label="缩略图" prop="image">
                <el-upload
                        class="avatar-uploader"
                        action="/photos"
                        :show-file-list="false"
                        :on-success="handleAvatarSuccess"
                        :before-upload="beforeAvatarUpload">
                    <img v-if="site.image" :src="site.image" class="avatar">
                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                </el-upload>
            </el-form-item>

            <el-form-item label="是否显示" prop="is_show">
                <el-switch v-model="site.is_show"></el-switch>
            </el-form-item>

            <el-form-item label="酷站地址" prop="url">
                <el-input v-model="site.url"></el-input>
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
                site_nodes: [],
                site: {
                    site_node_id: '',
                    name: '',
                    is_show: false,
                    url: '',
                    image: '',
                    photo_id: '',
                },
                rules: {
                    site_node_id: [
                        {required: true, message: '请选择酷站分类', trigger: 'change'}
                    ],
                    name: [
                        {required: true, message: '请输入酷站名称', trigger: 'blur'},
                        {min: 2, max: 10, message: '长度在 2 到 10 个字符', trigger: 'blur'}
                    ],
                    url: [
                        {required: true, message: '请输入酷站网址', trigger: 'blur'},
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
                axios.get(`/admin/site_nodes`)
                    .then((res) => {
                        //console.log(res)
                        this.site_nodes = res.data;
                    })
            },
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        axios.post(`/admin/sites`, this.site)
                            .then((res) => {
                                this.$message({
                                    message: '(＾－＾)新增成功',
                                    type: 'success'
                                });
                                this.$router.push({name: 'sites'})
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

            handleAvatarSuccess(res, file) {
                this.site.image = res.image_url;
                this.site.photo_id = res.photo_id;
            },
            beforeAvatarUpload(file) {
                const isJPG = file.type === 'image/jpeg'||'image/png';
                const isLt3M = file.size / 1024 / 1024 < 3;

                if (!isJPG) {
                    this.$message.error('上传图片只能是 JPG/PNG 格式!');
                }
                if (!isLt3M) {
                    this.$message.error('上传图片大小不能超过 3MB!');
                }
                return isJPG && isLt3M;
            }
        }
    }
</script>

<style>
    .demo-ruleForm {
        margin-top: 30px;
    }

    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }

    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }

    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>