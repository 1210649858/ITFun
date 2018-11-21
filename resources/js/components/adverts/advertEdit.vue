<template>
    <div>
        <el-breadcrumb separator-class="el-icon-arrow-right">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item :to="{ path: '/adverts' }">广告列表</el-breadcrumb-item>
            <el-breadcrumb-item>编辑广告</el-breadcrumb-item>
        </el-breadcrumb>

        <div class="hengxian"></div>

        <el-form :model="advert" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">
            <el-form-item label="广告分类" prop="advert_node_id">
                <el-select v-model="advert.advert_node_id" placeholder="请选择广告分类">
                    <el-option v-for="item in advert_nodes"
                               :key="item.id"
                               :label="item.name"
                               :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>

            <el-form-item label="广告名称" prop="name">
                <el-input v-model="advert.name"></el-input>
            </el-form-item>

            <el-form-item label="缩略图" prop="photo_id">
                <el-upload
                        class="avatar-uploader"
                        action="/photos"
                        :show-file-list="false"
                        :on-success="handleAvatarSuccess"
                        :before-upload="beforeAvatarUpload">
                    <img v-if="photo.image" :src="photo.image" class="avatar">
                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                </el-upload>
            </el-form-item>

            <el-form-item label="排序" :label-width="formLabelWidth">
                <el-input-number v-model="advert.sort" @change="handleChange" :min="1" :max="99"
                                 label="描述文字"></el-input-number>
            </el-form-item>

            <el-form-item label="广告地址" prop="url">
                <el-input v-model="advert.url"></el-input>
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
                advert_nodes: [],
                fileList:[],
                advert: {
                    advert_node_id: '',
                    name: '',
                    url: '',
                    photo_id: '',
                    sort: '99',
                },
                photo:{
                    image:'',
                },
                rules: {
                    advert_node_id: [
                        {required: true, message: '请选择广告分类', trigger: 'change'}
                    ],
                    name: [
                        {required: true, message: '请输入广告名称', trigger: 'blur'},
                        {min: 2, max: 10, message: '长度在 2 到 10 个字符', trigger: 'blur'}
                    ],
                    url: [
                        {required: true, message: '请输入广告网址', trigger: 'blur'},
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
                axios.get(`/admin/advert_nodes`)
                    .then((res) => {
                        //console.log(res)
                        this.advert_nodes = res.data;
                    })
                let id= this.$route.params.id;
                axios.get(`/admin/adverts/${id}/edit`)
                    .then((res) => {
                        //console.log(res)
                        this.advert = res.data;
                        this.photo =res.data.photo;
                    })
            },
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        axios.put(`/admin/adverts/${this.advert.id}`, this.advert,this.photo)
                            .then((res) => {
                                this.$message({
                                    message: '(∩ _ ∩)编辑成功',
                                    type: 'success'
                                });
                                this.init();
                                this.$router.push({name: 'adverts'})
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
                this.photo.image = res.image_url;
                this.advert.photo_id = res.photo_id;
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